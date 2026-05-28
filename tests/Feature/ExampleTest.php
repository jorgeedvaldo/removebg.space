<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * The root path redirects to the default locale.
     */
    public function test_root_redirects_to_default_locale(): void
    {
        $this->get('/')->assertRedirect('/en');
    }

    /**
     * Each supported locale homepage renders successfully with the tool.
     *
     * @dataProvider localeProvider
     */
    public function test_locale_homepage_renders(string $locale): void
    {
        $response = $this->get('/' . $locale);

        $response->assertStatus(200);
        $response->assertSee('bgUploadArea', false);          // the background-remover tool
        $response->assertSee('application/ld+json', false);    // structured data for SEO
    }

    public function localeProvider(): array
    {
        return [
            'english'    => ['en'],
            'portuguese' => ['pt'],
            'spanish'    => ['es'],
            'french'     => ['fr'],
            'chinese'    => ['zh'],
            'hindi'      => ['hi'],
            'russian'    => ['ru'],
        ];
    }

    /**
     * The localized sitemap and RSS feed are available.
     */
    public function test_sitemap_and_feed_are_available(): void
    {
        $this->get('/sitemap.xml')->assertStatus(200);
        $this->get('/en/sitemap.xml')->assertStatus(200);
        $this->get('/en/feed.xml')->assertStatus(200);
    }
}
