# RemoveBG — removebg.space

A free **AI background remover** built with **Laravel**. The tool appears front
and center on the homepage (inspired by [remove.bg](https://remove.bg)): drop an
image and get a clean **transparent PNG** in seconds.

The AI runs **100% in the browser** via
[`@imgly/background-removal`](https://www.npmjs.com/package/@imgly/background-removal)
(ONNX model + WebAssembly, loaded through [esm.sh](https://esm.sh)). Images are
**never uploaded** to any server — processing happens entirely on the user's device.

## Features

- 🎯 **AI background removal** — transparent PNG output, no upload, no watermark
- 🖼️ **Before/After examples** — interactive comparison sliders on the homepage
- 🌍 **Multilingual** — English, Português, Español, Français, 中文, हिन्दी, Русский
- 🔍 **SEO‑ready** — localized meta tags, hreflang, canonical, Open Graph, Twitter
  cards, per‑locale sitemaps + sitemap index, RSS feed, and rich **JSON‑LD**
  structured data (`WebApplication`, `HowTo`, `FAQPage`, `Organization`)
- 🔒 **Privacy first** — nothing leaves the browser

## Stack

- **Laravel** `^9.19` (PHP `^8.0.2`) — same version as the `compress-img` project
- Bootstrap 3.3.7 + Font Awesome 4 (CDN)
- Vanilla JS for the tool (`public/js/remove-bg.js`)

## Project layout

| Path | Purpose |
| --- | --- |
| `routes/web.php` | Locale‑prefixed routes; the tool is the homepage |
| `app/Http/Controllers/PageController.php` | Home, sitemap(s) and RSS feed |
| `app/Http/Middleware/SetLocale.php` | Supported locales + locale switching |
| `resources/views/home.blade.php` | Tool + before/after examples + FAQ + SEO content |
| `resources/views/layouts/app.blade.php` | Shared layout, SEO meta, nav, footer |
| `public/js/remove-bg.js` | Client‑side background‑removal logic |
| `public/css/style.css` | Theme + before/after slider styles |
| `public/img/examples/*.svg` | Before/after illustration pairs |
| `lang/{en,pt,es,fr,zh,hi,ru}/messages.php` | Translations |

## Local development

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan serve
```

Then open <http://localhost:8000> (it redirects to `/en`).

## Adding a language

1. Add the locale code to `SetLocale::LOCALES`.
2. Map it to an HTML `lang` value in `PageController::$langMap`.
3. Create `lang/<locale>/messages.php`.
4. Add the `lang_<locale>` display name key in every `messages.php`.
