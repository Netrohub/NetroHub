<x-layouts.stellar-auth>
    <x-slot name="title">{{ __('Sign Up') }} - {{ config('app.name') }}</x-slot>

    <!-- Page header -->
    <div class="text-center mb-8">
        <!-- Logo -->
        <div class="mb-6">
            <div class="relative flex items-center justify-center w-16 h-16 border border-transparent rounded-2xl shadow-2xl mx-auto [background:linear-gradient(var(--color-slate-900),var(--color-slate-900))_padding-box,conic-gradient(var(--color-slate-400),var(--color-slate-700)_25%,var(--color-slate-700)_75%,var(--color-slate-400)_100%)_border-box] before:absolute before:inset-0 before:bg-slate-800/30 before:rounded-2xl">
                <img class="relative" src="{{ asset('stellar-assets/images/logo.svg') }}" width="42" height="42" alt="{{ \App\Models\SiteSetting::get('site_name', 'NetroHub') }}">
            </div>
        </div>
        <!-- Page title -->
        <h1 class="text-2xl font-bold text-white mb-2">{{ __('Create your account') }}</h1>
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

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm text-slate-300 font-medium mb-1" for="name">
                        {{ __('Name') }} <span class="text-red-400">*</span>
                    </label>
                    <input id="name" name="name" class="form-input w-full" type="text" value="{{ old('name') }}" required autofocus />
                    @error('name')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm text-slate-300 font-medium mb-1" for="email">
                        {{ __('Email') }} <span class="text-red-400">*</span>
                    </label>
                    <input id="email" name="email" class="form-input w-full" type="email" value="{{ old('email') }}" required />
                    @error('email')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm text-slate-300 font-medium mb-1" for="phone">
                        {{ __('Phone Number') }} <span class="text-red-400">*</span>
                    </label>
                    <div class="flex gap-2">
                        <select name="country_code" class="form-select w-32" required>
                            <option value="">{{ __('Country') }}</option>
                            <option value="+971" {{ old('country_code') == '+971' ? 'selected' : '' }}>🇦🇪 +971</option>
                            <option value="+966" {{ old('country_code') == '+966' ? 'selected' : '' }}>🇸🇦 +966</option>
                            <option value="+965" {{ old('country_code') == '+965' ? 'selected' : '' }}>🇰🇼 +965</option>
                            <option value="+973" {{ old('country_code') == '+973' ? 'selected' : '' }}>🇧🇭 +973</option>
                            <option value="+974" {{ old('country_code') == '+974' ? 'selected' : '' }}>🇶🇦 +974</option>
                            <option value="+968" {{ old('country_code') == '+968' ? 'selected' : '' }}>🇴🇲 +968</option>
                        </select>
                        <input id="phone" name="phone" class="form-input flex-1" type="tel" value="{{ old('phone') }}" placeholder="123456789" required />
                    </div>
                    @error('phone')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                    @error('country_code')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm text-slate-300 font-medium mb-1" for="password">
                        {{ __('Password') }} <span class="text-red-400">*</span>
                    </label>
                    <input id="password" name="password" class="form-input w-full" type="password" autocomplete="new-password" required />
                    @error('password')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm text-slate-300 font-medium mb-1" for="password_confirmation">
                        {{ __('Confirm Password') }} <span class="text-red-400">*</span>
                    </label>
                    <input id="password_confirmation" name="password_confirmation" class="form-input w-full" type="password" autocomplete="new-password" required />
                </div>

                <!-- Terms and Privacy -->
                <div class="flex items-start">
                    <input id="terms" name="terms" type="checkbox" class="form-checkbox text-purple-500 mt-1" required />
                    <label for="terms" class="text-sm text-slate-300 ml-2">
                        <span class="text-red-400">*</span> {{ __('I agree to the') }} 
                        <a href="{{ route('legal.terms') }}" class="text-purple-500 hover:text-purple-400 transition" target="_blank">{{ __('Terms & Conditions') }}</a>
                        {{ __('and') }}
                        <a href="{{ route('legal.privacy') }}" class="text-purple-500 hover:text-purple-400 transition" target="_blank">{{ __('Privacy Policy') }}</a>
                    </label>
                </div>

                <!-- Cloudflare Turnstile -->
                @if(env('TURNSTILE_SITE_KEY'))
                <div class="flex justify-center">
                    <div id="turnstile-container-register" class="turnstile-container">
                        <!-- Turnstile widget will be rendered here -->
                    </div>
                </div>
                @error('cf-turnstile-response')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
                @endif
            </div>
            <div class="mt-6">
                <button type="submit" class="btn text-sm text-white bg-purple-500 hover:bg-purple-600 w-full shadow-xs group">
                    {{ __('Sign Up') }} <span class="tracking-normal text-purple-300 group-hover:translate-x-0.5 transition-transform duration-150 ease-in-out ml-1">-&gt;</span>
                </button>
            </div>
        </form>
    </div>


    <!-- Turnstile Scripts -->
    @if(env('TURNSTILE_SITE_KEY'))
    <script>
        // Global Turnstile state management for register page
        window.TurnstileManagerRegister = {
            isInitialized: false,
            isRendered: false,
            currentWidgetId: null,
            siteKey: '{{ env('TURNSTILE_SITE_KEY') }}',
            containerId: 'turnstile-container-register',
            retryCount: 0,
            maxRetries: 3,
            debounceTimer: null,
            lastErrorTime: 0,
            
            // Initialize Turnstile widget
            init: function() {
                if (this.isInitialized || this.isRendered) {
                    console.log('Turnstile register already initialized or rendered');
                    return;
                }
                
                console.log('Initializing Turnstile for register...');
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
                    console.log('Turnstile script loaded for register');
                    this.renderWidget();
                };
                script.onerror = () => {
                    console.error('Failed to load Turnstile script for register');
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
                    console.error('Turnstile register container not found');
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
                    console.log('Turnstile register widget rendered with ID:', this.currentWidgetId);
                } catch (error) {
                    console.error('Failed to render Turnstile register widget:', error);
                    this.handleError('300030', 'Widget initialization failed');
                }
            },
            
            // Reset and re-render widget
            reset: function() {
                if (this.currentWidgetId && window.turnstile) {
                    try {
                        window.turnstile.reset(this.currentWidgetId);
                        console.log('Turnstile register widget reset');
                    } catch (error) {
                        console.error('Failed to reset Turnstile register widget:', error);
                        this.reRender();
                    }
                } else {
                    this.reRender();
                }
            },
            
            // Re-render widget from scratch (optimized)
            reRender: function() {
                this.isRendered = false;
                this.currentWidgetId = null;
                this.clearError();
                
                // Use requestAnimationFrame for DOM manipulation
                requestAnimationFrame(() => {
                    const container = document.getElementById(this.containerId);
                    if (container) {
                        container.innerHTML = '';
                    }
                    
                    // Use requestIdleCallback if available, otherwise setTimeout
                    if (window.requestIdleCallback) {
                        requestIdleCallback(() => {
                            this.renderWidget();
                        }, { timeout: 1000 });
                    } else {
                        setTimeout(() => {
                            this.renderWidget();
                        }, 1000);
                    }
                });
            },
            
            // Success callback
            onSuccess: function(token) {
                console.log('Turnstile register verification successful');
                this.clearError();
                this.retryCount = 0;
            },
            
            // Expired callback
            onExpired: function() {
                console.log('Turnstile register verification expired');
                this.showError('Verification expired. Please complete the challenge again.');
                this.reset();
            },
            
            // Timeout callback
            onTimeout: function() {
                console.log('Turnstile register verification timed out');
                this.handleError('300030', 'Verification timed out. Please try again.');
            },
            
            // Error callback (with debouncing)
            onError: function(error) {
                console.log('Turnstile register error:', error);
                
                // Debounce error handling to prevent excessive processing
                const now = Date.now();
                if (now - this.lastErrorTime < 1000) {
                    console.log('Error handling debounced');
                    return;
                }
                this.lastErrorTime = now;
                
                // Clear any existing debounce timer
                if (this.debounceTimer) {
                    clearTimeout(this.debounceTimer);
                }
                
                // Debounce the error handling
                this.debounceTimer = setTimeout(() => {
                    this.handleError(error, this.getErrorMessage(error));
                }, 100);
            },
            
            // Handle errors with retry logic (optimized for performance)
            handleError: function(errorCode, message) {
                if (this.retryCount < this.maxRetries && this.shouldRetry(errorCode)) {
                    this.retryCount++;
                    console.log(`Retrying Turnstile register (attempt ${this.retryCount}/${this.maxRetries})`);
                    this.showError(`${message} Retrying... (${this.retryCount}/${this.maxRetries})`);
                    
                    // Use requestAnimationFrame for better performance
                    requestAnimationFrame(() => {
                        setTimeout(() => {
                            this.reset();
                        }, 2000);
                    });
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
        
        // Optimized initialization with performance considerations
        document.addEventListener('DOMContentLoaded', function() {
            // Use requestAnimationFrame for better performance
            requestAnimationFrame(() => {
                if (window.TurnstileManagerRegister.isVisible()) {
                    window.TurnstileManagerRegister.init();
                } else {
                    // If not visible (e.g., in a modal), wait for visibility
                    const observer = new IntersectionObserver((entries) => {
                        // Use requestAnimationFrame to prevent blocking
                        requestAnimationFrame(() => {
                            entries.forEach(entry => {
                                if (entry.isIntersecting && !window.TurnstileManagerRegister.isRendered) {
                                    window.TurnstileManagerRegister.init();
                                    observer.disconnect();
                                }
                            });
                        });
                    }, {
                        // Optimize observer options
                        rootMargin: '50px',
                        threshold: 0.1
                    });
                    
                    const container = document.getElementById('turnstile-container-register');
                    if (container) {
                        observer.observe(container);
                    }
                }
            });
        });
        
        // Global function for manual initialization (Alpine.js compatibility)
        window.initTurnstileRegister = function() {
            if (window.TurnstileManagerRegister) {
                window.TurnstileManagerRegister.init();
            }
        };
        
        // Global function for resetting (Alpine.js compatibility)
        window.resetTurnstileRegister = function() {
            if (window.TurnstileManagerRegister) {
                window.TurnstileManagerRegister.reset();
            }
        };
    </script>
    @else
    <script>
        console.log('TURNSTILE_SITE_KEY is not set in environment');
    </script>
    @endif

</x-layouts.stellar-auth>
