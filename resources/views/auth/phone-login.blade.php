<x-layouts.stellar-auth>
    <x-slot name="title">{{ __('Sign In with Phone') }} - {{ config('app.name') }}</x-slot>

<section class="relative">
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
            </div>
            <h2 class="text-4xl font-black text-white mb-2 bg-gaming-gradient bg-clip-text text-transparent">
                Sign In with Phone
            </h2>
            <p class="text-muted-300">
                Enter your phone number to receive a verification code
            </p>
        </div>

        <!-- Phone Login Form -->
        <x-ui.card variant="glass" class="animate-fade-in animation-delay-200">
            <form class="space-y-5" method="POST" action="{{ route('login.phone.send-code') }}">
                @csrf
                
                @if(session('success'))
                    <div class="p-4 bg-green-500/10 border border-green-500/20 rounded-lg">
                        <p class="text-sm text-green-400">{{ session('success') }}</p>
                    </div>
                @endif

                <!-- Phone Number Field -->
                <div>
                    <label for="phone" class="block text-sm font-semibold text-white mb-2">
                        Phone Number
                    </label>
                    <div class="flex gap-2">
                        <!-- Country Code Dropdown -->
                        <select name="country_code" id="country_code" 
                                class="w-32 bg-dark-800 border border-gaming rounded-2xl px-4 py-3 text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
                            <option value="+1">🇺🇸 +1</option>
                            <option value="+44">🇬🇧 +44</option>
                            <option value="+91">🇮🇳 +91</option>
                            <option value="+86">🇨🇳 +86</option>
                            <option value="+81">🇯🇵 +81</option>
                            <option value="+49">🇩🇪 +49</option>
                            <option value="+33">🇫🇷 +33</option>
                            <option value="+61">🇦🇺 +61</option>
                            <option value="+971">🇦🇪 +971</option>
                            <option value="+966">🇸🇦 +966</option>
                            <option value="+20">🇪🇬 +20</option>
                        </select>
                        
                        <!-- Phone Input -->
                        <x-ui.input 
                            id="phone" 
                            name="phone" 
                            type="tel" 
                            placeholder="123-456-7890" 
                            value="{{ old('phone') }}"
                            required
                            class="flex-1"
                        />
                    </div>
                    @error('phone')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                    @error('country_code')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Turnstile Widget -->
                <div>
                    <div class="cf-turnstile" data-sitekey="{{ env('TURNSTILE_SITE_KEY') }}" data-theme="dark"></div>
                    @error('cf-turnstile-response')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Send Code Button -->
                <div>
                    <x-ui.button 
                        type="submit" 
                        variant="primary" 
                        size="lg" 
                        glow="true"
                        class="w-full justify-center"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Send Code
                    </x-ui.button>
                </div>

                <!-- Back to Email Login Link -->
                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-sm text-primary-400 hover:text-primary-300 transition-colors">
                        ← Back to email login
                    </a>
                </div>
            </form>
        </x-ui.card>
    </div>
</div>

<!-- Turnstile Script -->
<script nonce="{{ csp_nonce() }}" src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>

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
@endpush

</section>

</x-layouts.stellar-auth>


