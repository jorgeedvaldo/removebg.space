<?php

namespace Tests\Feature;

use App\Services\BackgroundRemover;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class BackgroundRemovalTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Use the CLI driver with a deterministic stub instead of the real AI.
        config([
            'bgremoval.driver' => 'process',
            'bgremoval.processor' => 'php ' . base_path('tests/stubs/stub-processor.php') . ' {input} {output}',
            'bgremoval.sweep_lottery' => 1000000, // effectively disable random sweeps in tests
        ]);

        $this->cleanStorage();
    }

    protected function tearDown(): void
    {
        $this->cleanStorage();

        parent::tearDown();
    }

    private function cleanStorage(): void
    {
        $base = app(BackgroundRemover::class)->baseDir();
        if (is_dir($base)) {
            foreach (glob($base . '/*', GLOB_ONLYDIR) ?: [] as $dir) {
                array_map('unlink', glob($dir . '/*') ?: []);
                @rmdir($dir);
            }
        }
    }

    public function test_it_removes_background_and_serves_a_png(): void
    {
        $response = $this->post('/remove-background', [
            'image' => UploadedFile::fake()->image('photo.png', 300, 300),
        ]);

        $response->assertStatus(200)
            ->assertJson(['ok' => true])
            ->assertJsonStructure(['ok', 'url', 'expires_in']);

        $url = $response->json('url');
        $this->assertStringContainsString('/r/', $url);

        $png = $this->get($url);
        $png->assertStatus(200);
        $this->assertSame('image/png', $png->headers->get('Content-Type'));
    }

    public function test_http_driver_calls_the_node_microservice(): void
    {
        // 1x1 transparent PNG bytes the fake worker will "return".
        $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+M8AAAMBAQDJ/pXkAAAAAElFTkSuQmCC');

        config([
            'bgremoval.driver' => 'http',
            'bgremoval.http_endpoint' => 'http://worker.test/remove',
            'bgremoval.http_secret' => 'shh',
        ]);

        \Illuminate\Support\Facades\Http::fake([
            'worker.test/*' => \Illuminate\Support\Facades\Http::response($png, 200, ['Content-Type' => 'image/png']),
        ]);

        $response = $this->post('/remove-background', [
            'image' => UploadedFile::fake()->image('photo.png', 120, 120),
        ]);

        $response->assertStatus(200)->assertJson(['ok' => true]);

        \Illuminate\Support\Facades\Http::assertSent(function ($request) {
            return $request->url() === 'http://worker.test/remove'
                && $request->hasHeader('X-Worker-Secret', 'shh');
        });

        $this->get($response->json('url'))
            ->assertStatus(200)
            ->assertHeader('Content-Type', 'image/png');
    }

    public function test_it_rejects_non_image_uploads(): void
    {
        $response = $this->postJson('/remove-background', [
            'image' => UploadedFile::fake()->create('document.txt', 10, 'text/plain'),
        ]);

        $response->assertStatus(422);
    }

    public function test_result_is_404_for_unknown_id(): void
    {
        $this->get('/r/' . \Illuminate\Support\Str::uuid())->assertStatus(404);
    }

    public function test_cleanup_deletes_expired_jobs_but_keeps_fresh_ones(): void
    {
        $remover = app(BackgroundRemover::class);

        // Fresh job (should survive).
        $freshId  = (string) \Illuminate\Support\Str::uuid();
        $freshDir = $remover->jobDir($freshId);
        mkdir($freshDir, 0775, true);
        file_put_contents($freshDir . '/output.png', 'x');

        // Expired job (mtime 40 minutes ago — past the 30-min retention).
        $oldId  = (string) \Illuminate\Support\Str::uuid();
        $oldDir = $remover->jobDir($oldId);
        mkdir($oldDir, 0775, true);
        $oldFile = $oldDir . '/output.png';
        file_put_contents($oldFile, 'x');
        touch($oldFile, time() - 40 * 60);
        touch($oldDir, time() - 40 * 60);

        $removed = $remover->cleanup();

        $this->assertGreaterThanOrEqual(1, $removed);
        $this->assertDirectoryDoesNotExist($oldDir);
        $this->assertDirectoryExists($freshDir);
    }
}
