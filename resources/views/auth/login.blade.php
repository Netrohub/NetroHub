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

        <form method="POST" action="{{ route('login') }}">
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

                <!-- Cloudflare Turnstile -->
                @if(env('TURNSTILE_SITE_KEY'))
                <div class="flex justify-center">
                    <div id="turnstile-container" class="turnstile-container">
                        <!-- Turnstile widget will be rendered here -->
                    </div>
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
                <button type="submit" class="btn text-sm text-white bg-purple-500 hover:bg-purple-600 w-full shadow-xs group">
                    {{ __('Sign In') }} <span class="tracking-normal text-purple-300 group-hover:translate-x-0.5 transition-transform duration-150 ease-in-out ml-1">-&gt;</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Turnstile Scripts -->
    @if(env('TURNSTILE_SITE_KEY'))
    <script>
        // Global Turnstile state management
        window.TurnstileManager = {
            isInitialized: false,
            isRendered: false,
            currentWidgetId: null,
            siteKey: '{{ env('TURNSTILE_SITE_KEY') }}',
            containerId: 'turnstile-container',
            retryCount: 0,
            maxRetries: 3,
            
            // Initialize Turnstile widget
            init: function() {
                if (this.isInitialized || this.isRendered) {
                    console.log('Turnstile already initialized or rendered');
                    return;
                }
                
                console.log('Initializing Turnstile...');
                this.isInitialized = true;
                
                // Load Turnstile script if not already loaded
                if (typeof window.turnstile === 'undefined') {
                    this.loadScript();
                } else {
                    this.renderWidget();
                }
            },
            
            // Load Turnstile script
            loadScript: function() {
                const script = document.createElement('script');
                script.src = 'https://challenges.cloudflare.com/turnstile/v0/api.js';
                script.async = true;
                script.defer = true;
                script.onload = () => {
                    console.log('Turnstile script loaded');
                    this.renderWidget();
                };
                script.onerror = () => {
                    console.error('Failed to load Turnstile script');
                    this.showError('Failed to load security widget. Please refresh the page.');
                };
                document.head.appendChild(script);
            },
            
            // Render the widget
            renderWidget: function() {
                if (this.isRendered || typeof window.turnstile === 'undefined') {
                    return;
                }
                
                const container = document.getElementById(this.containerId);
                if (!container) {
                    console.error('Turnstile container not found');
                    return;
                }
                
                try {
                    this.currentWidgetId = window.turnstile.render(container, {
                        sitekey: this.siteKey,
                        theme: 'dark',
                        callback: this.onSuccess.bind(this),
                        'expired-callback': this.onExpired.bind(this),
                        'error-callback': this.onError.bind(this),
                        'timeout-callback': this.onTimeout.bind(this),
                        retry: 'auto',
                        'retry-interval': 8000,
                        'refresh-expired': 'auto'
                    });
                    
                    this.isRendered = true;
                    console.log('Turnstile widget rendered with ID:', this.currentWidgetId);
                } catch (error) {
                    console.error('Failed to render Turnstile widget:', error);
                    this.handleError('300030', 'Widget initialization failed');
                }
            },
            
            // Reset and re-render widget
            reset: function() {
                if (this.currentWidgetId && window.turnstile) {
                    try {
                        window.turnstile.reset(this.currentWidgetId);
                        console.log('Turnstile widget reset');
                    } catch (error) {
                        console.error('Failed to reset Turnstile widget:', error);
                        this.reRender();
                    }
                } else {
                    this.reRender();
                }
            },
            
            // Re-render widget from scratch
            reRender: function() {
                this.isRendered = false;
                this.currentWidgetId = null;
                this.clearError();
                
                const container = document.getElementById(this.containerId);
                if (container) {
                    container.innerHTML = '';
                }
                
                setTimeout(() => {
                    this.renderWidget();
                }, 1000);
            },
            
            // Success callback
            onSuccess: function(token) {
                console.log('Turnstile verification successful');
                this.clearError();
                this.retryCount = 0;
            },
            
            // Expired callback
            onExpired: function() {
                console.log('Turnstile verification expired');
                this.showError('Verification expired. Please complete the challenge again.');
                this.reset();
            },
            
            // Timeout callback
            onTimeout: function() {
                console.log('Turnstile verification timed out');
                this.handleError('300030', 'Verification timed out. Please try again.');
            },
            
            // Error callback
            onError: function(error) {
                console.log('Turnstile error:', error);
                this.handleError(error, this.getErrorMessage(error));
            },
            
            // Handle errors with retry logic
            handleError: function(errorCode, message) {
                if (this.retryCount < this.maxRetries && this.shouldRetry(errorCode)) {
                    this.retryCount++;
                    console.log(`Retrying Turnstile (attempt ${this.retryCount}/${this.maxRetries})`);
                    this.showError(`${message} Retrying... (${this.retryCount}/${this.maxRetries})`);
                    
                    setTimeout(() => {
                        this.reset();
                    }, 2000);
                } else {
                    this.showError(message);
                }
            },
            
            // Determine if error should trigger retry
            shouldRetry: function(errorCode) {
                const retryableErrors = ['300030', '300031', '300034'];
                return retryableErrors.includes(errorCode);
            },
            
            // Get user-friendly error message
            getErrorMessage: function(error) {
                const errorMessages = {
                    '300030': 'Widget hung. Please try again.',
                    '300031': 'Widget crashed. Please try again.',
                    '300032': 'Invalid site key. Please contact support.',
                    '300033': 'Invalid domain. Please contact support.',
                    '300034': 'Widget expired. Please try again.',
                    '300035': 'Widget already rendered. Please refresh the page.'
                };
                
                return errorMessages[error] || `Verification error (${error}). Please try again.`;
            },
            
            // Show error message
            showError: function(message) {
                this.clearError();
                
                const errorDiv = document.createElement('div');
                errorDiv.className = 'turnstile-error mt-2 p-3 bg-red-500/20 border border-red-500/30 rounded-md text-red-400 text-sm';
                errorDiv.textContent = message;
                
                const container = document.getElementById(this.containerId);
                if (container && container.parentNode) {
                    container.parentNode.insertBefore(errorDiv, container.nextSibling);
                }
            },
            
            // Clear error message
            clearError: function() {
                const existingError = document.querySelector('.turnstile-error');
                if (existingError) {
                    existingError.remove();
                }
            },
            
            // Check if widget is visible (for Alpine.js compatibility)
            isVisible: function() {
                const container = document.getElementById(this.containerId);
                if (!container) return false;
                
                const rect = container.getBoundingClientRect();
                return rect.width > 0 && rect.height > 0 && rect.top >= 0 && rect.left >= 0;
            }
        };
        
        // Initialize when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            // Wait a bit to ensure the page is fully loaded
            setTimeout(() => {
                if (window.TurnstileManager.isVisible()) {
                    window.TurnstileManager.init();
                } else {
                    // If not visible (e.g., in a modal), wait for visibility
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting && !window.TurnstileManager.isRendered) {
                                window.TurnstileManager.init();
                                observer.disconnect();
                            }
                        });
                    });
                    
                    const container = document.getElementById('turnstile-container');
                    if (container) {
                        observer.observe(container);
                    }
                }
            }, 100);
        });
        
        // Global function for manual initialization (Alpine.js compatibility)
        window.initTurnstile = function() {
            if (window.TurnstileManager) {
                window.TurnstileManager.init();
            }
        };
        
        // Global function for resetting (Alpine.js compatibility)
        window.resetTurnstile = function() {
            if (window.TurnstileManager) {
                window.TurnstileManager.reset();
            }
        };
    </script>
    @else
    <script>
        console.log('TURNSTILE_SITE_KEY is not set in environment');
    </script>
    @endif

</x-layouts.stellar-auth>
