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
@php
    $faqItems = [];
    for ($i = 1; $i <= 5; $i++) {
        $faqItems[] = ['@type' => 'Question', 'name' => __('messages.faq_q' . $i),
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => strip_tags(__('messages.faq_a' . $i))]];
    }
    for ($i = 6; $i <= 10; $i++) {
        $faqItems[] = ['@type' => 'Question', 'name' => __('content.faq_q' . $i),
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => strip_tags(__('content.faq_a' . $i))]];
    }
@endphp
<script type="application/ld+json">
{!! json_encode(['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => $faqItems], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
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
<header class="rb-hero" id="tool">
    <div class="container">
        <div class="text-center mb-4">
            <h1 class="mb-3">✨ {{ __('messages.hero_title') }}</h1>
            <p class="rb-lead">{!! __('messages.hero_subtitle') !!}</p>
            <div class="mt-3">
                <span class="rb-pill">⚡ {{ __('messages.badge_instant') }}</span>
                <span class="rb-pill">✅ {{ __('messages.badge_free') }}</span>
                <span class="rb-pill">🔒 {{ __('messages.badge_private') }}</span>
                <span class="rb-pill">🚫 {{ __('messages.badge_no_watermark') }}</span>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="rb-tool">

                    {{-- Step 1 — Upload --}}
                    <div class="rb-upload" id="bgUploadArea">
                        <div class="rb-upload-icon mb-2">☁️</div>
                        <h3 class="h4">{{ __('messages.bg_upload_title') }}</h3>
                        <p class="mb-1">{{ __('messages.bg_upload_subtitle') }}</p>
                        <p class="text-muted small mb-1">{!! __('messages.bg_upload_formats') !!}</p>
                        <span class="rb-note">ℹ️ {{ __('messages.bg_first_load') }}</span>
                        <input type="file" id="bgFileInput" accept="image/jpeg,image/jpg,image/png,image/webp" class="d-none">
                    </div>

                    {{-- Step 2 — Preview & Confirm --}}
                    <div id="bgPreviewSection" style="display:none;">
                        <div class="text-center">
                            <p class="fw-semibold mb-2">🖼️ {{ __('messages.bg_preview_original') }}</p>
                            <img id="bgOriginalPreview" src="" alt="{{ __('messages.bg_preview_original') }}" class="rb-original">
                            <div class="text-muted small mt-2">
                                📄 <span id="bgFileName"></span> &nbsp; 💾 <span id="bgFileSize"></span>
                            </div>
                        </div>

                        <div id="bgErrorArea" style="display:none;" class="mt-3 text-center">
                            <div class="alert alert-danger text-start">
                                <h4 class="h6">⚠️ {{ __('messages.bg_error_title') }}</h4>
                                <p class="mb-0" id="bgErrorMessage"></p>
                            </div>
                            <button class="btn btn-warning btn-lg" id="btnRetryBg">🔄 {{ __('messages.bg_btn_try_again') }}</button>
                        </div>

                        <div class="text-center mt-4 d-flex flex-wrap gap-2 justify-content-center">
                            <button class="btn btn-primary btn-lg" id="btnRemoveBg">✨ {{ __('messages.bg_btn_remove') }}</button>
                            <button class="btn btn-outline-secondary btn-lg" id="btnNewImage">🗑️ {{ __('messages.bg_btn_new_image') }}</button>
                        </div>
                    </div>

                    {{-- Step 3 — Processing --}}
                    <div id="bgProgressArea" style="display:none;" class="text-center py-4">
                        <h4 class="h5 mb-3">
                            <span class="spinner-border spinner-border-sm text-primary me-2" role="status" aria-hidden="true"></span>{{ __('messages.bg_processing_title') }}
                        </h4>
                        <div class="progress" style="height:1.5rem;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" id="bgProgressBar" style="width:0%">0%</div>
                        </div>
                        <p class="mt-3 mb-1 fw-semibold" id="bgProgressText">{{ __('messages.bg_loading_model') }}</p>
                        <p class="text-muted small mb-0">ℹ️ {{ __('messages.bg_first_load') }}</p>
                    </div>

                    {{-- Step 4 — Result --}}
                    <div id="bgResultSection" style="display:none;">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                            <h4 class="h5 mb-0 text-success">✅ {{ __('messages.bg_done_title') }}</h4>
                            <button class="btn btn-success btn-lg" id="btnDownloadResult">⬇️ {{ __('messages.bg_btn_download') }}</button>
                        </div>
                        <div class="alert alert-success py-2">{{ __('messages.bg_result_info') }}</div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <p class="fw-semibold mb-2">🖼️ {{ __('messages.bg_preview_original') }}</p>
                                <div class="rb-compare">
                                    <img id="bgOriginalPreview2" src="" alt="{{ __('messages.bg_preview_original') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <p class="fw-semibold mb-2">✨ {{ __('messages.bg_preview_result') }}</p>
                                <div class="rb-compare rb-checker">
                                    <img id="bgResultPreview" src="" alt="{{ __('messages.bg_preview_result') }}">
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4 d-flex flex-wrap gap-2 justify-content-center">
                            <button class="btn btn-outline-secondary btn-lg" id="btnNewImageResult">🔄 {{ __('messages.bg_btn_new_image') }}</button>
                            <button class="btn btn-success btn-lg" id="btnDownloadResult2">⬇️ {{ __('messages.bg_btn_download') }}</button>
                        </div>
                    </div>

                </div>
                <p class="text-center text-muted small mt-3 mb-0">🛡️ {{ __('messages.hero_trust') }}</p>
            </div>
        </div>
    </div>
</header>

{{-- ============================== FEATURES ============================== --}}
<section class="rb-section alt" id="features">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="rb-title">{{ __('content.feat_title') }}</h2>
            <p class="rb-sub">{{ __('content.feat_sub') }}</p>
        </div>
        <div class="row g-4">
            @foreach([1 => '🧠', 2 => '🔒', 3 => '🎁', 4 => '✂️', 5 => '🖼️', 6 => '📱'] as $n => $emoji)
            <div class="col-md-6 col-lg-4">
                <div class="rb-card">
                    <div class="rb-icon">{{ $emoji }}</div>
                    <h3 class="h5">{{ __('content.feat' . $n . '_t') }}</h3>
                    <p class="mb-0 text-muted">{{ __('content.feat' . $n . '_d') }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================== BEFORE / AFTER EXAMPLES ============================== --}}
<section class="rb-section" id="examples">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="rb-title">{{ __('messages.examples_title') }}</h2>
            <p class="rb-sub">{{ __('messages.examples_subtitle') }}</p>
        </div>
        <div class="row g-4">
            @foreach(['person', 'product', 'animal'] as $key)
            <div class="col-md-6 col-lg-4">
                <div class="rb-card p-3">
                    <div class="ba-slider" tabindex="0" aria-label="{{ __('messages.example_' . $key) }}">
                        <div class="ba-after rb-checker">
                            <img src="{{ asset('img/examples/after-' . $key . '.svg') }}" alt="{{ __('messages.example_' . $key) }} - {{ __('messages.bg_preview_result') }}" loading="lazy">
                        </div>
                        <div class="ba-before">
                            <img src="{{ asset('img/examples/before-' . $key . '.svg') }}" alt="{{ __('messages.example_' . $key) }} - {{ __('messages.bg_preview_original') }}" loading="lazy">
                        </div>
                        <span class="ba-tag ba-tag-before">{{ __('messages.bg_preview_original') }}</span>
                        <span class="ba-tag ba-tag-after">{{ __('messages.bg_preview_result') }}</span>
                        <input type="range" min="0" max="100" value="50" class="ba-range" aria-label="{{ __('messages.examples_drag') }}">
                        <span class="ba-handle"></span>
                    </div>
                    <p class="text-center fw-semibold mt-3 mb-0">{{ __('messages.example_' . $key) }}</p>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <p class="text-muted">👆 {{ __('messages.examples_drag') }}</p>
            <a href="#tool" class="btn btn-primary btn-lg">✨ {{ __('messages.bg_article_cta_btn') }}</a>
        </div>
    </div>
</section>

{{-- ============================== HOW IT WORKS ============================== --}}
<section class="rb-section alt" id="how">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="rb-title">{{ __('messages.bg_how_title') }}</h2>
            <p class="rb-sub">{{ __('messages.bg_how_subtitle') }}</p>
        </div>
        <div class="row g-4">
            @foreach([1 => '☁️', 2 => '✨', 3 => '⬇️'] as $n => $emoji)
            <div class="col-md-4 text-center">
                <div class="rb-card rb-step">
                    <div class="rb-step-num">{{ $n }}</div>
                    <div class="display-5 mb-2">{{ $emoji }}</div>
                    <h3 class="h5">{{ __('messages.step' . $n . '_title') }}</h3>
                    <p class="mb-0 text-muted">{{ __('messages.step' . $n . '_desc') }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================== USE CASES ============================== --}}
<section class="rb-section" id="uses">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="rb-title">{{ __('messages.bg_uses_title') }}</h2>
        </div>
        <div class="row g-4">
            @foreach([1 => '🛒', 2 => '🧑‍💼', 3 => '🎨', 4 => '📣'] as $n => $emoji)
            <div class="col-sm-6 col-lg-3">
                <div class="rb-card">
                    <div class="rb-icon">{{ $emoji }}</div>
                    <h3 class="h5">{{ __('messages.bg_use' . $n . '_title') }}</h3>
                    <p class="mb-0 text-muted">{{ __('messages.bg_use' . $n . '_desc') }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================== TIPS ============================== --}}
