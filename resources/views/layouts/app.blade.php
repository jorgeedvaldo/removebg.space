<!DOCTYPE html>
<html lang="{{ $htmlLang ?? 'en' }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#2563EB">

    {{-- Analytics placeholder — replace G-XXXXXXXXXX with your own Measurement ID --}}
    {{--
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-LXSR8R77XT"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-LXSR8R77XT');
    </script>
    --}}

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

    {{-- Bootstrap 3.3.7 CSS --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">

    {{-- Google Fonts --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@500;600;700;800&display=swap"
        rel="stylesheet">

    {{-- Font Awesome 4 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

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
    <nav class="navbar navbar-default navbar-static-top navbar-custom">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-nav">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url(($locale ?? 'en')) }}">
                    <i class="fa fa-magic"></i> Remove<span>BG</span>
                </a>
            </div>
            <div class="collapse navbar-collapse" id="main-nav">
                <ul class="nav navbar-nav">
                    <li><a href="{{ url(($locale ?? 'en')) }}#tool"><i class="fa fa-magic"></i> {{ __('messages.nav_tool') }}</a></li>
                    <li><a href="{{ url(($locale ?? 'en')) }}#examples"><i class="fa fa-clone"></i> {{ __('messages.nav_examples') }}</a></li>
                    <li><a href="{{ url(($locale ?? 'en')) }}#how"><i class="fa fa-question-circle"></i> {{ __('messages.nav_how') }}</a></li>
                    <li><a href="{{ url(($locale ?? 'en')) }}#faq"><i class="fa fa-comments-o"></i> {{ __('messages.nav_faq') }}</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="fa fa-globe"></i> {{ __('messages.lang_' . ($locale ?? 'en')) }} <span
                                class="caret"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-lang">
                            @foreach(($locales ?? ['en', 'pt', 'es', 'fr', 'zh', 'hi', 'ru']) as $loc)
                                <li class="{{ ($locale ?? 'en') === $loc ? 'active' : '' }}">
                                    <a href="{{ url($loc . $pathSuffix) }}">{{ __('messages.lang_' . $loc) }}</a>
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
    <footer class="footer-custom">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h4><i class="fa fa-magic"></i> RemoveBG</h4>
                    <p>{{ __('messages.footer_desc') }}</p>
                </div>
                <div class="col-md-4">
                    <h4><i class="fa fa-link"></i> {{ __('messages.footer_links') }}</h4>
                    <ul class="list-unstyled footer-links">
                        <li><a href="{{ url(($locale ?? 'en')) }}#tool">{{ __('messages.footer_link_tool') }}</a></li>
                        <li><a href="{{ url(($locale ?? 'en')) }}#examples">{{ __('messages.nav_examples') }}</a></li>
                        <li><a href="{{ url(($locale ?? 'en')) }}#how">{{ __('messages.nav_how') }}</a></li>
                        <li><a href="{{ url(($locale ?? 'en') . '/sitemap.xml') }}">Sitemap</a></li>
                        <li><a href="{{ url(($locale ?? 'en') . '/feed.xml') }}">RSS Feed</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h4><i class="fa fa-file-image-o"></i> {{ __('messages.footer_formats') }}</h4>
                    <p>
                        <span class="label label-primary">JPG</span>
                        <span class="label label-info">PNG</span>
                        <span class="label label-success">WebP</span>
                    </p>
                    <p class="footer-privacy"><i class="fa fa-lock"></i> {{ __('messages.footer_tech') }}</p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12 text-center">
                    <p class="footer-copy">&copy; {{ date('Y') }} {{ __('messages.footer_copy') }}</p>
                </div>
            </div>
        </div>
    </footer>

    {{-- jQuery & Bootstrap 3 JS --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    @yield('scripts')
</body>

</html>
