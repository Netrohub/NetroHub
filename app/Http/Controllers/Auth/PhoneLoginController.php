<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PhoneLoginController extends Controller
{
    /**
     * Show the phone login request form
     */
    public function create()
    {
        return view('auth.phone-login');
    }

    /**
     * Send OTP code to phone number
     */
    public function sendCode(Request $request)
    {
        $request->validate([
            'country_code' => ['required', 'string'],
            'phone' => ['required', 'string'],
            // 'cf-turnstile-response' => ['required'], // Temporarily disabled
        ]);

        // Temporarily disabled Turnstile verification
        /*
        if (! $this->verifyTurnstile($request)) {
            return back()->withErrors([
                'cf-turnstile-response' => 'Security verification failed. Please try again.',
            ]);
        }
        */

        // Combine phone number
        $fullPhone = $request->country_code.$request->phone;

        // Throttle: max 3 attempts per 10 minutes per phone
        $throttleKey = 'phone_otp_'.md5($fullPhone);
        $attempts = Cache::get($throttleKey, 0);

        if ($attempts >= 3) {
            return back()->withErrors([
                'phone' => 'Too many attempts. Please try again in 10 minutes.',
            ]);
        }

        // Generate 6-digit OTP
        $otp = random_int(100000, 999999);

        // Store OTP in cache for 10 minutes
        $otpKey = 'phone_otp_code_'.md5($fullPhone);
        Cache::put($otpKey, $otp, now()->addMinutes(10));

        // Increment attempts
        Cache::put($throttleKey, $attempts + 1, now()->addMinutes(10));

        // TODO: Send OTP via SMS service (Twilio, AWS SNS, etc.)
        // For now, we'll just log it (in production, remove this and use real SMS)
        \Log::info("OTP for {$fullPhone}: {$otp}");

        // Store phone in session for verification step
        session(['phone_verify' => $fullPhone]);

        return redirect()->route('login.phone.verify')
            ->with('success', 'Verification code sent to your phone.');
    }

    /**
     * Show OTP verification form
     */
    public function showVerify()
    {
        if (! session('phone_verify')) {
            return redirect()->route('login.phone');
        }

        return view('auth.phone-verify');
    }

    /**
     * Verify OTP and log in user
     */
    public function verify(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'string', 'size:6'],
        ]);

        $phone = session('phone_verify');

        if (! $phone) {
            return redirect()->route('login.phone')
                ->withErrors(['otp' => 'Session expired. Please request a new code.']);
        }

        // Get stored OTP
        $otpKey = 'phone_otp_code_'.md5($phone);
        $storedOtp = Cache::get($otpKey);

        if (! $storedOtp) {
            return back()->withErrors([
                'otp' => 'Verification code expired. Please request a new one.',
            ]);
        }

        if ($request->otp != $storedOtp) {
            return back()->withErrors([
                'otp' => 'Invalid verification code.',
            ]);
        }

        // Find or create user
        $user = User::where('phone', $phone)->first();

        if (! $user) {
            // Create new user with phone
            $user = User::create([
                'name' => 'User '.substr($phone, -4),
                'email' => 'phone_'.md5($phone).'@placeholder.local', // Temporary email
                'phone' => $phone,
                'phone_verified_at' => now(),
                'password' => bcrypt(Str::random(32)), // Random password
            ]);

            $user->assignRole('user');
        } else {
            // Mark phone as verified
            if (! $user->phone_verified_at) {
                $user->update(['phone_verified_at' => now()]);
            }
        }

        // Clear OTP from cache
        Cache::forget($otpKey);
        session()->forget('phone_verify');

        // Log in user
        Auth::login($user);
        $request->session()->regenerate();

        \App\Models\ActivityLog::log('user_login', $user, 'User logged in via phone');

        return redirect()->intended(route('home'));
    }

    /**
     * Resend OTP code
     */
    public function resend(Request $request)
    {
        $phone = session('phone_verify');

        if (! $phone) {
            return redirect()->route('login.phone');
        }

        // Re-use sendCode logic with throttling
        $request->merge([
            'country_code' => substr($phone, 0, strpos($phone, ' ') ?: 3),
            'phone' => substr($phone, strpos($phone, ' ') + 1),
        ]);

        return $this->sendCode($request);
    }

    /**
     * Verify Turnstile token
     */
    protected function verifyTurnstile(Request $request): bool
    {
        $token = $request->input('cf-turnstile-response');
        $secretKey = env('TURNSTILE_SECRET_KEY');

        if (! $secretKey) {
            return true;
        }

        try {
            $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'secret' => $secretKey,
                'response' => $token,
                'remoteip' => $request->ip(),
            ]);

            $result = $response->json();

            return $result['success'] ?? false;
        } catch (\Exception $e) {
            \Log::error('Turnstile verification error: '.$e->getMessage());

            return true;
        }
    }
}
