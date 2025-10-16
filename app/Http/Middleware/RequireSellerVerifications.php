<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireSellerVerifications
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

        // Admins bypass
        if (method_exists($user, 'isAdmin') && $user->isAdmin()) {
            return $next($request);
        }

        $emailVerified = method_exists($user, 'hasVerifiedEmail') ? $user->hasVerifiedEmail() : (bool) $user->email_verified_at;
        $phoneVerified = method_exists($user, 'isPhoneVerified') ? $user->isPhoneVerified() : false;
        $kycVerified = $user->seller && method_exists($user->seller, 'isKycVerified') ? $user->seller->isKycVerified() : false;

        if (! ($emailVerified && $phoneVerified && $kycVerified)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Seller verifications required',
                    'email_verified' => $emailVerified,
                    'phone_verified' => $phoneVerified,
                    'kyc_verified' => $kycVerified,
                    'redirect_url' => route('account.verification.checklist'),
                ], 403);
            }

            return redirect()->route('account.verification.checklist');
        }

        return $next($request);
    }
}


