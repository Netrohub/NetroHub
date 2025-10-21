<x-layouts.app>
    <x-slot name="title">{{ __('Sign In') }} - {{ config('app.name') }}</x-slot>

    <section class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative">
        <!-- Background Elements -->
        <div class="absolute inset-0">
            <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-primary/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-1/4 right-1/4 w-64 h-64 bg-accent/5 rounded-full blur-3xl"></div>
        </div>
        
        <div class="max-w-md w-full space-y-8 relative z-10">
            <!-- Header -->
            <div class="text-center">
                <div class="flex justify-center mb-6">
                    <div class="relative flex h-16 w-16 items-center justify-center">
                        <div class="absolute inset-0 rounded-2xl gradient-primary blur-md opacity-75"></div>
                        <div class="relative flex h-16 w-16 items-center justify-center rounded-2xl gradient-primary shadow-lg">
                            <svg class="w-8 h-8 text-primary-foreground" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2L2 7L12 12L22 7L12 2Z" fill="currentColor" fill-opacity="0.9"/>
                                <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <h2 class="text-3xl font-bold bg-gradient-to-r from-primary via-accent to-primary bg-clip-text text-transparent">
                    {{ __('Welcome Back') }}
                </h2>
                <p class="mt-2 text-muted-foreground">
                    {{ __('Sign in to your account to continue') }}
                </p>
            </div>

            <!-- Login Form -->
            <div class="glass-card rounded-2xl p-8">
                <form method="POST" action="{{ route('login') }}" class="space-y-6" id="loginForm">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-foreground mb-2">
                            {{ __('Email Address') }}
                        </label>
                        <input id="email" 
                               type="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               autocomplete="email" 
                               autofocus
                               class="w-full px-4 py-3 rounded-lg bg-muted/50 border border-border/50 text-foreground placeholder:text-muted-foreground focus:border-primary/50 focus:bg-muted/70 focus:outline-none transition-all"
                               placeholder="{{ __('Enter your email') }}">
                        @error('email')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-foreground mb-2">
                            {{ __('Password') }}
                        </label>
                        <div class="relative">
                            <input id="password" 
                                   type="password" 
                                   name="password" 
                                   required 
                                   autocomplete="current-password"
                                   class="w-full px-4 py-3 rounded-lg bg-muted/50 border border-border/50 text-foreground placeholder:text-muted-foreground focus:border-primary/50 focus:bg-muted/70 focus:outline-none transition-all"
                                   placeholder="{{ __('Enter your password') }}">
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember" 
                                   name="remember" 
                                   type="checkbox" 
                                   class="h-4 w-4 text-primary focus:ring-primary border-border rounded bg-muted/50">
                            <label for="remember" class="ml-2 block text-sm text-muted-foreground">
                                {{ __('Remember me') }}
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <div class="text-sm">
                                <a href="{{ route('password.request') }}" class="text-primary hover:text-accent transition-colors">
                                    {{ __('Forgot your password?') }}
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Turnstile -->
                    @if(config('services.turnstile.secret_key'))
                        <div class="flex justify-center">
                            <div id="cf-turnstile-container" data-mounted="0"></div>
                            <input type="hidden" name="cf-turnstile-response" id="cf-turnstile-response">
                        </div>
                    @endif

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" 
                                id="submit-btn" 
                                x-data="{busy:false}" 
                                @click="busy=true" 
                                @submit="busy=true" 
                                :disabled="busy"
                                class="group w-full btn-glow px-6 py-3 rounded-lg text-primary-foreground font-semibold text-lg shadow-lg disabled:opacity-50 disabled:cursor-not-allowed">
                            <span x-show="!busy" class="flex items-center justify-center">
                                {{ __('Sign In') }}
                                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </span>
                            <span x-show="busy" class="flex items-center justify-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-primary-foreground" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                {{ __('Signing In...') }}
                            </span>
                        </button>
                    </div>
                </form>

                <!-- Divider -->
                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-border/50"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-card text-muted-foreground">{{ __('Or continue with') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Social Login -->
                <div class="mt-6 grid grid-cols-2 gap-3">
                    <a href="{{ route('phone-login') }}" class="w-full inline-flex justify-center py-3 px-4 border border-border/50 rounded-lg bg-muted/50 text-sm font-medium text-foreground hover:bg-muted/70 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        {{ __('Phone') }}
                    </a>
                    <a href="#" class="w-full inline-flex justify-center py-3 px-4 border border-border/50 rounded-lg bg-muted/50 text-sm font-medium text-foreground hover:bg-muted/70 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                        </svg>
                        {{ __('Twitter') }}
                    </a>
                </div>
            </div>

            <!-- Sign Up Link -->
            <div class="text-center">
                <p class="text-muted-foreground">
                    {{ __('Don\'t have an account?') }}
                    <a href="{{ route('register') }}" class="text-primary hover:text-accent transition-colors font-semibold">
                        {{ __('Sign up here') }}
                    </a>
                </p>
            </div>
        </div>
    </section>

    <!-- Turnstile Script -->
    @if(config('services.turnstile.secret_key'))
        <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
        <script nonce="{{ app('csp_nonce') }}">
        document.addEventListener('DOMContentLoaded', function () {
            if (!window.turnstile || document.getElementById('cf-turnstile-container').dataset.mounted) return;

            document.getElementById('cf-turnstile-container').dataset.mounted = '1';

            const siteKey = @json(config('services.turnstile.site_key'));
            const hidden = document.getElementById('cf-turnstile-response');
            const form = document.getElementById('loginForm');
            const submitBtn = document.getElementById('submit-btn');

            window.turnstile.render('#cf-turnstile-container', {
                sitekey: siteKey,
                callback: function(token) {
                    hidden.value = token;
                    console.log('Turnstile token received');
                },
                'error-callback': function() {
                    hidden.value = '';
                    console.error('Turnstile error');
                },
                'expired-callback': function() {
                    hidden.value = '';
                    try { window.turnstile.reset(); } catch(e){}
                    console.log('Turnstile expired');
                },
                'timeout-callback': function() {
                    hidden.value = '';
                    try { window.turnstile.reset(); } catch(e){}
                    console.log('Turnstile timeout');
                },
            });

            // Reset button state on form errors (optimized)
            form.addEventListener('submit', function() {
                // Use requestIdleCallback for better performance
                if (window.requestIdleCallback) {
                    requestIdleCallback(function() {
                        if (document.querySelector('.text-red-400')) {
                            submitBtn.__x.$data.busy = false;
                        }
                    });
                } else {
                    // Fallback for browsers without requestIdleCallback
                    setTimeout(function() {
                        if (document.querySelector('.text-red-400')) {
                            submitBtn.__x.$data.busy = false;
                        }
                    }, 100);
                }
            });
        });
        </script>
    @endif
</x-layouts.app>
