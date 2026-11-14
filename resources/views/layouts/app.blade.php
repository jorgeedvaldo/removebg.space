<!DOCTYPE html>
<html lang="{{ $htmlLang ?? 'en' }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#2563EB">

    {{-- Google AdSense --}}
    <meta name="google-adsense-account" content="ca-pub-2118765549976668">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2118765549976668"
        crossorigin="anonymous"></script>

    {{-- Analytics placeholder — replace G-XXXXXXXXXX with your own Measurement ID --}}
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-LXSR8R77XT"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-LXSR8R77XT');
    </script>

    {{-- SEO Meta --}}
    <title>@yield('title', __('messages.meta_title'))</title>
    <meta name="description" content="@yield('meta_description', __('messages.meta_description'))">
    <meta name="keywords"
        content="remove background, background remover, remove bg, transparent background, remove background from image, free background remover, ai background remover, remover fundo, quitar fondo, png transparent">
    <meta name="author" content="RemoveBG">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Hreflang tags for SEO --}}
    @php
        $currentPath = request()->path();
        $pathSuffix  = '';
        foreach (($locales ?? ['en','pt','es','fr','zh','hi','ru']) as $_l) {
            $stripped = ltrim(str_replace($_l, '', $currentPath), '/');
            if ($stripped && $stripped !== $currentPath) { $pathSuffix = '/' . $stripped; break; }
        }
    @endphp
    @foreach(($locales ?? ['en', 'pt', 'es', 'fr', 'zh', 'hi', 'ru']) as $loc)
        <link rel="alternate" hreflang="{{ $loc }}" href="{{ url($loc . $pathSuffix) }}">
    @endforeach
    <link rel="alternate" hreflang="x-default" href="{{ url('en' . $pathSuffix) }}">

    {{-- OpenGraph --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('og_title', __('messages.og_title'))">
    <meta property="og:description" content="@yield('og_description', __('messages.og_description'))">
    <meta property="og:image" content="@yield('og_image', asset('img/og-cover.png'))">
    <meta property="og:locale" content="{{ $htmlLang ?? 'en' }}">
    <meta property="og:site_name" content="RemoveBG">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', __('messages.og_title'))">
    <meta name="twitter:description" content="@yield('og_description', __('messages.og_description'))">
    <meta name="twitter:image" content="@yield('og_image', asset('img/og-cover.png'))">

    {{-- RSS Feed --}}
    <link rel="alternate" type="application/rss+xml" title="RemoveBG RSS Feed"
        href="{{ url(($locale ?? 'en') . '/feed.xml') }}">

    {{-- Sitemap --}}
    <link rel="sitemap" type="application/xml" title="Sitemap" href="{{ url('/sitemap.xml') }}">

    {{-- Favicon / App icons --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    {{-- Bootstrap 5 CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    {{-- Page styles (inline — no external stylesheet or font) --}}
    <style>
        :root {
            --rb-primary: #2563eb;
            --rb-primary-dark: #1d4ed8;
            --rb-ink: #0f172a;
            --rb-muted: #64748b;
            --rb-soft: #eef2ff;
            --rb-border: #e2e8f0;
        }
        html { scroll-behavior: smooth; scroll-padding-top: 76px; }
        body {
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif;
            color: var(--rb-ink);
            background: #f8fafc;
            line-height: 1.7;
        }
        h1, h2, h3, h4, h5 { font-weight: 800; letter-spacing: -.02em; }
        a { color: var(--rb-primary); }

        /* Navbar */
        .rb-nav { background: rgba(255,255,255,.92); backdrop-filter: blur(8px); border-bottom: 1px solid var(--rb-border); }
        .rb-brand { font-weight: 800; font-size: 1.35rem; color: var(--rb-ink) !important; letter-spacing: -.03em; }
        .rb-brand span { color: var(--rb-primary); }
        .rb-logo { display: inline-flex; width: 34px; height: 34px; align-items: center; justify-content: center;
            border-radius: 10px; background: linear-gradient(135deg, #2563eb, #7c3aed); color: #fff; font-size: 1.1rem; margin-right: .5rem; }
        .rb-nav .nav-link { font-weight: 600; color: #334155; }
        .rb-nav .nav-link:hover { color: var(--rb-primary); }

        /* Hero */
        .rb-hero { padding: 4rem 0 3rem; background:
            radial-gradient(900px 400px at 15% -10%, #dbeafe 0, transparent 60%),
            radial-gradient(800px 400px at 95% 0, #ede9fe 0, transparent 55%), #f8fafc; }
        .rb-hero h1 { font-size: clamp(2rem, 5vw, 3.2rem); }
        .rb-lead { color: var(--rb-muted); font-size: 1.15rem; max-width: 760px; margin: 0 auto; }
        .rb-pill { display: inline-block; padding: .35rem .85rem; border-radius: 999px; font-size: .85rem; font-weight: 600;
            background: #fff; border: 1px solid var(--rb-border); margin: .2rem; }

        /* Tool */
        .rb-tool { background: #fff; border: 1px solid var(--rb-border); border-radius: 1.25rem;
            box-shadow: 0 20px 50px -20px rgba(37,99,235,.35); padding: 1.5rem; }
        .rb-upload { border: 2px dashed #93c5fd; border-radius: 1rem; padding: 3rem 1.5rem; text-align: center;
            background: #f8fbff; cursor: pointer; transition: .2s; }
        .rb-upload:hover, .rb-upload.drag-over { border-color: var(--rb-primary); background: var(--rb-soft); }
        .rb-upload-icon { font-size: 3.2rem; line-height: 1; }
        .rb-note { display: inline-block; margin-top: .5rem; font-size: .85rem; color: #92400e; background: #fef3c7;
            border-radius: .5rem; padding: .35rem .75rem; }
        .btn-disabled-loading { opacity: .65; cursor: progress; }
        .rb-original { max-width: 100%; max-height: 360px; border-radius: .75rem; border: 1px solid var(--rb-border); }
        .rb-compare { border-radius: .75rem; overflow: hidden; border: 1px solid var(--rb-border); text-align: center; }
        .rb-compare img { max-width: 100%; max-height: 380px; display: block; margin: 0 auto; }
        .rb-checker { background-color: #fff;
            background-image: linear-gradient(45deg,#e5e7eb 25%,transparent 25%,transparent 75%,#e5e7eb 75%),
                              linear-gradient(45deg,#e5e7eb 25%,transparent 25%,transparent 75%,#e5e7eb 75%);
            background-size: 20px 20px; background-position: 0 0, 10px 10px; }

        /* Sections */
        .rb-section { padding: 4.5rem 0; }
        .rb-section.alt { background: #fff; }
        .rb-title { font-size: clamp(1.6rem, 3.5vw, 2.3rem); }
        .rb-sub { color: var(--rb-muted); max-width: 720px; margin: .5rem auto 0; }
        .rb-card { background: #fff; border: 1px solid var(--rb-border); border-radius: 1rem; padding: 1.5rem; height: 100%;
            transition: transform .2s, box-shadow .2s; }
        .rb-card:hover { transform: translateY(-3px); box-shadow: 0 12px 28px -12px rgba(15,23,42,.25); }
        .rb-icon { width: 52px; height: 52px; border-radius: 14px; background: var(--rb-soft); display: flex;
            align-items: center; justify-content: center; font-size: 1.6rem; margin-bottom: 1rem; }
        .rb-step { position: relative; }
        .rb-step-num { width: 38px; height: 38px; border-radius: 50%; background: var(--rb-primary); color: #fff; font-weight: 800;
            display: inline-flex; align-items: center; justify-content: center; margin-bottom: .75rem; }
        .rb-stats { background: linear-gradient(135deg, #1d4ed8, #7c3aed); color: #fff; padding: 3.5rem 0; }
        .rb-stats h3 { font-size: 2.4rem; margin: 0; }
        .rb-stats p { margin: 0; opacity: .85; }

        /* Before / After slider */
        .ba-slider { position: relative; overflow: hidden; border-radius: .9rem; aspect-ratio: 4 / 3; border: 1px solid var(--rb-border); background: #fff; }
        .ba-after, .ba-before { position: absolute; inset: 0; }
        .ba-after img, .ba-before img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .ba-before { clip-path: inset(0 50% 0 0); }
        .ba-range { position: absolute; inset: 0; width: 100%; height: 100%; opacity: 0; cursor: ew-resize; margin: 0; }
        .ba-handle { position: absolute; top: 0; bottom: 0; left: 50%; width: 3px; background: #fff; box-shadow: 0 0 6px rgba(0,0,0,.4);
            pointer-events: none; transform: translateX(-50%); }
        .ba-handle::after { content: "\2194"; position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%); width: 36px; height: 36px;
            border-radius: 50%; background: #fff; color: var(--rb-primary); display: flex; align-items: center; justify-content: center; font-weight: 700;
            box-shadow: 0 2px 8px rgba(0,0,0,.35); }
        .ba-tag { position: absolute; top: .6rem; padding: .15rem .6rem; border-radius: 999px; font-size: .72rem; font-weight: 700;
            background: rgba(15,23,42,.7); color: #fff; pointer-events: none; }
        .ba-tag-before { left: .6rem; } .ba-tag-after { right: .6rem; }

        /* Article */
        .rb-article { max-width: 860px; margin: 0 auto; font-size: 1.05rem; }
        .rb-article h3 { margin-top: 2.2rem; font-size: 1.45rem; }
        .rb-quote { border-left: 5px solid var(--rb-primary); background: var(--rb-soft); border-radius: .75rem; padding: 1.25rem 1.5rem; font-size: 1.15rem; font-weight: 600; }
        .rb-meta { color: var(--rb-muted); font-size: .9rem; }
        .rb-list { list-style: none; padding: 0; }
        .rb-list li { padding: .6rem 0; border-bottom: 1px dashed var(--rb-border); }

        /* FAQ */
        .accordion-button:not(.collapsed) { background: var(--rb-soft); color: var(--rb-primary-dark); }
        .accordion-button { font-weight: 700; }

        /* Footer */
        .rb-footer { background: #0f172a; color: #cbd5e1; padding: 3.5rem 0 1.5rem; }
        .rb-footer h4 { color: #fff; font-size: 1.1rem; }
        .rb-footer a { color: #93c5fd; text-decoration: none; }
        .rb-footer a:hover { color: #fff; text-decoration: underline; }
        .rb-footer hr { border-color: #334155; opacity: 1; }

        @media (max-width: 575.98px) {
            .rb-hero { padding-top: 2.5rem; }
            .rb-section { padding: 3rem 0; }
            .rb-tool { padding: 1rem; }
            .rb-upload { padding: 2rem 1rem; }
        }
    </style>

    {{-- JSON-LD structured data --}}
    @hasSection('jsonld')
        @yield('jsonld')
    @else
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebApplication",
            "name": "RemoveBG",
            "url": "{{ url(($locale ?? 'en')) }}",
            "description": "{{ __('messages.jsonld_app_description') }}",
            "applicationCategory": "MultimediaApplication",
            "operatingSystem": "All",
            "offers": {
                "@type": "Offer",
                "price": "0",
                "priceCurrency": "USD"
            }
        }
        </script>
    @endif
</head>

<body>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg sticky-top rb-nav">
        <div class="container">
            <a class="navbar-brand rb-brand d-flex align-items-center" href="{{ url(($locale ?? 'en')) }}">
                <span class="rb-logo">✨</span> Remove<span>BG</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main-nav"
                aria-controls="main-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="main-nav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="{{ url(($locale ?? 'en')) }}#tool">{{ __('messages.nav_tool') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url(($locale ?? 'en')) }}#examples">{{ __('messages.nav_examples') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url(($locale ?? 'en')) }}#how">{{ __('messages.nav_how') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url(($locale ?? 'en')) }}#tips">{{ __('content.tips_title') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url(($locale ?? 'en')) }}#faq">{{ __('messages.nav_faq') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url(($locale ?? 'en')) }}#about">{{ __('content.about_title') }}</a></li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            🌐 {{ __('messages.lang_' . ($locale ?? 'en')) }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @foreach(($locales ?? ['en', 'pt', 'es', 'fr', 'zh', 'hi', 'ru']) as $loc)
                                <li>
                                    <a class="dropdown-item {{ ($locale ?? 'en') === $loc ? 'active' : '' }}"
                                        href="{{ url($loc . $pathSuffix) }}">{{ __('messages.lang_' . $loc) }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    @yield('content')

    {{-- Footer --}}
    <footer class="rb-footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <h4>✨ RemoveBG</h4>
                    <p>{{ __('messages.footer_desc') }}</p>
                </div>
                <div class="col-md-4">
                    <h4>🔗 {{ __('messages.footer_links') }}</h4>
                    <ul class="list-unstyled">
                        <li><a href="{{ url(($locale ?? 'en')) }}#tool">{{ __('messages.footer_link_tool') }}</a></li>
                        <li><a href="{{ url(($locale ?? 'en')) }}#examples">{{ __('messages.nav_examples') }}</a></li>
                        <li><a href="{{ url(($locale ?? 'en')) }}#how">{{ __('messages.nav_how') }}</a></li>
                        <li><a href="{{ url(($locale ?? 'en')) }}#faq">{{ __('messages.nav_faq') }}</a></li>
                        <li><a href="{{ url(($locale ?? 'en')) }}#about">{{ __('content.about_title') }}</a></li>
                        <li><a href="{{ url(($locale ?? 'en') . '/sitemap.xml') }}">Sitemap</a></li>
                        <li><a href="{{ url(($locale ?? 'en') . '/feed.xml') }}">RSS Feed</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h4>🖼️ {{ __('messages.footer_formats') }}</h4>
                    <p>
                        <span class="badge text-bg-primary">JPG</span>
                        <span class="badge text-bg-info">PNG</span>
                        <span class="badge text-bg-success">WebP</span>
                    </p>
                    <p>🔒 {{ __('messages.footer_tech') }}</p>
                </div>
            </div>
            <hr class="my-4">
            <p class="text-center small mb-0">&copy; {{ date('Y') }} {{ __('messages.footer_copy') }}</p>
        </div>
    </footer>

    {{-- Bootstrap 5 JS bundle --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')
</body>

</html>
