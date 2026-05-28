@extends('layouts.app')

@section('title', __('messages.meta_title'))
@section('meta_description', __('messages.meta_description'))

@section('jsonld')
{{-- WebApplication --}}
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebApplication",
    "name": "RemoveBG",
    "url": "{{ url(($locale ?? 'en')) }}",
    "description": "{{ __('messages.jsonld_app_description') }}",
    "applicationCategory": "MultimediaApplication",
    "operatingSystem": "All",
    "browserRequirements": "Requires a modern browser with WebAssembly support",
    "inLanguage": "{{ $htmlLang ?? 'en' }}",
    "image": "{{ asset('img/og-cover.png') }}",
    "featureList": [
        "{{ __('messages.feature_1') }}",
        "{{ __('messages.feature_2') }}",
        "{{ __('messages.feature_3') }}",
        "{{ __('messages.feature_4') }}"
    ],
    "offers": {
        "@type": "Offer",
        "price": "0",
        "priceCurrency": "USD"
    },
    "publisher": {
        "@type": "Organization",
        "name": "RemoveBG",
        "url": "{{ url('/') }}",
        "logo": {
            "@type": "ImageObject",
            "url": "{{ asset('img/og-cover.png') }}"
        }
    }
}
</script>
{{-- HowTo --}}
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "HowTo",
    "name": "{{ __('messages.howto_name') }}",
    "description": "{{ __('messages.howto_description') }}",
    "totalTime": "PT10S",
    "tool": { "@type": "HowToTool", "name": "RemoveBG" },
    "step": [
        {
            "@type": "HowToStep",
            "position": 1,
            "name": "{{ __('messages.step1_title') }}",
            "text": "{{ __('messages.step1_desc') }}",
            "url": "{{ url(($locale ?? 'en')) }}#tool"
        },
        {
            "@type": "HowToStep",
            "position": 2,
            "name": "{{ __('messages.step2_title') }}",
            "text": "{{ __('messages.step2_desc') }}",
            "url": "{{ url(($locale ?? 'en')) }}#tool"
        },
        {
            "@type": "HowToStep",
            "position": 3,
            "name": "{{ __('messages.step3_title') }}",
            "text": "{{ __('messages.step3_desc') }}",
            "url": "{{ url(($locale ?? 'en')) }}#tool"
        }
    ]
}
</script>
{{-- FAQPage --}}
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
        {
            "@type": "Question",
            "name": {!! json_encode(__('messages.faq_q1')) !!},
            "acceptedAnswer": { "@type": "Answer", "text": {!! json_encode(strip_tags(__('messages.faq_a1'))) !!} }
        },
        {
            "@type": "Question",
            "name": {!! json_encode(__('messages.faq_q2')) !!},
            "acceptedAnswer": { "@type": "Answer", "text": {!! json_encode(strip_tags(__('messages.faq_a2'))) !!} }
        },
        {
            "@type": "Question",
            "name": {!! json_encode(__('messages.faq_q3')) !!},
            "acceptedAnswer": { "@type": "Answer", "text": {!! json_encode(strip_tags(__('messages.faq_a3'))) !!} }
        },
        {
            "@type": "Question",
            "name": {!! json_encode(__('messages.faq_q4')) !!},
            "acceptedAnswer": { "@type": "Answer", "text": {!! json_encode(strip_tags(__('messages.faq_a4'))) !!} }
        },
        {
            "@type": "Question",
            "name": {!! json_encode(__('messages.faq_q5')) !!},
            "acceptedAnswer": { "@type": "Answer", "text": {!! json_encode(strip_tags(__('messages.faq_a5'))) !!} }
        }
    ]
}
</script>
{{-- Organization --}}
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "RemoveBG",
    "url": "{{ url('/') }}",
    "logo": "{{ asset('img/og-cover.png') }}"
}
</script>
@endsection

@section('content')

