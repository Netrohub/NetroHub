<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\TurnstileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request, TurnstileService $ts)
    {
        $request->validate([
            'cf-turnstile-response' => 'required|string',
        ], [
            'cf-turnstile-response.required' => __('Please complete the verification challenge.'),
        ]);

        if (! $ts->verifyToken($request->input('cf-turnstile-response'), $request->ip())) {
            return back()->withErrors(['turnstile' => __('Verification failed. Please try again.')])->withInput();
        }

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
        }

        // Log failed login attempt
        \Log::warning('Login failed', [
            'email' => $request->email,
            'ip' => $request->ip(),
            'reason' => 'Invalid credentials'
        ]);

        // Generic error message without revealing whether email exists
        return back()->withErrors([
            'email' => __('The provided credentials do not match our records.'),
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