<section class="rb-section alt" id="tips">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="rb-title">{{ __('content.tips_title') }}</h2>
            <p class="rb-sub">{{ __('content.tips_sub') }}</p>
        </div>
        <div class="row g-4">
            @foreach([1 => '💡', 2 => '🎯', 3 => '🔍', 4 => '📐', 5 => '🧹', 6 => '🎨'] as $n => $emoji)
            <div class="col-md-6 col-lg-4">
                <div class="rb-card">
                    <div class="rb-icon">{{ $emoji }}</div>
                    <h3 class="h5">{{ __('content.tip' . $n . '_t') }}</h3>
                    <p class="mb-0 text-muted">{{ __('content.tip' . $n . '_d') }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================== STATS ============================== --}}
<section class="rb-stats">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-6 col-md-3"><h3>100M+</h3><p>{{ __('messages.bg_stat_images') }}</p></div>
            <div class="col-6 col-md-3"><h3>20M+</h3><p>{{ __('messages.bg_stat_users') }}</p></div>
            <div class="col-6 col-md-3"><h3>95%+</h3><p>{{ __('messages.bg_stat_accuracy') }}</p></div>
            <div class="col-6 col-md-3"><h3>190+</h3><p>{{ __('messages.bg_stat_countries') }}</p></div>
        </div>
    </div>
