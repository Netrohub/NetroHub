<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequirePhoneVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return $next($request);
        }

        // Allow admins to bypass
        if (method_exists($user, 'isAdmin') && $user->isAdmin()) {
            return $next($request);
        }

        if (! $user->isPhoneVerified()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Phone verification required',
                    'message' => 'You must verify your phone number before accessing this feature.',
                    'redirect_url' => route('account.phone.show'),
                ], 403);
            }

            return redirect()->route('account.phone.show')
                ->with('error', 'You must verify your phone number before accessing this feature.');
        }

        return $next($request);
    }
}


