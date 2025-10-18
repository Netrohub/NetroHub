<?php

namespace App\Http\Controllers;

use App\Models\SocialAccountVerification;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SocialAccountVerificationController extends Controller
{
    /**
     * Start the verification process
     */
    public function start(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'platform' => 'required|string|in:Instagram,TikTok,X (Twitter),YouTube,Discord,Facebook,Snapchat,Twitch,LinkedIn,Reddit',
            'username' => 'required|string|max:255|regex:/^[a-zA-Z0-9._-]+$/',
        ]);

        $user = auth()->user();
        
        // Check if user already has a verified account for this platform/username
        $existingVerification = SocialAccountVerification::where('user_id', $user->id)
            ->where('platform', $validated['platform'])
            ->where('username', $validated['username'])
            ->where('is_verified', true)
            ->first();

        if ($existingVerification) {
            return response()->json([
                'success' => true,
                'already_verified' => true,
                'message' => 'This account is already verified.',
            ]);
        }

        // Create new verification
        $verification = SocialAccountVerification::createVerification(
            $user->id,
            $validated['platform'],
            $validated['username']
        );

        return response()->json([
            'success' => true,
            'verification' => [
                'id' => $verification->id,
                'token' => $verification->verification_token,
                'platform' => $verification->platform,
                'username' => $verification->username,
                'account_url' => $verification->getAccountUrl(),
                'expires_at' => $verification->expires_at->toISOString(),
                'time_remaining' => $verification->getFormattedTimeRemaining(),
            ],
            'message' => 'Verification token generated. Please add it to your account bio.',
        ]);
    }

    /**
     * Verify the account ownership
     */
    public function verify(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'verification_id' => 'required|exists:social_account_verifications,id',
        ]);

        $user = auth()->user();
        $verification = SocialAccountVerification::where('id', $validated['verification_id'])
            ->where('user_id', $user->id)
            ->first();

        if (!$verification) {
            return response()->json([
                'success' => false,
                'message' => 'Verification not found.',
            ], 404);
        }

        if ($verification->isExpired()) {
            return response()->json([
                'success' => false,
                'message' => 'Verification token has expired. Please start a new verification.',
            ], 400);
        }

        if ($verification->is_verified) {
            return response()->json([
                'success' => true,
                'already_verified' => true,
                'message' => 'Account is already verified.',
            ]);
        }

        // Check if token exists in the account bio
        $tokenFound = $this->checkTokenInBio($verification);

        if ($tokenFound) {
            $verification->markAsVerified();
            
            return response()->json([
                'success' => true,
                'message' => 'Account ownership verified successfully!',
                'verified_at' => $verification->verified_at->toISOString(),
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Token not found in account bio. Please add the token and try again.',
                'token' => $verification->verification_token,
            ], 400);
        }
    }

    /**
     * Get verification status
     */
    public function status(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'verification_id' => 'required|exists:social_account_verifications,id',
        ]);

        $user = auth()->user();
        $verification = SocialAccountVerification::where('id', $validated['verification_id'])
            ->where('user_id', $user->id)
            ->first();

        if (!$verification) {
            return response()->json([
                'success' => false,
                'message' => 'Verification not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'verification' => [
                'id' => $verification->id,
                'platform' => $verification->platform,
                'username' => $verification->username,
                'is_verified' => $verification->is_verified,
                'is_expired' => $verification->isExpired(),
                'time_remaining' => $verification->getFormattedTimeRemaining(),
                'expires_at' => $verification->expires_at->toISOString(),
                'verified_at' => $verification->verified_at?->toISOString(),
            ],
        ]);
    }

    /**
     * Check if token exists in the account bio
     * This is a simplified implementation - in production, you'd use platform APIs
     */
    private function checkTokenInBio(SocialAccountVerification $verification): bool
    {
        try {
            // For demonstration purposes, we'll simulate API calls
            // In a real implementation, you would:
            // 1. Use platform-specific APIs (Instagram Basic Display API, TikTok API, etc.)
            // 2. Handle rate limiting and authentication
            // 3. Parse the bio/description field for the token
            
            $token = $verification->verification_token;
            
            // Simulate different success rates based on platform
            $successRates = [
                'Instagram' => 0.8, // 80% success rate for demo
                'TikTok' => 0.7,
                'X (Twitter)' => 0.9,
                'YouTube' => 0.6,
                'Discord' => 0.5,
                'Facebook' => 0.7,
                'Snapchat' => 0.4,
                'Twitch' => 0.8,
                'LinkedIn' => 0.9,
                'Reddit' => 0.6,
            ];

            $successRate = $successRates[$verification->platform] ?? 0.5;
            
            // For demo purposes, randomly return success based on platform
            // In production, replace this with actual API calls
            $isSuccess = (mt_rand() / mt_getrandmax()) < $successRate;
            
            Log::info('Social account verification check', [
                'platform' => $verification->platform,
                'username' => $verification->username,
                'token' => $token,
                'success' => $isSuccess,
            ]);

            return $isSuccess;

        } catch (\Exception $e) {
            Log::error('Error checking token in bio', [
                'verification_id' => $verification->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Get user's verified accounts
     */
    public function getVerifiedAccounts(): JsonResponse
    {
        $user = auth()->user();
        
        $verifiedAccounts = SocialAccountVerification::where('user_id', $user->id)
            ->where('is_verified', true)
            ->get()
            ->map(function ($verification) {
                return [
                    'id' => $verification->id,
                    'platform' => $verification->platform,
                    'username' => $verification->username,
                    'account_url' => $verification->getAccountUrl(),
                    'verified_at' => $verification->verified_at->toISOString(),
                ];
            });

        return response()->json([
            'success' => true,
            'verified_accounts' => $verifiedAccounts,
        ]);
    }

    /**
     * Clean up expired verifications (can be called via cron job)
     */
    public function cleanupExpired(): void
    {
        $deleted = SocialAccountVerification::expired()
            ->where('is_verified', false)
            ->delete();

        Log::info('Cleaned up expired social account verifications', [
            'deleted_count' => $deleted,
        ]);
    }
}
