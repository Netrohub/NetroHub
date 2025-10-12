<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KycVerificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Skip middleware for non-authenticated users
        if (!$user) {
            return $next($request);
        }

        // Skip middleware for users without seller accounts
        if (!$user->seller) {
            return $next($request);
        }

        // Check if seller is KYC verified
        if (!$user->seller->isKycVerified()) {
            // If it's an API request, return JSON response
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'KYC verification required',
                    'message' => 'You must complete KYC verification before selling on our platform.',
                    'kyc_status' => $user->seller->kyc_status,
                ], 403);
            }

            // For web requests, redirect to KYC verification page
            return redirect()->route('kyc.verification.show')
                ->with('error', 'You must complete KYC verification before selling on our platform.');
        }

        return $next($request);
    }
}
