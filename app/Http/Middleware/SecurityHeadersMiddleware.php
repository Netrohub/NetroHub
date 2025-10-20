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
        
        // Permissions Policy to restrict browser features
        $response->headers->set('Permissions-Policy', implode(', ', [
            'geolocation=()',
            'microphone=()',
            'camera=()',
            'payment=()',
            'usb=()',
            'magnetometer=()',
            'gyroscope=()',
            'accelerometer=()',
            'ambient-light-sensor=()',
            'autoplay=()',
            'battery=()',
            'bluetooth=()',
            'clipboard-read=()',
            'clipboard-write=()',
            'display-capture=()',
            'document-domain=()',
            'encrypted-media=()',
            'fullscreen=(self)',
            'gamepad=()',
            'hid=()',
            'idle-detection=()',
            'local-fonts=()',
            'midi=()',
            'notifications=()',
            'picture-in-picture=()',
            'publickey-credentials-get=()',
            'screen-wake-lock=()',
            'serial=()',
            'speaker-selection=()',
            'storage-access=()',
            'sync-xhr=()',
            'unload=()',
            'vertical-scroll=()',
            'web-share=()',
            'xr-spatial-tracking=()'
        ]));

        // Cross-Origin policies
        $response->headers->set('Cross-Origin-Embedder-Policy', 'require-corp');
        $response->headers->set('Cross-Origin-Opener-Policy', 'same-origin');
        $response->headers->set('Cross-Origin-Resource-Policy', 'same-origin');
        
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
