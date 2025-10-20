<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CspMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Generate per-request nonce for inline scripts
        $nonce = base64_encode(random_bytes(16));
        app()->instance('csp_nonce', $nonce);

        $response = $next($request);

        // Strict CSP policy without unsafe-eval and minimal unsafe-inline
        $csp = [
            "default-src 'self'",
            "base-uri 'self'",
            "object-src 'none'",
            "frame-ancestors 'none'",
            "upgrade-insecure-requests",
            "form-action 'self'",
            "img-src 'self' data: https:",
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://fonts.bunny.net",
            "font-src 'self' data: https://fonts.gstatic.com https://fonts.bunny.net",
            "connect-src 'self' https://challenges.cloudflare.com",
            "frame-src https://challenges.cloudflare.com",
            "script-src 'self' 'nonce-{$nonce}' https://challenges.cloudflare.com",
            "media-src 'self'",
            "manifest-src 'self'",
            "worker-src 'self'",
            "child-src 'self'",
        ];

        $response->headers->set('Content-Security-Policy', implode('; ', $csp));
        
        return $response;
    }

    /**
     * Get the CSP nonce for the current request.
     */
    public static function nonce(): string
    {
        return app('csp_nonce') ?? '';
    }
}
