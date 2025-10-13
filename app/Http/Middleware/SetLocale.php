<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get locale from session, query parameter, or default
        $locale = $request->get('lang') ?? Session::get('locale') ?? config('app.locale', 'en');

        // Validate locale
        $availableLocales = ['en', 'ar'];
        if (!in_array($locale, $availableLocales)) {
            $locale = 'en';
        }

        // Set locale
        App::setLocale($locale);
        Session::put('locale', $locale);

        // Set text direction in session for views
        Session::put('direction', $locale === 'ar' ? 'rtl' : 'ltr');

        return $next($request);
    }
}