</section>

{{-- ============================== GUIDE ============================== --}}
<section class="rb-section" id="guide">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="rb-title">{{ __('content.guide_title') }}</h2>
            <p class="rb-sub">{{ __('content.guide_intro') }}</p>
        </div>
        <div class="row g-4">
            @foreach([1, 2, 3, 4] as $n)
            <div class="col-md-6">
                <div class="rb-card">
                    <h3 class="h5">{{ $n }}. {{ __('content.guide' . $n . '_t') }}</h3>
                    <p class="mb-0 text-muted">{{ __('content.guide' . $n . '_d') }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================== FAQ ============================== --}}
<section class="rb-section alt" id="faq">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="rb-title">{{ __('messages.faq_title') }}</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="accordion" id="faqAccordion">
                    @for($i = 1; $i <= 10; $i++)
                    @php
                        $q = $i <= 5 ? __('messages.faq_q' . $i) : __('content.faq_q' . $i);
                        $ans = $i <= 5 ? __('messages.faq_a' . $i) : __('content.faq_a' . $i);
                    @endphp
                    <div class="accordion-item">
                        <h3 class="accordion-header">
                            <button class="accordion-button {{ $i === 1 ? '' : 'collapsed' }}" type="button"
                                data-bs-toggle="collapse" data-bs-target="#faq{{ $i }}"
                                aria-expanded="{{ $i === 1 ? 'true' : 'false' }}" aria-controls="faq{{ $i }}">
                                {{ $q }}
                            </button>
                        </h3>
                        <div id="faq{{ $i }}" class="accordion-collapse collapse {{ $i === 1 ? 'show' : '' }}" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">{!! $ans !!}</div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================== ARTICLE ============================== --}}
