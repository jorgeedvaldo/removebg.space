<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\PageController;
use App\Http\Controllers\BackgroundRemovalController;
use App\Http\Middleware\SetLocale;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Root redirect to default locale
Route::get('/', function () {
    return redirect('/' . SetLocale::DEFAULT_LOCALE);
});

// Locale-prefixed routes
Route::group([
    'prefix' => '{locale}',
    'middleware' => 'locale',
    'where' => ['locale' => implode('|', SetLocale::LOCALES)],
], function () {
    // The background remover tool IS the homepage
    Route::get('/', [PageController::class, 'index'])->name('home');
    Route::get('/feed.xml', [PageController::class, 'feed'])->name('feed');
    Route::get('/sitemap.xml', [PageController::class, 'sitemap'])->name('sitemap');
});

// Background removal API (server-side processing; locale-independent)
Route::post('/remove-background', [BackgroundRemovalController::class, 'process'])->name('bg.process');
Route::get('/r/{id}', [BackgroundRemovalController::class, 'result'])->name('bg.result');

// Global sitemap index (no locale prefix)
Route::get('/sitemap.xml', [PageController::class, 'sitemapIndex'])->name('sitemap.index');

// Global RSS redirect
Route::get('/feed.xml', function () {
    return redirect('/' . SetLocale::DEFAULT_LOCALE . '/feed.xml');
});

// Clear all caches (access via /clear-cache)
Route::get('/clear-cache', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('package:discover');

    return 'All caches cleared successfully! ✅';
});
