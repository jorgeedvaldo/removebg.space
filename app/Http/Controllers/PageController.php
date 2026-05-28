<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Middleware\SetLocale;

class PageController extends Controller
{
    /**
     * Locale to HTML lang mapping
     */
    private $langMap = [
        'en' => 'en',
        'pt' => 'pt-BR',
        'es' => 'es',
        'fr' => 'fr',
        'zh' => 'zh-CN',
        'hi' => 'hi',
        'ru' => 'ru',
    ];

    /**
     * Homepage - AI Background Remover tool
     */
    public function index($locale)
    {
        return view('home', [
            'locale' => $locale,
            'htmlLang' => $this->langMap[$locale] ?? $locale,
            'locales' => SetLocale::LOCALES,
        ]);
    }

    /**
     * RSS Feed
     */
    public function feed($locale)
    {
        $lastMod = now()->toRfc2822String();
        $baseUrl = url($locale);

        $content = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $content .= '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">' . "\n";
        $content .= '<channel>' . "\n";
        $content .= '  <title>' . __('messages.rss_title') . '</title>' . "\n";
        $content .= '  <link>' . $baseUrl . '</link>' . "\n";
        $content .= '  <description>' . __('messages.rss_description') . '</description>' . "\n";
        $content .= '  <language>' . ($this->langMap[$locale] ?? $locale) . '</language>' . "\n";
        $content .= '  <lastBuildDate>' . $lastMod . '</lastBuildDate>' . "\n";
        $content .= '  <atom:link href="' . url($locale . '/feed.xml') . '" rel="self" type="application/rss+xml"/>' . "\n";
        $content .= '  <image>' . "\n";
        $content .= '    <url>' . asset('img/og-cover.png') . '</url>' . "\n";
        $content .= '    <title>' . __('messages.site_name') . '</title>' . "\n";
        $content .= '    <link>' . $baseUrl . '</link>' . "\n";
        $content .= '  </image>' . "\n";
        $content .= '  <item>' . "\n";
        $content .= '    <title>' . __('messages.rss_item1_title') . '</title>' . "\n";
        $content .= '    <link>' . $baseUrl . '#artigo</link>' . "\n";
        $content .= '    <guid isPermaLink="true">' . $baseUrl . '#artigo</guid>' . "\n";
        $content .= '    <description>' . __('messages.rss_item1_desc') . '</description>' . "\n";
        $content .= '    <pubDate>' . now()->subDays(30)->toRfc2822String() . '</pubDate>' . "\n";
        $content .= '  </item>' . "\n";
        $content .= '  <item>' . "\n";
        $content .= '    <title>' . __('messages.rss_item2_title') . '</title>' . "\n";
        $content .= '    <link>' . $baseUrl . '#ferramenta</link>' . "\n";
        $content .= '    <guid isPermaLink="true">' . $baseUrl . '#ferramenta</guid>' . "\n";
        $content .= '    <description>' . __('messages.rss_item2_desc') . '</description>' . "\n";
        $content .= '    <pubDate>' . now()->subDays(15)->toRfc2822String() . '</pubDate>' . "\n";
        $content .= '  </item>' . "\n";
        $content .= '  <item>' . "\n";
        $content .= '    <title>' . __('messages.rss_item3_title') . '</title>' . "\n";
        $content .= '    <link>' . $baseUrl . '#formatos</link>' . "\n";
        $content .= '    <guid isPermaLink="true">' . $baseUrl . '#formatos</guid>' . "\n";
        $content .= '    <description>' . __('messages.rss_item3_desc') . '</description>' . "\n";
        $content .= '    <pubDate>' . now()->subDays(7)->toRfc2822String() . '</pubDate>' . "\n";
        $content .= '  </item>' . "\n";
        $content .= '</channel>' . "\n";
        $content .= '</rss>';

        return response($content, 200)
            ->header('Content-Type', 'application/rss+xml; charset=UTF-8');
    }

    /**
     * Locale-specific Sitemap
     */
    public function sitemap($locale)
    {
        $lastmod = now()->toIso8601String();

        $content = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $content .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . "\n";
        $content .= '        xmlns:xhtml="http://www.w3.org/1999/xhtml">' . "\n";

        // Homepage
        $content .= '  <url>' . "\n";
        $content .= '    <loc>' . url($locale) . '</loc>' . "\n";
        $content .= '    <lastmod>' . $lastmod . '</lastmod>' . "\n";
        $content .= '    <changefreq>weekly</changefreq>' . "\n";
        $content .= '    <priority>1.0</priority>' . "\n";
        $content .= '  </url>' . "\n";

        $content .= '</urlset>';

        return response($content, 200)
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    /**
     * Global Sitemap Index
     */
    public function sitemapIndex()
    {
        $content = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $content .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach (SetLocale::LOCALES as $loc) {
            $content .= '  <sitemap>' . "\n";
            $content .= '    <loc>' . url($loc . '/sitemap.xml') . '</loc>' . "\n";
            $content .= '    <lastmod>' . now()->toIso8601String() . '</lastmod>' . "\n";
            $content .= '  </sitemap>' . "\n";
        }

        $content .= '</sitemapindex>';

        return response($content, 200)
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
