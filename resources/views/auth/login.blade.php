<x-layouts.stellar-auth>
    <x-slot name="title">{{ __('Sign In') }} - {{ config('app.name') }}</x-slot>

    <!-- Page header -->
    <div class="text-center mb-8">
        <!-- Logo -->
        <div class="mb-6">
            <div class="relative flex items-center justify-center w-16 h-16 border border-transparent rounded-2xl shadow-2xl mx-auto [background:linear-gradient(var(--color-slate-900),var(--color-slate-900))_padding-box,conic-gradient(var(--color-slate-400),var(--color-slate-700)_25%,var(--color-slate-700)_75%,var(--color-slate-400)_100%)_border-box] before:absolute before:inset-0 before:bg-slate-800/30 before:rounded-2xl">
                <svg class="w-8 h-8 fill-current text-purple-500" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                    <path d="M31.952 14.751a260.51 260.51 0 00-4.359-4.407C23.932 6.734 20.16 3.182 16.171 0c1.634.017 3.21.28 4.692.751 3.487 3.114 6.846 6.398 10.163 9.737.493 1.346.811 2.776.926 4.262zm-1.388 7.883c-2.496-2.597-5.051-5.12-7.737-7.471-3.706-3.246-10.693-9.81-15.736-7.418-4.552 2.158-4.717 10.543-4.96 16.238A15.926 15.926 0 010 16C0 9.799 3.528 4.421 8.686 1.766c1.82.593 3.593 1.675 5.038 2.587 6.569 4.14 12.29 9.71 17.792 15.57-.237.94-.557 1.846-.952 2.711zm-4.505 5.81a56.161 56.161 0 00-1.007-.823c-2.574-2.054-6.087-4.805-9.394-4.044-3.022.695-4.264 4.267-4.97 7.52a15.945 15.945 0 01-3.665-1.85c.366-3.242.89-6.675 2.405-9.364 2.315-4.107 6.287-3.072 9.613-1.132 3.36 1.96 6.417 4.572 9.313 7.417a16.097 16.097 0 01-2.295 2.275z" />
                </svg>
            </div>
        </div>
        <!-- Page title -->
        <h1 class="text-2xl font-bold text-white mb-2">{{ __('Sign in to your account') }}</h1>
    </div>
    
    <!-- Form -->
    <div class="space-y-6 relative z-20">

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500/50 text-green-300 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-500/10 border border-red-500/50 text-red-300 px-4 py-3 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500/50 text-red-300 px-4 py-3 rounded-lg">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="loginForm" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm text-slate-300 font-medium mb-1" for="email">{{ __('Email') }}</label>
                    <input id="email" name="email" class="form-input w-full" type="email" value="{{ old('email') }}" autocomplete="username" required autofocus />
                    @error('email')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <div class="flex justify-between">
                        <label class="block text-sm text-slate-300 font-medium mb-1" for="password">{{ __('Password') }}</label>
                        @if (Route::has('password.request'))
                            <a class="text-sm font-medium text-purple-500 hover:text-purple-400 transition duration-150 ease-in-out ml-2" href="{{ route('password.request') }}">{{ __('Forgot?') }}</a>
                        @endif
                    </div>
                    <input id="password" name="password" class="form-input w-full" type="password" autocomplete="current-password" required />
                    @error('password')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" class="form-checkbox text-purple-500" {{ old('remember') ? 'checked' : '' }} />
                    <label for="remember" class="text-sm text-slate-300 ml-2">{{ __('Remember me') }}</label>
                </div>

                <!-- Turnstile Token (Hidden) -->
                <input type="hidden" name="cf-turnstile-response" id="ts-response">

                <!-- Cloudflare Turnstile Widget -->
                @if(config('services.turnstile.site_key'))
                <div class="flex justify-center">
                    <div class="cf-turnstile"
                         data-sitekey="{{ config('services.turnstile.site_key') }}"
                         data-callback="onTsSuccess"
                         data-error-callback="onTsError"
                         data-expired-callback="onTsExpired"
                         data-size="normal"
                         data-theme="auto"></div>
                </div>
                @error('cf-turnstile-response')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
                @else
                <div class="text-center text-yellow-400 text-sm">
                    Turnstile not configured (TURNSTILE_SITE_KEY missing)
                </div>
                @endif
            </div>
            <div class="mt-6">
                <button type="submit" id="submit-btn" class="btn text-sm text-white bg-purple-500 hover:bg-purple-600 w-full shadow-xs group">
                    {{ __('Sign In') }} <span class="tracking-normal text-purple-300 group-hover:translate-x-0.5 transition-transform duration-150 ease-in-out ml-1">-&gt;</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Turnstile Scripts -->
    @if(config('services.turnstile.site_key'))
    <script>
        // Turnstile callback functions - minimal, correct implementation
        window.onTsSuccess = function (token) {
            console.log('Turnstile success callback triggered with token:', token ? token.substring(0, 20) + '...' : 'null');
            // Put token in hidden input so it is POSTed with the form
            const tokenInput = document.getElementById('ts-response');
            if (tokenInput) {
                tokenInput.value = token;
                console.log('Token set in hidden input:', tokenInput.value ? tokenInput.value.substring(0, 20) + '...' : 'empty');
            } else {
                console.error('Token input element not found!');
            }
        };
        
        window.onTsError = function (error) {
            console.warn('Turnstile error callback triggered:', error);
            // Clear the token input on error
            const tokenInput = document.getElementById('ts-response');
            if (tokenInput) {
                tokenInput.value = '';
            }
        };
        
        window.onTsExpired = function () {
            console.log('Turnstile expired callback triggered');
            // Reset only on expiration, not on errors
            if (window.turnstile) window.turnstile.reset();
        };

        // Handle SPA/Alpine transitions that hide/show the form
        document.addEventListener('visibilitychange', () => {
            if (document.visibilityState === 'visible' && window.turnstile) {
                window.turnstile.reset();
            }
        });

        // Add form submission handler to check token
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('loginForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const tokenInput = document.getElementById('ts-response');
                    const token = tokenInput ? tokenInput.value : null;
                    
                    console.log('Form submission - Token check:', {
                        tokenPresent: !!token,
                        tokenLength: token ? token.length : 0,
                        tokenPreview: token ? token.substring(0, 20) + '...' : 'null'
                    });
                    
                    if (!token) {
                        console.warn('No Turnstile token found on form submission');
                        // Don't prevent submission - let the server handle validation
                    }
                });
            }
            
            // Add timeout handling for Turnstile
            setTimeout(() => {
                if (typeof window.turnstile === 'undefined') {
                    console.warn('Turnstile failed to load within 10 seconds');
                }
            }, 10000);
        });
    </script>
    
    <!-- Load Turnstile once per page -->
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    @else
    <script>
        console.log('TURNSTILE_SITE_KEY is not set in environment');
    </script>
    @endif

</x-layouts.stellar-auth>
