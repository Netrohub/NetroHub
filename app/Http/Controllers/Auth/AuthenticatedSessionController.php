<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        // Log login attempt for debugging
        \Log::info('Login attempt', [
            'email' => $request->email,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'turnstile_configured' => config('services.turnstile.secret_key') ? 'yes' : 'no',
            'turnstile_token' => $request->input('cf-turnstile-response') ? 'present' : 'missing'
        ]);

        // Check if user exists
        $user = \App\Models\User::where('email', $request->email)->first();
        if ($user) {
            \Log::info('User found', [
                'user_id' => $user->id,
                'email' => $user->email,
                'is_active' => $user->is_active,
                'email_verified_at' => $user->email_verified_at
            ]);
        } else {
            \Log::warning('User not found', [
                'email' => $request->email
            ]);
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            \App\Models\ActivityLog::log('user_login', auth()->user(), 'User logged in');

            // Track analytics
            app(\App\Services\AnalyticsService::class)->trackUserLogin(auth()->user(), 'email');

            \Log::info('Login successful', [
                'user_id' => auth()->id(),
                'email' => $request->email
            ]);

            return redirect()->intended(route('home'));
        } else {
            // Log detailed failure information
            \Log::warning('Login failed - Auth::attempt returned false', [
                'email' => $request->email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'credentials_provided' => [
                    'email' => $request->email,
                    'password_length' => strlen($request->password)
                ]
            ]);
        }

        \Log::warning('Login failed', [
            'email' => $request->email,
            'ip' => $request->ip(),
            'reason' => 'Invalid credentials'
        ]);

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function destroy(Request $request)
    {
        \App\Models\ActivityLog::log('user_logout', auth()->user(), 'User logged out');

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
