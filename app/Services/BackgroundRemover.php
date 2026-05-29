<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;
use Symfony\Component\Process\Exception\ProcessTimedOutException;
use Symfony\Component\Process\Process;

/**
 * Server-side background removal.
 *
 * Runs the configured processor command (a Node worker by default) to turn a
 * source image into a transparent PNG, and manages the temporary storage where
 * uploads/results are kept until they expire.
 */
class BackgroundRemover
{
    /**
     * Absolute path to the temporary working directory.
     */
    public function baseDir(): string
    {
        return storage_path('app/' . trim((string) config('bgremoval.directory', 'bg-removal'), '/'));
    }

    /**
     * Absolute path to the directory for a single job id.
     */
    public function jobDir(string $id): string
    {
        return $this->baseDir() . DIRECTORY_SEPARATOR . $id;
    }

    /**
     * Absolute path to a job's result PNG.
     */
    public function resultPath(string $id): string
    {
        return $this->jobDir($id) . DIRECTORY_SEPARATOR . 'output.png';
    }

    /**
     * Run the configured driver: read $inputPath, write a transparent PNG to
     * $outputPath.
     *
     * @throws RuntimeException when the removal fails or produces no output.
     */
    public function remove(string $inputPath, string $outputPath): void
    {
        if (config('bgremoval.driver') === 'http') {
            $this->removeViaHttp($inputPath, $outputPath);
        } else {
            $this->removeViaProcess($inputPath, $outputPath);
        }

        if (! is_file($outputPath) || filesize($outputPath) === 0) {
            throw new RuntimeException('Processor produced no output.');
        }
    }

    /**
     * HTTP driver — POST the raw image to a persistent Node micro-service and
     * store the returned PNG. Ideal for cPanel "Setup Node.js App" (Passenger).
     */
    private function removeViaHttp(string $inputPath, string $outputPath): void
    {
        $endpoint = (string) config('bgremoval.http_endpoint');
        $secret   = (string) config('bgremoval.http_secret');

        $request = Http::timeout((int) config('bgremoval.timeout', 120))
            ->withBody(file_get_contents($inputPath), 'application/octet-stream')
            ->withHeaders(['Accept' => 'image/png']);

        if ($secret !== '') {
            $request = $request->withHeaders(['X-Worker-Secret' => $secret]);
        }

        try {
            $response = $request->post($endpoint);
        } catch (\Throwable $e) {
            throw new RuntimeException('Worker request failed: ' . $e->getMessage(), 0, $e);
        }

        if (! $response->successful()) {
            throw new RuntimeException('Worker returned HTTP ' . $response->status());
        }

        file_put_contents($outputPath, $response->body());
    }

    /**
     * Process driver — spawn a CLI command per request (needs exec/proc_open).
     */
    private function removeViaProcess(string $inputPath, string $outputPath): void
    {
        $template = (string) config('bgremoval.processor');

        $command = str_replace(
            ['{input}', '{output}'],
            [escapeshellarg($inputPath), escapeshellarg($outputPath)],
            $template
        );

        $process = Process::fromShellCommandline($command, base_path());
        $process->setTimeout((float) config('bgremoval.timeout', 120));

        try {
            $process->run();
        } catch (ProcessTimedOutException $e) {
            throw new RuntimeException('Background removal timed out.', 0, $e);
        }

        if (! $process->isSuccessful()) {
            $err = trim($process->getErrorOutput() ?: $process->getOutput());
            throw new RuntimeException('Processor failed: ' . ($err !== '' ? $err : 'unknown error'));
        }
    }

    /**
     * Whether a job's result still exists and has not yet expired.
     */
    public function isAvailable(string $id): bool
    {
        $path = $this->resultPath($id);

        if (! is_file($path)) {
            return false;
        }

        if ($this->isExpired($path)) {
            $this->deleteJob($id);

            return false;
        }

        return true;
    }

    /**
     * Delete every expired job directory. Returns the number removed.
     */
    public function cleanup(): int
    {
        $base = $this->baseDir();

        if (! is_dir($base)) {
            return 0;
        }

        $removed = 0;

        foreach (glob($base . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR) ?: [] as $dir) {
            // Use the newest file in the dir as the reference timestamp.
            $reference = $this->newestMtime($dir);

            if ($reference !== null && $this->isExpiredAt($reference)) {
                $this->deleteDir($dir);
                $removed++;
            }
        }

        return $removed;
    }

    /**
     * Occasionally run cleanup so retention holds even without a cron scheduler.
     */
    public function sweepOccasionally(): void
    {
        $lottery = max(1, (int) config('bgremoval.sweep_lottery', 20));

        if (random_int(1, $lottery) === 1) {
            $this->cleanup();
        }
    }

    public function deleteJob(string $id): void
    {
        $this->deleteDir($this->jobDir($id));
    }

    public function retentionSeconds(): int
    {
        return max(60, (int) config('bgremoval.retention_minutes', 30) * 60);
    }

    private function isExpired(string $path): bool
    {
        return $this->isExpiredAt((int) filemtime($path));
    }

    private function isExpiredAt(int $mtime): bool
    {
        return (time() - $mtime) > $this->retentionSeconds();
    }

    private function newestMtime(string $dir): ?int
    {
        $newest = null;

        foreach (glob($dir . DIRECTORY_SEPARATOR . '*') ?: [] as $file) {
            $m = (int) filemtime($file);
            if ($newest === null || $m > $newest) {
                $newest = $m;
            }
        }

        // Fall back to the directory's own mtime if it is empty.
        return $newest ?? (is_dir($dir) ? (int) filemtime($dir) : null);
    }

    private function deleteDir(string $dir): void
    {
        if (! is_dir($dir)) {
            return;
        }

        foreach (glob($dir . DIRECTORY_SEPARATOR . '*') ?: [] as $file) {
            if (is_file($file)) {
                @unlink($file);
            }
        }

        @rmdir($dir);
    }
}
