<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class EnsureEnvironmentConfigured
{
    /**
     * Critical environment variables that must be set
     */
    protected array $requiredVars = [
        'APP_KEY',
        'APP_URL',
        'DB_CONNECTION',
        'DB_DATABASE',
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip in console
        if (app()->runningInConsole()) {
            return $next($request);
        }

        // Check critical environment variables
        $missing = [];
        foreach ($this->requiredVars as $var) {
            if (empty(env($var))) {
                $missing[] = $var;
            }
        }

        if (!empty($missing)) {
            Log::critical('Missing critical environment variables', [
                'missing' => $missing,
                'url' => $request->fullUrl(),
            ]);

            if (config('app.debug')) {
                abort(500, 'Missing environment variables: ' . implode(', ', $missing));
            }

            abort(500, 'Application not configured properly. Please contact support.');
        }

        return $next($request);
    }
}

