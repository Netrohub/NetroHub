<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    /**
     * Redirect to social provider
     */
    public function redirect(string $provider)
    {
        $this->validateProvider($provider);

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle callback from social provider
     */
    public function callback(string $provider)
    {
        $this->validateProvider($provider);

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->withErrors(['social' => 'Failed to authenticate with '.ucfirst($provider).'. Please try again.']);
        }

        // Find or create user
        $user = User::where('provider', $provider)
            ->where('provider_id', $socialUser->getId())
            ->first();

        if (! $user) {
            // Check if email already exists
            $existingUser = User::where('email', $socialUser->getEmail())->first();

            if ($existingUser) {
                // Link social account to existing user
                $existingUser->update([
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                ]);

                // Mark email as verified if provider says it's verified
                if ($socialUser->user['email_verified'] ?? false) {
                    $existingUser->markEmailAsVerified();
                }

                $user = $existingUser;
            } else {
                // Create new user
                $username = $this->generateUniqueUsername($socialUser->getName() ?? $socialUser->getNickname());

                $user = User::create([
                    'name' => $socialUser->getName() ?? $socialUser->getNickname() ?? 'User',
                    'username' => $username,
                    'email' => $socialUser->getEmail(),
                    'avatar_url' => $socialUser->getAvatar(),
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                    'password' => bcrypt(Str::random(32)), // Random password
                ]);

                // Mark email as verified if provider says it's verified
                if ($socialUser->user['email_verified'] ?? $socialUser->user['verified'] ?? true) {
                    $user->markEmailAsVerified();
                }

                $user->assignRole('user');
            }
        }

        // Log in user
        Auth::login($user);
        request()->session()->regenerate();

        \App\Models\ActivityLog::log('user_login', $user, "User logged in via {$provider}");

        return redirect()->intended(route('home'));
    }

    /**
     * Validate that the provider is supported
     */
    protected function validateProvider(string $provider): void
    {
        $supportedProviders = ['google', 'discord', 'apple'];

        if (! in_array($provider, $supportedProviders)) {
            abort(404);
        }
    }

    /**
     * Generate a unique username from name
     */
    protected function generateUniqueUsername(string $name): string
    {
        $baseUsername = Str::slug($name, '_');
        $baseUsername = preg_replace('/[^a-zA-Z0-9_]/', '', $baseUsername);
        $baseUsername = substr($baseUsername, 0, 20);

        $username = $baseUsername;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $baseUsername.$counter;
            $counter++;
        }

        return $username;
    }
}