<section class="rb-section" id="article">
    <div class="container">
        <article class="rb-article" itemscope itemtype="https://schema.org/Article">
            <meta itemprop="datePublished" content="2024-01-15T08:00:00+00:00">
            <meta itemprop="dateModified" content="{{ now()->toIso8601String() }}">
            <div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
                <meta itemprop="name" content="RemoveBG">
                <meta itemprop="url" content="{{ url(($locale ?? 'en')) }}">
            </div>

            <h2 class="rb-title mb-2" itemprop="headline">{{ __('messages.bg_article_title') }}</h2>
            <p class="rb-meta mb-4">🕒 {{ __('messages.bg_article_read_time') }} &nbsp;·&nbsp; 👤 {{ __('messages.bg_article_author') }}</p>

            <div itemprop="articleBody">
                <p class="lead">{!! __('messages.bg_article_intro') !!}</p>

                <h3>{{ __('messages.bg_article_h3_what') }}</h3>
                <p>{!! __('messages.bg_article_what_p1') !!}</p>
                <p>{!! __('messages.bg_article_what_p2') !!}</p>

                <div class="rb-quote my-4">{!! __('messages.bg_article_quote') !!}</div>

                <h3>{{ __('messages.bg_article_h3_how') }}</h3>
                <p>{!! __('messages.bg_article_how_p1') !!}</p>
                <p>{!! __('messages.bg_article_how_p2') !!}</p>

                <h3>{{ __('messages.bg_article_h3_privacy') }}</h3>
                <div class="row g-3 my-2">
                    <div class="col-md-6">
                        <div class="card border-success h-100">
                            <div class="card-header bg-success text-white fw-semibold">🔒 {{ __('messages.article_security_panel_good') }}</div>
                            <ul class="list-group list-group-flush">
                                @for($i = 1; $i <= 5; $i++)
                                <li class="list-group-item">✅ {{ __('messages.article_security_good' . $i) }}</li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-danger h-100">
                            <div class="card-header bg-danger text-white fw-semibold">⚠️ {{ __('messages.article_security_panel_bad') }}</div>
                            <ul class="list-group list-group-flush">
                                @for($i = 1; $i <= 5; $i++)
                                <li class="list-group-item">❌ {{ __('messages.article_security_bad' . $i) }}</li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                </div>
                <p class="mt-3">{!! __('messages.bg_article_privacy_p1') !!}</p>
                <p>{!! __('messages.bg_article_privacy_p2') !!}</p>

                <h3>{{ __('messages.bg_article_h3_quality') }}</h3>
                <p>{!! __('messages.bg_article_quality_p1') !!}</p>
                <p>{!! __('messages.bg_article_quality_p2') !!}</p>

                <h3>{{ __('messages.bg_article_h3_usecases') }}</h3>
                <p>{!! __('messages.bg_article_usecases_intro') !!}</p>
                <ul class="rb-list">
                    <li>🛒 {!! __('messages.bg_article_usecase1') !!}</li>
                    <li>🎨 {!! __('messages.bg_article_usecase2') !!}</li>
                    <li>📷 {!! __('messages.bg_article_usecase3') !!}</li>
                    <li>💼 {!! __('messages.bg_article_usecase4') !!}</li>
                    <li>▶️ {!! __('messages.bg_article_usecase5') !!}</li>
                    <li>🎓 {!! __('messages.bg_article_usecase6') !!}</li>
                </ul>

                <h3>{{ __('messages.bg_article_h3_comparison') }}</h3>
                @php
                    $cmp = [
                        ['bg_comparison_free',         ['bg_comparison_always', 1], ['bg_comparison_limited', 0], ['bg_comparison_limited', 0], ['bg_comparison_limited', 0]],
                        ['bg_comparison_no_upload',    ['bg_comparison_yes', 1],    ['bg_comparison_no', 0],      ['bg_comparison_no', 0],      ['bg_comparison_no', 0]],
                        ['bg_comparison_no_reg',       ['bg_comparison_yes', 1],    ['bg_comparison_no', 0],      ['bg_comparison_no', 0],      ['bg_comparison_no', 0]],
                        ['bg_comparison_no_watermark', ['bg_comparison_yes', 1],    ['bg_comparison_no', 0],      ['bg_comparison_partial', 0], ['bg_comparison_no', 0]],
                        ['bg_comparison_unlimited',    ['bg_comparison_yes', 1],    ['bg_comparison_no', 0],      ['bg_comparison_limited', 0], ['bg_comparison_limited', 0]],
                        ['bg_comparison_privacy',      ['bg_comparison_yes', 1],    ['bg_comparison_no', 0],      ['bg_comparison_no', 0],      ['bg_comparison_no', 0]],
                    ];
                @endphp
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('messages.bg_comparison_feature') }}</th>
                                <th class="table-success">🏆 RemoveBG</th>
                                <th>Remove.bg</th>
                                <th>Canva</th>
                                <th>Adobe Express</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cmp as $row)
                            <tr>
                                <td class="fw-semibold">{{ __('messages.' . $row[0]) }}</td>
                                @for($c = 1; $c <= 4; $c++)
                                <td class="{{ $c === 1 ? 'table-success' : '' }}">{{ $row[$c][1] ? '✅' : '❌' }} {{ __('messages.' . $row[$c][0]) }}</td>
                                @endfor
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="alert alert-primary mt-4">
                    <h4 class="h5">👆 {{ __('messages.bg_article_cta_title') }}</h4>
                    <p>{!! __('messages.bg_article_cta_text') !!}</p>
                    <a href="#tool" class="btn btn-primary btn-lg">{{ __('messages.bg_article_cta_btn') }}</a>
                </div>
            </div>
        </article>
    </div>
</section>

{{-- ============================== ABOUT ============================== --}}
<section class="rb-section alt" id="about">
    <div class="container">
        <div class="rb-article">
            <h2 class="rb-title mb-4 text-center">{{ __('content.about_title') }}</h2>
            <p>{{ __('content.about_p1') }}</p>
            <p>{{ __('content.about_p2') }}</p>
            <p class="mb-0">{{ __('content.about_p3') }}</p>
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
