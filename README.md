# RemoveBG — removebg.space

A free **AI background remover** built with **Laravel**. The tool appears front
and center on the homepage (inspired by [remove.bg](https://remove.bg)): drop an
image and get a clean **transparent PNG** in seconds.

The AI runs **on the server**, so visitors never download a large model. The
browser uploads the image, the background is removed server-side (by default
with [`@imgly/background-removal-node`](https://www.npmjs.com/package/@imgly/background-removal-node)),
and a transparent PNG is returned. **Uploads and results are automatically and
permanently deleted after 30 minutes.**

## Features

- 🎯 **AI background removal** — server-side, transparent PNG output, no watermark
- 🧹 **Auto-deletion** — uploads and results are wiped after 30 minutes
- 🖼️ **Before/After examples** — interactive comparison sliders on the homepage
- 🌍 **Multilingual** — English, Português, Español, Français, 中文, हिन्दी, Русский
- 🔍 **SEO‑ready** — localized meta tags, hreflang, canonical, Open Graph, Twitter
  cards, per‑locale sitemaps + sitemap index, RSS feed, and rich **JSON‑LD**
  structured data (`WebApplication`, `HowTo`, `FAQPage`, `Organization`)

## Stack

- **Laravel** `^9.19` (PHP `^8.0.2`) — same version as the `compress-img` project
- Bootstrap 3.3.7 + Font Awesome 4 (CDN)
- Vanilla JS uploader (`public/js/remove-bg.js`)
- Node worker for inference (`scripts/remove-bg-worker.cjs`)

## Background removal (server-side)

The browser POSTs the image to `POST /remove-background`
(`BackgroundRemovalController`). The controller stores it under
`storage/app/bg-removal/<uuid>/`, runs the configured **processor command**, and
returns a temporary URL (`GET /r/{uuid}`) to the resulting PNG.

- **Processor** — configurable via `BG_REMOVAL_PROCESSOR` (`{input}`/`{output}`
  placeholders). Default: the bundled Node worker. Swap for Python rembg with
  `BG_REMOVAL_PROCESSOR="rembg i {input} {output}"`.
- **30-minute retention** — the `bg:cleanup` command deletes expired jobs and is
  scheduled every 5 minutes. A small opportunistic sweep also runs on a fraction
  of requests, so retention still works without cron. Tunable via
  `BG_REMOVAL_RETENTION_MINUTES`.

For the deletion schedule to run, the Laravel scheduler must be active:

```cron
* * * * * cd /path/to/app && php artisan schedule:run >> /dev/null 2>&1
```

## Project layout

| Path | Purpose |
| --- | --- |
| `routes/web.php` | Locale‑prefixed routes; the tool is the homepage |
| `app/Http/Controllers/PageController.php` | Home, sitemap(s) and RSS feed |
| `app/Http/Middleware/SetLocale.php` | Supported locales + locale switching |
| `resources/views/home.blade.php` | Tool + before/after examples + FAQ + SEO content |
| `app/Http/Controllers/BackgroundRemovalController.php` | Upload, process, serve result |
| `app/Services/BackgroundRemover.php` | Runs the processor + retention/cleanup |
| `app/Console/Commands/CleanupBackgroundImages.php` | `bg:cleanup` command |
| `scripts/remove-bg-worker.cjs` | Default Node inference worker |
| `config/bgremoval.php` | Processor, retention, limits |
| `resources/views/layouts/app.blade.php` | Shared layout, SEO meta, nav, footer |
| `public/js/remove-bg.js` | Browser uploader / result display |
| `public/css/style.css` | Theme + before/after slider styles |
| `public/img/examples/*.svg` | Before/after illustration pairs |
| `lang/{en,pt,es,fr,zh,hi,ru}/messages.php` | Translations |

## Local development

```bash
composer install
npm install          # installs the Node background-removal worker
cp .env.example .env
php artisan key:generate
php artisan serve
```

Then open <http://localhost:8000> (it redirects to `/en`).

> The first removal downloads the AI model **to the server** (cached afterwards).
> No model is ever downloaded by visitors.

## Adding a language

1. Add the locale code to `SetLocale::LOCALES`.
2. Map it to an HTML `lang` value in `PageController::$langMap`.
3. Create `lang/<locale>/messages.php`.
4. Add the `lang_<locale>` display name key in every `messages.php`.
