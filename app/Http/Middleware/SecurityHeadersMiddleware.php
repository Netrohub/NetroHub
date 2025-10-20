<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeadersMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Security headers to prevent common attacks
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        
        // Permissions Policy to restrict browser features (only supported features)
        $response->headers->set('Permissions-Policy', implode(', ', [
            'geolocation=()',
            'microphone=()',
            'camera=()',
            'payment=()',
            'usb=()',
            'magnetometer=()',
            'gyroscope=()',
            'accelerometer=()',
            'autoplay=(self "https://challenges.cloudflare.com")',
            'bluetooth=()',
            'clipboard-read=()',
            'clipboard-write=()',
            'display-capture=()',
            'encrypted-media=()',
            'fullscreen=(self "https://challenges.cloudflare.com")',
            'gamepad=()',
            'hid=()',
            'idle-detection=()',
            'local-fonts=()',
            'midi=()',
            'picture-in-picture=(self)',
            'publickey-credentials-get=()',
            'screen-wake-lock=()',
            'serial=()',
            'storage-access=()',
            'sync-xhr=()',
            'unload=()',
            'web-share=()',
            'xr-spatial-tracking=()'
        ]));

        // Cross-Origin policies (relaxed for Turnstile compatibility)
        $response->headers->set('Cross-Origin-Embedder-Policy', 'unsafe-none');
        $response->headers->set('Cross-Origin-Opener-Policy', 'same-origin-allow-popups');
        $response->headers->set('Cross-Origin-Resource-Policy', 'cross-origin');
        
        // Remove server information
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');

        // Strict-Transport-Security (HSTS) - only if using HTTPS
        if ($request->secure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        }

        return $response;
    }
}