{{-- ============================== HERO + TOOL ============================== --}}
<header class="hero-section" id="tool">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 text-center">
                <h1 class="hero-title">
                    <i class="fa fa-magic"></i> {{ __('messages.hero_title') }}
                </h1>
                <p class="hero-subtitle">
                    {!! __('messages.hero_subtitle') !!}
                </p>
                <div class="hero-badges">
                    <span class="label label-primary label-lg"><i class="fa fa-bolt"></i> {{ __('messages.badge_instant') }}</span>
                    <span class="label label-success label-lg"><i class="fa fa-check"></i> {{ __('messages.badge_free') }}</span>
                    <span class="label label-warning label-lg"><i class="fa fa-lock"></i> {{ __('messages.badge_private') }}</span>
                    <span class="label label-info label-lg"><i class="fa fa-ban"></i> {{ __('messages.badge_no_watermark') }}</span>
                </div>
            </div>
        </div>

        {{-- The tool — front and center --}}
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-tool">
                    <div class="panel-body">

                        {{-- Step 1 — Upload --}}
                        <div class="upload-area" id="bgUploadArea">
                            <div class="upload-icon">
                                <i class="fa fa-cloud-upload"></i>
                            </div>
                            <h3>{{ __('messages.bg_upload_title') }}</h3>
                            <p>{{ __('messages.bg_upload_subtitle') }}</p>
                            <p class="text-muted"><small>{!! __('messages.bg_upload_formats') !!}</small></p>
                            <p class="bg-notice"><i class="fa fa-info-circle"></i> {{ __('messages.bg_first_load') }}</p>
                            <input type="file" id="bgFileInput" accept="image/jpeg,image/jpg,image/png,image/webp" class="hidden">
                        </div>

                        {{-- Step 2 — Preview & Confirm --}}
                        <div id="bgPreviewSection" style="display:none;">
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2 text-center">
                                    <p class="bg-compare-label" style="margin-top:20px;">
                                        <i class="fa fa-picture-o"></i> {{ __('messages.bg_preview_original') }}
                                    </p>
                                    <img id="bgOriginalPreview" src="" alt="{{ __('messages.bg_preview_original') }}" class="bg-original-img">
                                    <div class="bg-file-meta">
                                        <span><i class="fa fa-file-image-o"></i> <span id="bgFileName"></span></span>
                                        &nbsp;
                                        <span><i class="fa fa-hdd-o"></i> <span id="bgFileSize"></span></span>
                                    </div>
                                </div>
                            </div>

                            {{-- Error inside preview --}}
                            <div id="bgErrorArea" style="display:none;" class="bg-error-area">
                                <div class="alert alert-danger">
                                    <h4><i class="fa fa-exclamation-triangle"></i> {{ __('messages.bg_error_title') }}</h4>
                                    <p id="bgErrorMessage"></p>
                                </div>
                                <button class="btn btn-warning btn-lg" id="btnRetryBg">
                                    <i class="fa fa-refresh"></i> {{ __('messages.bg_btn_try_again') }}
                                </button>
                            </div>

                            <div class="text-center" style="margin-top:20px;">
                                <button class="btn btn-primary btn-lg" id="btnRemoveBg">
                                    <i class="fa fa-magic"></i> {{ __('messages.bg_btn_remove') }}
                                </button>
                                <button class="btn btn-default btn-lg" id="btnNewImage">
                                    <i class="fa fa-trash"></i> {{ __('messages.bg_btn_new_image') }}
                                </button>
                            </div>
                        </div>

                        {{-- Step 3 — Processing --}}
                        <div id="bgProgressArea" style="display:none;" class="bg-progress-area">
                            <h4><i class="fa fa-spinner fa-spin"></i> {{ __('messages.bg_processing_title') }}</h4>
                            <div class="progress progress-striped active">
                                <div class="progress-bar progress-bar-primary" id="bgProgressBar" style="width:0%">0%</div>
                            </div>
                            <p class="bg-progress-text" id="bgProgressText">{{ __('messages.bg_loading_model') }}</p>
                            <p class="bg-first-load-notice">
                                <i class="fa fa-info-circle"></i> {{ __('messages.bg_first_load') }}
                            </p>
                        </div>

                        {{-- Step 4 — Result --}}
                        <div id="bgResultSection" style="display:none;">
                            <div class="bg-result-header">
                                <h4><i class="fa fa-check-circle text-success"></i> {{ __('messages.bg_done_title') }}</h4>
                                <button class="btn btn-success btn-lg" id="btnDownloadResult">
                                    <i class="fa fa-download"></i> {{ __('messages.bg_btn_download') }}
                                </button>
                            </div>

                            <div class="bg-result-info">
                                <i class="fa fa-check-circle"></i> {{ __('messages.bg_result_info') }}
                            </div>

                            {{-- Side-by-side comparison --}}
                            <div class="row bg-compare-wrap">
                                <div class="col-md-6">
                                    <p class="bg-compare-label">
                                        <i class="fa fa-picture-o"></i> {{ __('messages.bg_preview_original') }}
                                    </p>
                                    <div class="bg-compare-img-wrap">
                                        <img id="bgOriginalPreview2" src="" alt="{{ __('messages.bg_preview_original') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <p class="bg-compare-label">
                                        <i class="fa fa-magic"></i> {{ __('messages.bg_preview_result') }}
                                    </p>
                                    <div class="bg-compare-img-wrap bg-checkerboard">
                                        <img id="bgResultPreview" src="" alt="{{ __('messages.bg_preview_result') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="text-center" style="margin-top:15px;">
                                <button class="btn btn-default btn-lg" id="btnNewImageResult">
                                    <i class="fa fa-refresh"></i> {{ __('messages.bg_btn_new_image') }}
                                </button>
                                <button class="btn btn-success btn-lg" id="btnDownloadResult2">
                                    <i class="fa fa-download"></i> {{ __('messages.bg_btn_download') }}
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
                <p class="hero-trust text-center">
                    <i class="fa fa-shield"></i> {{ __('messages.hero_trust') }}
                </p>
            </div>
        </div>
    </div>
