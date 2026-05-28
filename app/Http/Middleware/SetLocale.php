<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    /**
     * Supported locales
     */
    public const LOCALES = ['en', 'pt', 'es', 'fr', 'zh', 'hi', 'ru'];

    /**
     * Default locale
     */
    public const DEFAULT_LOCALE = 'en';

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->route('locale', self::DEFAULT_LOCALE);

        if (!in_array($locale, self::LOCALES)) {
            $locale = self::DEFAULT_LOCALE;
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
