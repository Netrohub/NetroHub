<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Notifications\PhoneVerifiedNotification;

class PhoneVerificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show phone verification form
     */
    public function show()
    {
        $user = Auth::user();
        return view('account.phone-verification', compact('user'));
    }

    /**
     * Send OTP code
     */
    public function sendCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid phone number format.',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();
        $phoneNumber = $request->phone_number;

        // Check rate limiting (max 3 attempts per hour)
        $rateLimitKey = 'phone_otp_' . $user->id;
        if (Cache::has($rateLimitKey)) {
            return response()->json([
                'success' => false,
                'message' => 'Please wait before requesting another code. You can try again in ' . Cache::get($rateLimitKey) . ' minutes.',
            ], 429);
        }

        try {
            // Generate 6-digit OTP code
            $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            
            // Store OTP with expiry (10 minutes)
            $otpKey = 'phone_otp_' . $user->id . '_' . $phoneNumber;
            Cache::put($otpKey, $otpCode, 600); // 10 minutes

            // Set rate limiting (1 hour cooldown)
            Cache::put($rateLimitKey, 60, 3600); // 1 hour

            // Update user's phone number
            $user->update(['phone_number' => $phoneNumber]);

            // In production, send SMS here
            // For now, we'll log it
            Log::info('Phone OTP sent', [
                'user_id' => $user->id,
                'phone' => $phoneNumber,
                'otp' => $otpCode, // Remove this in production
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Verification code sent to ' . $phoneNumber,
                'otp' => $otpCode, // Remove this in production - only for testing
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to send phone OTP', [
                'user_id' => $user->id,
                'phone' => $phoneNumber,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to send verification code. Please try again.',
            ], 500);
        }
    }

    /**
     * Verify OTP code
     */
    public function verifyCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string',
            'otp_code' => 'required|string|size:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid verification code format.',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();
        $phoneNumber = $request->phone_number;
        $otpCode = $request->otp_code;

        try {
            // Check OTP
            $otpKey = 'phone_otp_' . $user->id . '_' . $phoneNumber;
            $storedOtp = Cache::get($otpKey);

            if (!$storedOtp || $storedOtp !== $otpCode) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid verification code. Please try again.',
                ], 422);
            }

            // Verify the phone number
            $user->update([
                'phone_number' => $phoneNumber,
                'phone_verified_at' => now(),
            ]);

            // Clear the OTP from cache
            Cache::forget($otpKey);

            // Send verification notification
            $user->notify(new PhoneVerifiedNotification($phoneNumber));

            Log::info('Phone number verified', [
                'user_id' => $user->id,
                'phone' => $phoneNumber,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Phone number verified successfully!',
            ]);

        } catch (\Exception $e) {
            Log::error('Phone verification failed', [
                'user_id' => $user->id,
                'phone' => $phoneNumber,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Verification failed. Please try again.',
            ], 500);
        }
    }

    /**
     * Resend OTP code
     */
    public function resendCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid phone number format.',
                'errors' => $validator->errors()
            ], 422);
        }

        return $this->sendCode($request);
    }
}