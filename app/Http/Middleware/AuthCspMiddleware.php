<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthCspMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Apply specific CSP for authentication pages
        if ($request->is('login', 'register', 'forgot-password', 'reset-password/*')) {
            $cspDirectives = [
                "default-src 'self'",
                "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://challenges.cloudflare.com https://www.googletagmanager.com https://www.google-analytics.com",
                "style-src 'self' 'unsafe-inline' https://fonts.bunny.net https://*.cloudflare.com",
                "img-src 'self' data: https: https://www.google-analytics.com",
                "font-src 'self' https://fonts.bunny.net",
                "connect-src 'self' https://www.google-analytics.com https://challenges.cloudflare.com https://*.cloudflare.com",
                "frame-src 'self' https://challenges.cloudflare.com https://*.cloudflare.com",
                "frame-ancestors 'self'",
                "object-src 'none'",
                "base-uri 'self'",
                "form-action 'self'"
            ];

            $cspHeader = implode('; ', $cspDirectives);
            $response->headers->set('Content-Security-Policy', $cspHeader);
        }

        return $response;
    }
}
