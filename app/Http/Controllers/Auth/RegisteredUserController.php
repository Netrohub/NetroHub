<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(RegisterRequest $request)
    {
        try {
            // Generate username if not provided
            $username = $request->username ?? $this->generateUsername($request->name);

            $user = User::create([
                'name' => $request->name,
                'username' => $username,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'is_active' => true,
            ]);

            // Assign default user role
            $user->assignRole('user');

            event(new Registered($user));

            Auth::login($user);

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

            return redirect()->route('home')->with('success', 'Welcome to NetroHub! Your account has been created.');
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
