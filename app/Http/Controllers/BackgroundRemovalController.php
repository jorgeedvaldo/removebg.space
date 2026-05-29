<?php

namespace App\Http\Controllers;

use App\Services\BackgroundRemover;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Throwable;

class BackgroundRemovalController extends Controller
{
    public function __construct(private BackgroundRemover $remover)
    {
    }

    /**
     * Accept an uploaded image, remove its background on the server and return
     * a temporary URL to the transparent PNG result.
     */
    public function process(Request $request): JsonResponse
    {
        $request->validate([
            'image' => [
                'required',
                'file',
                'mimetypes:' . implode(',', config('bgremoval.allowed_mimetypes')),
                'max:' . config('bgremoval.max_file_kb'),
            ],
        ]);

        // Keep the temporary storage tidy even without a configured scheduler.
        $this->remover->sweepOccasionally();

        $id      = (string) Str::uuid();
        $jobDir  = $this->remover->jobDir($id);
        $file    = $request->file('image');
        $ext     = $file->extension() ?: 'img';

        if (! is_dir($jobDir) && ! mkdir($jobDir, 0775, true) && ! is_dir($jobDir)) {
            return response()->json(['ok' => false, 'message' => 'storage_error'], 500);
        }

        $inputPath  = $jobDir . DIRECTORY_SEPARATOR . 'input.' . $ext;
        $outputPath = $this->remover->resultPath($id);

        $file->move($jobDir, 'input.' . $ext);

        try {
            $this->remover->remove($inputPath, $outputPath);
        } catch (Throwable $e) {
            report($e);
            $this->remover->deleteJob($id);

            return response()->json(['ok' => false, 'message' => 'processing_failed'], 422);
        }

        // The source image is no longer needed; drop it immediately.
        @unlink($inputPath);

        return response()->json([
            'ok'         => true,
            'url'        => route('bg.result', ['id' => $id]),
            'expires_in' => $this->remover->retentionSeconds(),
        ]);
    }

    /**
     * Serve a previously produced result PNG (until it expires).
     */
    public function result(string $id)
    {
        if (! Str::isUuid($id) || ! $this->remover->isAvailable($id)) {
            abort(404);
        }

        return response()->file($this->remover->resultPath($id), [
            'Content-Type'  => 'image/png',
            'Cache-Control' => 'private, max-age=' . $this->remover->retentionSeconds(),
        ]);
    }
}
