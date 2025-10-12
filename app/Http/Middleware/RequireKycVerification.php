<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireKycVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Skip verification check for admins
        if ($user && ($user->hasRole('admin') || $user->hasRole('super-admin'))) {
            return $next($request);
        }

        // Check if user is verified
        if (!$user || !$user->isVerified()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Account verification required',
                    'message' => 'You must verify your identity before accessing this feature.',
                    'redirect_url' => route('account.kyc.show')
                ], 403);
            }

            return redirect()->route('account.kyc.show')
                ->with('error', 'You must verify your identity before accessing this feature.');
        }

        return $next($request);
    }
}