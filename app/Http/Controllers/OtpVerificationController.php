<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class OtpVerificationController extends Controller
{
    /**
     * Send OTP to phone number
     */
    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|regex:/^\+[1-9]\d{1,14}$/',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid phone number format. Use international format: +1234567890',
                'errors' => $validator->errors()
            ], 422);
        }

        $phone = $request->phone;

        // Rate limiting: Max 3 OTPs per phone per hour
        $recentOtps = DB::table('otp_verifications')
            ->where('phone', $phone)
            ->where('created_at', '>', Carbon::now()->subHour())
            ->count();

        if ($recentOtps >= 3) {
            return response()->json([
                'success' => false,
                'message' => 'Too many OTP requests. Please try again later.',
            ], 429);
        }

        try {
            // Generate 6-digit OTP
            $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $expiresAt = Carbon::now()->addMinutes(5);

            // Save OTP to database
            DB::table('otp_verifications')->insert([
                'phone' => $phone,
                'otp' => $otp,
                'expires_at' => $expiresAt,
                'verified' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // Send OTP via MessageBird
            $this->sendSms($phone, $otp);

            Log::info('OTP sent successfully', [
                'phone' => $phone,
                'expires_at' => $expiresAt
            ]);

            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully to ' . $phone,
                'expires_in' => 300, // 5 minutes in seconds
                // For testing only - remove in production
                'otp_code' => config('app.env') === 'local' ? $otp : null,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to send OTP', [
                'phone' => $phone,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to send OTP. Please try again.',
            ], 500);
        }
    }

    /**
     * Verify OTP code
     */
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
            'code' => 'required|string|size:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input.',
                'errors' => $validator->errors()
            ], 422);
        }

        $phone = $request->phone;
        $code = $request->code;

        try {
            // Find the most recent OTP for this phone
            $otpRecord = DB::table('otp_verifications')
                ->where('phone', $phone)
                ->where('otp', $code)
                ->where('verified', false)
                ->where('expires_at', '>', Carbon::now())
                ->orderBy('created_at', 'desc')
                ->first();

            if (!$otpRecord) {
                // Check if OTP expired
                $expiredOtp = DB::table('otp_verifications')
                    ->where('phone', $phone)
                    ->where('otp', $code)
                    ->where('expires_at', '<=', Carbon::now())
                    ->exists();

                if ($expiredOtp) {
                    return response()->json([
                        'success' => false,
                        'message' => 'OTP has expired. Please request a new one.',
                    ], 401);
                }

                return response()->json([
                    'success' => false,
                    'message' => 'Invalid OTP code.',
                ], 401);
            }

            // Mark OTP as verified
            DB::table('otp_verifications')
                ->where('id', $otpRecord->id)
                ->update([
                    'verified' => true,
                    'verified_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

            Log::info('OTP verified successfully', [
                'phone' => $phone,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Phone number verified successfully!',
                'verified_at' => Carbon::now()->toIso8601String(),
            ]);

        } catch (\Exception $e) {
            Log::error('OTP verification failed', [
                'phone' => $phone,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Verification failed. Please try again.',
            ], 500);
        }
    }

    /**
     * Send WhatsApp message via Twilio API
     */
    protected function sendSms($phone, $otp)
    {
        $accountSid = config('services.twilio.account_sid');
        $authToken = config('services.twilio.auth_token');
        $fromNumber = config('services.twilio.whatsapp_from');
        
        if (!$accountSid || !$authToken || !$fromNumber) {
            throw new \Exception('Twilio credentials not configured');
        }

        // WhatsApp message content with formatting
        $message = "🔐 *NXO Verification*\n\nYour verification code is:\n\n*{$otp}*\n\nThis code will expire in 5 minutes.\n\n_Please do not share this code with anyone._";

        // Using Twilio WhatsApp API
        $response = Http::withBasicAuth($accountSid, $authToken)
            ->asForm()
            ->post("https://api.twilio.com/2010-04-01/Accounts/{$accountSid}/Messages.json", [
                'To' => 'whatsapp:' . $phone,
                'From' => 'whatsapp:' . $fromNumber,
                'Body' => $message,
            ]);

        if (!$response->successful()) {
            Log::error('Twilio WhatsApp API error', [
                'response' => $response->json(),
                'status' => $response->status(),
            ]);
            throw new \Exception('Failed to send WhatsApp message via Twilio');
        }

        return $response->json();
    }

    /**
     * Resend OTP
     */
    public function resendOtp(Request $request)
    {
        return $this->sendOtp($request);
    }

    /**
     * Clean up expired OTPs (run via cron job)
     */
    public function cleanupExpiredOtps()
    {
        $deleted = DB::table('otp_verifications')
            ->where('expires_at', '<', Carbon::now()->subHours(24))
            ->delete();

        Log::info('Cleaned up expired OTPs', ['count' => $deleted]);

        return $deleted;
    }
}

