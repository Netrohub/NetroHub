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

    public function store(LoginRequest $request)
    {
        // Turnstile validation is already handled in LoginRequest

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        // Log login attempt for debugging (sanitized)
        \Log::info('Login attempt', [
            'email_hash' => hash('sha256', $request->email),
            'ip' => $request->ip(),
            'user_agent_hash' => hash('sha256', $request->userAgent()),
            'turnstile_configured' => config('services.turnstile.secret_key') ? 'yes' : 'no',
            'turnstile_token_present' => $request->input('cf-turnstile-response') ? 'yes' : 'no'
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            \App\Models\ActivityLog::log('user_login', auth()->user(), 'User logged in');

            // Track analytics
            app(\App\Services\AnalyticsService::class)->trackUserLogin(auth()->user(), 'email');

            \Log::info('Login successful', [
                'user_id' => auth()->id(),
                'email_hash' => hash('sha256', $request->email)
            ]);

            return redirect()->intended(route('home'));
        }

        // Log failed login attempt (sanitized)
        \Log::warning('Login failed', [
            'email_hash' => hash('sha256', $request->email),
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
