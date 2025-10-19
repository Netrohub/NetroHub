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

        // Content Security Policy - explicit directives to prevent fallback warnings
        if (config('csp.enabled', true)) {
            $cspDirectives = [];
            $directives = config('csp.directives', []);
            
            foreach ($directives as $directive => $sources) {
                if (is_array($sources)) {
                    $cspDirectives[] = $directive . ' ' . implode(' ', $sources);
                } else {
                    $cspDirectives[] = $directive . ' ' . $sources;
                }
            }
            
            $cspHeader = implode('; ', $cspDirectives);
            
            // Add report-uri if configured
            if (config('csp.report-uri')) {
                $cspHeader .= '; report-uri ' . config('csp.report-uri');
            }
            
            // Use Report-Only mode if configured
            $headerName = config('csp.report-only', false) ? 'Content-Security-Policy-Report-Only' : 'Content-Security-Policy';
            $response->headers->set($headerName, $cspHeader);
        }

        // Strict-Transport-Security (HSTS) - only if using HTTPS
        if ($request->secure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        return $response;
    }
}

