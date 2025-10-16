<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to access the admin panel.');
        }

        // Check if user is admin (you can customize this check)
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized access to admin panel.');
        }

        return $next($request);
    }
}