</header>

{{-- ============================== BEFORE / AFTER EXAMPLES ============================== --}}
<section class="examples-section" id="examples">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2 class="section-title"><i class="fa fa-clone"></i> {{ __('messages.examples_title') }}</h2>
                <p class="section-subtitle">{{ __('messages.examples_subtitle') }}</p>
            </div>
        </div>
        <div class="row">
            @foreach(['person' => 'fa-user', 'product' => 'fa-shopping-bag', 'animal' => 'fa-paw'] as $key => $icon)
            <div class="col-md-4 col-sm-6">
                <div class="example-card">
                    <div class="ba-slider" tabindex="0" aria-label="{{ __('messages.example_' . $key) }}">
                        <div class="ba-after bg-checkerboard">
                            <img src="{{ asset('img/examples/after-' . $key . '.svg') }}" alt="{{ __('messages.example_' . $key) }} - {{ __('messages.bg_preview_result') }}">
                        </div>
                        <div class="ba-before">
                            <img src="{{ asset('img/examples/before-' . $key . '.svg') }}" alt="{{ __('messages.example_' . $key) }} - {{ __('messages.bg_preview_original') }}">
                        </div>
                        <span class="ba-tag ba-tag-before">{{ __('messages.bg_preview_original') }}</span>
                        <span class="ba-tag ba-tag-after">{{ __('messages.bg_preview_result') }}</span>
                        <input type="range" min="0" max="100" value="50" class="ba-range" aria-label="{{ __('messages.examples_drag') }}">
                        <span class="ba-handle"><i class="fa fa-arrows-h"></i></span>
                    </div>
                    <p class="example-caption">{{ __('messages.example_' . $key) }}</p>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <p class="examples-hint"><i class="fa fa-hand-pointer-o"></i> {{ __('messages.examples_drag') }}</p>
                <a href="#tool" class="btn btn-primary btn-lg"><i class="fa fa-magic"></i> {{ __('messages.bg_article_cta_btn') }}</a>
            </div>
        </div>
    </div>
