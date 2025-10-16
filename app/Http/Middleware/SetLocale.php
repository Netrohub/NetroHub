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
        // Always set locale to Arabic
        $locale = 'ar';

        // Set locale
        App::setLocale($locale);
        Session::put('locale', $locale);

        // Set text direction to RTL for Arabic
        Session::put('direction', 'rtl');

        return $next($request);
    }
}

