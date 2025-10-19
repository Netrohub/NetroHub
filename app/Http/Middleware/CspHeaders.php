<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CspHeaders
{
    public function handle(Request $request, Closure $next)
    {
        // Per-request nonce for inline scripts (used by Vite/Blade)
        $nonce = base64_encode(random_bytes(16));
        app()->instance('csp_nonce', $nonce);

        $response = $next($request);

        // Allow Turnstile + Vite + self
        // NOTE: owner will tune further if needed (fonts, analytics, etc.)
        $csp = [
            "default-src 'self'",
            "base-uri 'self'",
            "img-src 'self' data: https:",
            "style-src 'self' 'unsafe-inline' https://challenges.cloudflare.com", // Tailwind inline + Turnstile
            "font-src 'self' data:",
            "connect-src 'self' https://challenges.cloudflare.com",
            "frame-src https://challenges.cloudflare.com",
            "script-src 'self' 'nonce-{$nonce}' https://challenges.cloudflare.com",
            "object-src 'none'",
            "frame-ancestors 'self'",
            "upgrade-insecure-requests",
        ];

        $response->headers->set('Content-Security-Policy', implode('; ', $csp));
        return $response;
    }

    public static function nonce(): string
    {
        return app('csp_nonce') ?? '';
    }
}
