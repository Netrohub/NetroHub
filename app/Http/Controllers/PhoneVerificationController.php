<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PhoneVerificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $user = Auth::user();
        return view('account.phone-verification', compact('user'));
    }

    public function sendCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:20|regex:/^[+]?[0-9\s\-\(\)]+$/',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid phone number format.',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();
        
        try {
            // Generate verification code
            $code = $user->generatePhoneVerificationCode();
            
            // Update user's phone number
            $user->update(['phone' => $request->phone]);

            // In a real application, you would send SMS here
            // For demo purposes, we'll log the code
            \Log::info('Phone verification code for user ' . $user->id . ': ' . $code);

            return response()->json([
                'success' => true,
                'message' => 'Verification code sent successfully!',
                'debug_code' => config('app.debug') ? $code : null, // Only show in debug mode
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to send phone verification code', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to send verification code. Please try again.',
            ], 500);
        }
    }

    public function verifyCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|size:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please enter a valid 6-digit code.',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();

        if (!$user->hasPhoneNumber()) {
            return response()->json([
                'success' => false,
                'message' => 'No phone number found. Please send a verification code first.',
            ], 400);
        }

        try {
            if ($user->verifyPhoneCode($request->code)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Phone number verified successfully!',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid or expired verification code.',
                ], 400);
            }

        } catch (\Exception $e) {
            \Log::error('Phone verification failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Verification failed. Please try again.',
            ], 500);
        }
    }

    public function resendCode(Request $request)
    {
        $user = Auth::user();

        if (!$user->hasPhoneNumber()) {
            return response()->json([
                'success' => false,
                'message' => 'No phone number found. Please enter your phone number first.',
            ], 400);
        }

        try {
            $code = $user->generatePhoneVerificationCode();
            
            // In a real application, you would send SMS here
            \Log::info('Resent phone verification code for user ' . $user->id . ': ' . $code);

            return response()->json([
                'success' => true,
                'message' => 'Verification code resent successfully!',
                'debug_code' => config('app.debug') ? $code : null,
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to resend phone verification code', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to resend verification code. Please try again.',
            ], 500);
        }
    }
}
