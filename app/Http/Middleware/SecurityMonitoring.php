<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SecurityMonitoring
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);
        
        $response = $next($request);
        
        $this->logSecurityEvent($request, $response, $startTime);
        
        return $response;
    }

    /**
     * Log security-relevant events
     */
    private function logSecurityEvent(Request $request, Response $response, float $startTime): void
    {
        $executionTime = microtime(true) - $startTime;
        
        // Log suspicious activities
        if ($this->isSuspiciousRequest($request, $response, $executionTime)) {
            Log::warning('Suspicious request detected', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'status_code' => $response->getStatusCode(),
                'execution_time' => $executionTime,
                'user_id' => auth()->id(),
                'timestamp' => now()->toISOString(),
            ]);
        }

        // Log failed authentication attempts
        if ($response->getStatusCode() === 401 || $response->getStatusCode() === 403) {
            Log::info('Authentication/Authorization failure', [
                'ip' => $request->ip(),
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'status_code' => $response->getStatusCode(),
                'user_id' => auth()->id(),
                'timestamp' => now()->toISOString(),
            ]);
        }

        // Log admin access
        if ($request->is('admin/*') && auth()->check()) {
            Log::info('Admin access', [
                'ip' => $request->ip(),
                'url' => $request->fullUrl(),
                'user_id' => auth()->id(),
                'user_email_hash' => hash('sha256', auth()->user()->email),
                'timestamp' => now()->toISOString(),
            ]);
        }
    }

    /**
     * Check if request is suspicious
     */
    private function isSuspiciousRequest(Request $request, Response $response, float $executionTime): bool
    {
        // Check for SQL injection attempts
        $suspiciousPatterns = [
            'union select',
            'drop table',
            'delete from',
            'insert into',
            'update set',
            'script>',
            'javascript:',
            'vbscript:',
            'onload=',
            'onerror=',
        ];

        $input = json_encode($request->all());
        foreach ($suspiciousPatterns as $pattern) {
            if (stripos($input, $pattern) !== false) {
                return true;
            }
        }

        // Check for unusually long execution time (potential DoS)
        if ($executionTime > 10) {
            return true;
        }

        // Check for unusual user agents
        $userAgent = $request->userAgent();
        if (empty($userAgent) || strlen($userAgent) > 500) {
            return true;
        }

        // Check for too many parameters (potential DoS)
        if (count($request->all()) > 100) {
            return true;
        }

        return false;
    }
}