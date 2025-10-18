<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Security headers to prevent common attacks
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        
        // Remove server information
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');

        // Content Security Policy (adjust based on your needs)
        if (!config('app.debug')) {
            $response->headers->set('Content-Security-Policy', 
                "default-src 'self'; " .
                "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://fonts.bunny.net https://www.googletagmanager.com https://challenges.cloudflare.com; " .
                "style-src 'self' 'unsafe-inline' https://fonts.bunny.net; " .
                "img-src 'self' data: https:; " .
                "font-src 'self' https://fonts.bunny.net; " .
                "connect-src 'self' https://challenges.cloudflare.com; " .
                "frame-src 'self' https://challenges.cloudflare.com; " .
                "frame-ancestors 'self';"
            );
        }

        // Strict-Transport-Security (HSTS) - only if using HTTPS
        if ($request->secure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        return $response;
    }
}