</section>

{{-- ============================== HOW IT WORKS ============================== --}}
<section class="how-section" id="how">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2 class="section-title"><i class="fa fa-question-circle"></i> {{ __('messages.bg_how_title') }}</h2>
                <p class="section-subtitle">{{ __('messages.bg_how_subtitle') }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 text-center">
                <div class="step-box">
                    <div class="step-number">1</div>
                    <i class="fa fa-cloud-upload fa-3x"></i>
                    <h3>{{ __('messages.step1_title') }}</h3>
                    <p>{{ __('messages.step1_desc') }}</p>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="step-box">
                    <div class="step-number">2</div>
                    <i class="fa fa-magic fa-3x"></i>
                    <h3>{{ __('messages.step2_title') }}</h3>
                    <p>{{ __('messages.step2_desc') }}</p>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="step-box">
                    <div class="step-number">3</div>
                    <i class="fa fa-download fa-3x"></i>
                    <h3>{{ __('messages.step3_title') }}</h3>
                    <p>{{ __('messages.step3_desc') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================== USE CASES ============================== --}}
<section class="formats-section" id="uses">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2 class="section-title"><i class="fa fa-th-large"></i> {{ __('messages.bg_uses_title') }}</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="format-card">
                    <div class="format-icon"><i class="fa fa-shopping-cart"></i></div>
                    <h4>{{ __('messages.bg_use1_title') }}</h4>
                    <p>{{ __('messages.bg_use1_desc') }}</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="format-card">
                    <div class="format-icon"><i class="fa fa-user-circle-o"></i></div>
                    <h4>{{ __('messages.bg_use2_title') }}</h4>
                    <p>{{ __('messages.bg_use2_desc') }}</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="format-card">
                    <div class="format-icon"><i class="fa fa-paint-brush"></i></div>
                    <h4>{{ __('messages.bg_use3_title') }}</h4>
                    <p>{{ __('messages.bg_use3_desc') }}</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="format-card">
                    <div class="format-icon"><i class="fa fa-share-alt"></i></div>
                    <h4>{{ __('messages.bg_use4_title') }}</h4>
                    <p>{{ __('messages.bg_use4_desc') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================== STATS ============================== --}}
<section class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-6 text-center">
                <div class="stat-box">
                    <i class="fa fa-magic fa-2x"></i>
                    <h3>100M+</h3>
                    <p>{{ __('messages.bg_stat_images') }}</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 text-center">
                <div class="stat-box">
                    <i class="fa fa-users fa-2x"></i>
                    <h3>20M+</h3>
                    <p>{{ __('messages.bg_stat_users') }}</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 text-center">
                <div class="stat-box">
                    <i class="fa fa-bullseye fa-2x"></i>
                    <h3>95%+</h3>
                    <p>{{ __('messages.bg_stat_accuracy') }}</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 text-center">
                <div class="stat-box">
                    <i class="fa fa-globe fa-2x"></i>
                    <h3>190+</h3>
                    <p>{{ __('messages.bg_stat_countries') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================== FAQ ============================== --}}
<section class="faq-section" id="faq">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2 class="section-title"><i class="fa fa-comments-o"></i> {{ __('messages.faq_title') }}</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel-group faq-accordion" id="faqAccordion">
                    @for($i = 1; $i <= 5; $i++)
                    <div class="panel panel-default faq-item">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <a data-toggle="collapse" data-parent="#faqAccordion" href="#faq{{ $i }}">
                                    <i class="fa fa-question-circle"></i> {{ __('messages.faq_q' . $i) }}
                                </a>
                            </h3>
                        </div>
                        <div id="faq{{ $i }}" class="panel-collapse collapse {{ $i === 1 ? 'in' : '' }}">
                            <div class="panel-body">{!! __('messages.faq_a' . $i) !!}</div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================== SEO ARTICLE ============================== --}}
