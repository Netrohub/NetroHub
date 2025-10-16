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

                <!-- Cloudflare Turnstile - Temporarily disabled -->
                {{-- @if(env('TURNSTILE_SITE_KEY'))
                <div class="flex justify-center">
                    <div class="cf-turnstile" data-sitekey="{{ env('TURNSTILE_SITE_KEY') }}" data-theme="dark"></div>
                </div>
                @endif --}}
            </div>
            <div class="mt-6">
                <button type="submit" class="btn text-sm text-white bg-purple-500 hover:bg-purple-600 w-full shadow-xs group">
                    {{ __('Sign Up') }} <span class="tracking-normal text-purple-300 group-hover:translate-x-0.5 transition-transform duration-150 ease-in-out ml-1">-&gt;</span>
                </button>
            </div>
        </form>
    </div>


    {{-- @push('scripts')
    @if(env('TURNSTILE_SITE_KEY'))
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    @endif
    @endpush --}}

</x-layouts.stellar-auth>
