<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Services\TurnstileService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(RegisterRequest $request, TurnstileService $ts)
    {
        $request->validate([
            'cf-turnstile-response' => 'required|string',
        ], [
            'cf-turnstile-response.required' => __('Please complete the verification challenge.'),
        ]);

        if (! $ts->verifyToken($request->input('cf-turnstile-response'), $request->ip())) {
            return back()->withErrors(['turnstile' => __('Verification failed. Please try again.')])->withInput();
        }

        try {
            // Generate username if not provided
            $username = $request->username ?? $this->generateUsername($request->name);

            $user = User::create([
                'name' => $request->name,
                'username' => $username,
                'email' => $request->email,
                'phone_number' => $request->country_code . $request->phone,
                'country_code' => $request->country_code,
                'password' => Hash::make($request->password),
                'is_active' => true,
            ]);

            // Assign default user role
            $user->assignRole('user');

            event(new Registered($user)); // triggers immediate verification email

            // Track analytics
            try {
                app(\App\Services\AnalyticsService::class)->trackUserRegistration($user);
            } catch (\Exception $e) {
                \Log::warning('Analytics tracking failed during registration', [
                    'user_id' => $user->id,
                    'error' => $e->getMessage()
                ]);
            }

            \App\Models\ActivityLog::log('user_registered', $user, 'User successfully registered');

            // Redirect to email verification notice instead of auto-login
            return redirect()->route('verification.notice')->with('success', __('Please check your email and click the verification link to complete your registration.'));
        } catch (\Exception $e) {
            \Log::error('Registration failed', [
                'error' => $e->getMessage(),
                'email' => $request->email,
            ]);

            return back()->withErrors([
                'email' => 'Registration failed. Please try again or contact support.'
            ])->withInput($request->except('password'));
        }
    }

    /**
     * Generate a unique username from name
     */
    protected function generateUsername(string $name): string
    {
        $baseUsername = \Illuminate\Support\Str::slug($name, '_');
        $baseUsername = preg_replace('/[^a-zA-Z0-9_]/', '', $baseUsername);
        $baseUsername = substr($baseUsername, 0, 20);

        $username = $baseUsername;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        return $username;
    }
}