<section class="article-section" id="article">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <article class="article-content" itemscope itemtype="https://schema.org/Article">
                    <meta itemprop="datePublished" content="2024-01-15T08:00:00+00:00">
                    <meta itemprop="dateModified" content="{{ now()->toIso8601String() }}">
                    <div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
                        <meta itemprop="name" content="RemoveBG">
                        <meta itemprop="url" content="{{ url(($locale ?? 'en')) }}">
                    </div>

                    <h2 class="article-title" itemprop="headline">
                        <i class="fa fa-newspaper-o"></i> {{ __('messages.bg_article_title') }}
                    </h2>

                    <div class="article-meta">
                        <span><i class="fa fa-clock-o"></i> {{ __('messages.bg_article_read_time') }}</span>
                        <span><i class="fa fa-user"></i> {{ __('messages.bg_article_author') }}</span>
                    </div>

                    <div itemprop="articleBody">

                        <div class="article-intro">
                            <p class="lead">{!! __('messages.bg_article_intro') !!}</p>
                        </div>

                        <h3><i class="fa fa-diamond"></i> {{ __('messages.bg_article_h3_what') }}</h3>
                        <p>{!! __('messages.bg_article_what_p1') !!}</p>
                        <p>{!! __('messages.bg_article_what_p2') !!}</p>

                        <div class="well well-lg article-highlight">
                            <h4><i class="fa fa-quote-left"></i> {!! __('messages.bg_article_quote') !!}</h4>
                        </div>

                        <h3><i class="fa fa-cogs"></i> {{ __('messages.bg_article_h3_how') }}</h3>
                        <p>{!! __('messages.bg_article_how_p1') !!}</p>
                        <p>{!! __('messages.bg_article_how_p2') !!}</p>

                        <h3><i class="fa fa-shield"></i> {{ __('messages.bg_article_h3_privacy') }}</h3>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <i class="fa fa-lock"></i> {{ __('messages.article_security_panel_good') }}
                                    </div>
                                    <div class="panel-body">
                                        <ul class="list-unstyled">
                                            <li><i class="fa fa-check text-success"></i> {{ __('messages.article_security_good1') }}</li>
                                            <li><i class="fa fa-check text-success"></i> {{ __('messages.article_security_good2') }}</li>
                                            <li><i class="fa fa-check text-success"></i> {{ __('messages.article_security_good3') }}</li>
                                            <li><i class="fa fa-check text-success"></i> {{ __('messages.article_security_good4') }}</li>
                                            <li><i class="fa fa-check text-success"></i> {{ __('messages.article_security_good5') }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel panel-danger">
                                    <div class="panel-heading">
                                        <i class="fa fa-exclamation-triangle"></i> {{ __('messages.article_security_panel_bad') }}
                                    </div>
                                    <div class="panel-body">
                                        <ul class="list-unstyled">
                                            <li><i class="fa fa-times text-danger"></i> {{ __('messages.article_security_bad1') }}</li>
                                            <li><i class="fa fa-times text-danger"></i> {{ __('messages.article_security_bad2') }}</li>
                                            <li><i class="fa fa-times text-danger"></i> {{ __('messages.article_security_bad3') }}</li>
                                            <li><i class="fa fa-times text-danger"></i> {{ __('messages.article_security_bad4') }}</li>
                                            <li><i class="fa fa-times text-danger"></i> {{ __('messages.article_security_bad5') }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <p>{!! __('messages.bg_article_privacy_p1') !!}</p>
                        <p>{!! __('messages.bg_article_privacy_p2') !!}</p>

                        <h3><i class="fa fa-trophy"></i> {{ __('messages.bg_article_h3_quality') }}</h3>
                        <p>{!! __('messages.bg_article_quality_p1') !!}</p>
                        <p>{!! __('messages.bg_article_quality_p2') !!}</p>

                        <h3><i class="fa fa-users"></i> {{ __('messages.bg_article_h3_usecases') }}</h3>
                        <p>{!! __('messages.bg_article_usecases_intro') !!}</p>

                        <div class="row">
                            <div class="col-md-6">
                                <ul class="article-list">
                                    <li><i class="fa fa-shopping-cart"></i> {!! __('messages.bg_article_usecase1') !!}</li>
                                    <li><i class="fa fa-paint-brush"></i> {!! __('messages.bg_article_usecase2') !!}</li>
                                    <li><i class="fa fa-camera"></i> {!! __('messages.bg_article_usecase3') !!}</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="article-list">
                                    <li><i class="fa fa-briefcase"></i> {!! __('messages.bg_article_usecase4') !!}</li>
                                    <li><i class="fa fa-youtube-play"></i> {!! __('messages.bg_article_usecase5') !!}</li>
                                    <li><i class="fa fa-graduation-cap"></i> {!! __('messages.bg_article_usecase6') !!}</li>
                                </ul>
                            </div>
                        </div>

                        <h3><i class="fa fa-globe"></i> {{ __('messages.bg_article_h3_comparison') }}</h3>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped comparison-table">
                                <thead>
                                    <tr class="active">
                                        <th>{{ __('messages.bg_comparison_feature') }}</th>
                                        <th class="success"><i class="fa fa-trophy"></i> RemoveBG</th>
                                        <th>Remove.bg</th>
                                        <th>Canva</th>
                                        <th>Adobe Express</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>{{ __('messages.bg_comparison_free') }}</strong></td>
                                        <td class="success"><i class="fa fa-check text-success"></i> {{ __('messages.bg_comparison_always') }}</td>
                                        <td><i class="fa fa-times text-danger"></i> {{ __('messages.bg_comparison_limited') }}</td>
                                        <td><i class="fa fa-times text-danger"></i> {{ __('messages.bg_comparison_limited') }}</td>
                                        <td><i class="fa fa-times text-danger"></i> {{ __('messages.bg_comparison_limited') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('messages.bg_comparison_no_upload') }}</strong></td>
                                        <td class="success"><i class="fa fa-check text-success"></i> {{ __('messages.bg_comparison_yes') }}</td>
                                        <td><i class="fa fa-times text-danger"></i> {{ __('messages.bg_comparison_no') }}</td>
                                        <td><i class="fa fa-times text-danger"></i> {{ __('messages.bg_comparison_no') }}</td>
                                        <td><i class="fa fa-times text-danger"></i> {{ __('messages.bg_comparison_no') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('messages.bg_comparison_no_reg') }}</strong></td>
                                        <td class="success"><i class="fa fa-check text-success"></i> {{ __('messages.bg_comparison_yes') }}</td>
                                        <td><i class="fa fa-times text-danger"></i> {{ __('messages.bg_comparison_no') }}</td>
                                        <td><i class="fa fa-times text-danger"></i> {{ __('messages.bg_comparison_no') }}</td>
                                        <td><i class="fa fa-times text-danger"></i> {{ __('messages.bg_comparison_no') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('messages.bg_comparison_no_watermark') }}</strong></td>
                                        <td class="success"><i class="fa fa-check text-success"></i> {{ __('messages.bg_comparison_yes') }}</td>
                                        <td><i class="fa fa-times text-danger"></i> {{ __('messages.bg_comparison_no') }}</td>
                                        <td><i class="fa fa-times text-danger"></i> {{ __('messages.bg_comparison_partial') }}</td>
                                        <td><i class="fa fa-times text-danger"></i> {{ __('messages.bg_comparison_no') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('messages.bg_comparison_unlimited') }}</strong></td>
                                        <td class="success"><i class="fa fa-check text-success"></i> {{ __('messages.bg_comparison_yes') }}</td>
                                        <td><i class="fa fa-times text-danger"></i> {{ __('messages.bg_comparison_no') }}</td>
                                        <td><i class="fa fa-times text-danger"></i> {{ __('messages.bg_comparison_limited') }}</td>
                                        <td><i class="fa fa-times text-danger"></i> {{ __('messages.bg_comparison_limited') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('messages.bg_comparison_privacy') }}</strong></td>
                                        <td class="success"><i class="fa fa-check text-success"></i> {{ __('messages.bg_comparison_yes') }}</td>
                                        <td><i class="fa fa-times text-danger"></i> {{ __('messages.bg_comparison_no') }}</td>
                                        <td><i class="fa fa-times text-danger"></i> {{ __('messages.bg_comparison_no') }}</td>
                                        <td><i class="fa fa-times text-danger"></i> {{ __('messages.bg_comparison_no') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="alert alert-info article-cta">
                            <h4><i class="fa fa-hand-o-up"></i> {{ __('messages.bg_article_cta_title') }}</h4>
                            <p>{!! __('messages.bg_article_cta_text') !!}</p>
                            <a href="#tool" class="btn btn-primary btn-lg">
                                <i class="fa fa-arrow-up"></i> {{ __('messages.bg_article_cta_btn') }}
                            </a>
                        </div>

                    </div>
                </article>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
{{--
    @imgly/background-removal v1.7.0
    Loaded via esm.sh which resolves the onnxruntime-web peer dependency.
    The AI model (ONNX) + WASM run 100% in the browser — nothing is uploaded.
--}}
<script>
    window.BG_REMOVE_LANG = {
        invalid_format:   @json(__('messages.bg_invalid_format')),
        loading_model:    @json(__('messages.bg_loading_model')),
        processing_image: @json(__('messages.bg_processing_image')),
        done_title:       @json(__('messages.bg_done_title')),
        error_msg:        @json(__('messages.bg_error_msg')),
        error_title:      @json(__('messages.bg_error_title'))
    };
</script>
<script src="{{ asset('js/remove-bg.js') }}"></script>
<script type="module">
    /*
     * esm.sh bundles @imgly/background-removal + its onnxruntime-web peer dep
     * into a single browser-compatible ES module — no build step needed.
     */
    try {
        const { removeBackground } = await import('https://esm.sh/@imgly/background-removal@1.7.0');
        window.bgRemoval = { removeBackground };
        document.dispatchEvent(new Event('bgRemovalReady'));
    } catch (err) {
        console.error('[RemoveBG] Failed to load background-removal library:', err);
        const btn = document.getElementById('btnRemoveBg');
        if (btn) {
            btn.disabled = true;
            btn.title = 'AI library failed to load. Please refresh.';
        }
    }
</script>
<script>
    // Wire up extra buttons + before/after sliders once DOM is ready
    (function () {
        function afterLoad() {
            // Sync original preview to comparison panel
            var orig  = document.getElementById('bgOriginalPreview');
            var orig2 = document.getElementById('bgOriginalPreview2');
            if (orig && orig2) {
                orig.addEventListener('load', function () { orig2.src = orig.src; });
            }
            // Mirror duplicate action buttons
            var dl1 = document.getElementById('btnDownloadResult');
            var dl2 = document.getElementById('btnDownloadResult2');
            if (dl1 && dl2) { dl2.addEventListener('click', function () { dl1.click(); }); }
            var ni1 = document.getElementById('btnNewImage');
            var ni2 = document.getElementById('btnNewImageResult');
            if (ni1 && ni2) { ni2.addEventListener('click', function () { ni1.click(); }); }

            // Before/After comparison sliders
            document.querySelectorAll('.ba-slider').forEach(function (slider) {
                var range  = slider.querySelector('.ba-range');
                var before = slider.querySelector('.ba-before');
                var handle = slider.querySelector('.ba-handle');
                if (!range || !before || !handle) return;
                function setPos(v) {
                    before.style.clipPath = 'inset(0 ' + (100 - v) + '% 0 0)';
                    handle.style.left = v + '%';
                }
                range.addEventListener('input', function () { setPos(range.value); });
                setPos(range.value);
            });
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', afterLoad);
        } else {
            afterLoad();
        }
    })();
</script>
@endsection
