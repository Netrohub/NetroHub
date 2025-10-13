@extends('layouts.app')

@section('title', 'Sign In')

@section('content')
<div class="min-h-screen relative overflow-hidden flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <!-- Gaming Background Effects -->
    <div class="absolute inset-0 bg-dark-900">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary-500/20 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-secondary-500/20 rounded-full blur-3xl animate-float animation-delay-2000"></div>
        <div class="absolute top-3/4 left-3/4 w-64 h-64 bg-neon-blue/10 rounded-full blur-3xl animate-float animation-delay-4000"></div>
    </div>

    <div class="relative max-w-md w-full space-y-8">
        <!-- Gaming Header -->
        <div class="text-center animate-fade-in">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gaming-gradient rounded-3xl mb-6 shadow-gaming-lg">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h2 class="text-4xl font-black text-white mb-2 bg-gaming-gradient bg-clip-text text-transparent">
                {{ __('Welcome back!') }}
            </h2>
            <p class="text-muted-300">
                {{ __('Sign in to your account') }}
            </p>
        </div>

        <!-- Gaming Login Form -->
        <x-ui.card variant="glass" class="animate-fade-in animation-delay-200">
            <form class="space-y-5" method="POST" action="{{ route('login') }}" id="login-form">
                @csrf
                
                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-white mb-2">
                        {{ __('Email') }}
                    </label>
                    <x-ui.input 
                        id="email" 
                        name="email" 
                        type="email" 
                        placeholder="Enter your email" 
                        value="{{ old('email') }}"
                        required
                        class="w-full"
                    />
                    @error('email')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-sm font-semibold text-white">
                            {{ __('Password') }}
                        </label>
                        <a href="{{ route('password.request') }}" 
                           class="text-xs text-primary-400 hover:text-primary-300 transition-colors">
                            {{ __('Forgot password?') }}
                        </a>
                    </div>
                    <x-ui.input 
                        id="password" 
                        name="password" 
                        type="password" 
                        placeholder="Enter your password" 
                        required
                        class="w-full"
                    />
                    @error('password')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox"
                           class="h-4 w-4 text-primary-500 focus:ring-primary-500 border-gaming rounded bg-dark-800">
                    <label for="remember" class="ml-2 block text-sm text-muted-300">
                        {{ __('Remember me') }}
                    </label>
                </div>

                <!-- Turnstile Widget -->
                <div>
                    <div class="cf-turnstile" data-sitekey="{{ env('TURNSTILE_SITE_KEY') }}" data-theme="dark"></div>
                    @error('cf-turnstile-response')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sign In Button -->
                <div>
                    <x-ui.button 
                        type="submit" 
                        variant="primary" 
                        size="lg" 
                        glow="true"
                        class="w-full justify-center"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        {{ __('Login') }}
                    </x-ui.button>
                </div>

                <!-- Create Account Link -->
                <div class="text-center">
                    <p class="text-sm text-muted-400">
                        {{ __("Don't have an account?") }} 
                        <a href="{{ route('register') }}" class="text-primary-400 hover:text-primary-300 font-semibold transition-colors">
                            {{ __('Sign up here') }}
                        </a>
                    </p>
                </div>
            </form>

            <!-- Phone Login Button -->
            <div class="mt-4">
                <a href="{{ route('login.phone') }}" 
                   class="inline-flex items-center justify-center w-full px-4 py-3 border border-gaming text-base font-medium rounded-2xl text-white bg-dark-800/50 hover:bg-dark-700/50 hover:border-primary-500 transition-all duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    Sign in with phone number
                </a>
            </div>

            <!-- Divider -->
            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gaming"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-dark-800 text-muted-400 font-medium">or continue with</span>
                    </div>
                </div>
            </div>

            <!-- Social Login Buttons -->
            <div class="mt-6">
                <!-- Google -->
                <a href="{{ route('login.social', 'google') }}" 
                   class="flex items-center justify-center w-full px-4 py-3 border border-gaming text-base font-medium rounded-2xl text-white bg-dark-800/50 hover:bg-dark-700/50 hover:border-red-500 transition-all duration-300">
                    <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    Continue with Google
                </a>
            </div>
        </x-ui.card>
    </div>
</div>

<!-- Turnstile Script -->
<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>

<style>
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

@keyframes fade-in {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

.animate-fade-in {
    animation: fade-in 0.8s ease-out forwards;
}

.animation-delay-200 {
    animation-delay: 0.2s;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}
</style>
@endsection
