<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="scroll-smooth" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/stellar.css', 'resources/js/stellar.js'])
    
    @stack('styles')
</head>
<body class="font-inter antialiased bg-slate-900 text-slate-100 tracking-tight">
    <div class="relative flex min-h-screen">
        
        <!-- Content -->
        <div class="w-full md:w-1/2 relative z-10">
            <div class="flex flex-col min-h-screen h-full">
                
                <!-- Header -->
                <div class="flex-1">
                    <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                        <a class="block" href="{{ route('home') }}">
                            <svg class="w-8 h-8 fill-current text-purple-500" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                <path d="M31.952 14.751a260.51 260.51 0 00-4.359-4.407C23.932 6.734 20.16 3.182 16.171 0c1.634.017 3.21.28 4.692.751 3.487 3.114 6.846 6.398 10.163 9.737.493 1.346.811 2.776.926 4.262zm-1.388 7.883c-2.496-2.597-5.051-5.12-7.737-7.471-3.706-3.246-10.693-9.81-15.736-7.418-4.552 2.158-4.717 10.543-4.96 16.238A15.926 15.926 0 010 16C0 9.799 3.528 4.421 8.686 1.766c1.82.593 3.593 1.675 5.038 2.587 6.569 4.14 12.29 9.71 17.792 15.57-.237.94-.557 1.846-.952 2.711zm-4.505 5.81a56.161 56.161 0 00-1.007-.823c-2.574-2.054-6.087-4.805-9.394-4.044-3.022.695-4.264 4.267-4.97 7.52a15.945 15.945 0 01-3.665-1.85c.366-3.242.89-6.675 2.405-9.364 2.315-4.107 6.287-3.072 9.613-1.132 3.36 1.96 6.417 4.572 9.313 7.417a16.097 16.097 0 01-2.295 2.275z" />
                            </svg>
                        </a>
                        <div class="text-sm">
                            @if (Route::currentRouteName() === 'login')
                                {{ __("Don't have an account?") }} <a class="font-medium text-purple-500 hover:text-purple-400 transition duration-150 ease-in-out" href="{{ route('register') }}">{{ __('Sign up') }}</a>
                            @else
                                {{ __('Already have an account?') }} <a class="font-medium text-purple-500 hover:text-purple-400 transition duration-150 ease-in-out" href="{{ route('login') }}">{{ __('Sign in') }}</a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="w-full max-w-sm mx-auto px-4 py-8">
                    {{ $slot }}
                </div>

                <!-- Footer -->
                <div class="pt-5 pb-6 border-t border-slate-800">
                    <div class="px-4 sm:px-6 lg:px-8">
                        <div class="text-sm text-center text-slate-500">
                            &copy; {{ config('app.name') }}. {{ __('All rights reserved.') }}
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Right side illustration -->
        <div class="hidden md:block absolute top-0 bottom-0 right-0 md:w-1/2 z-0" aria-hidden="true">
            <img class="object-cover object-center w-full h-full" src="{{ asset('stellar-assets/images/auth-illustration.svg') }}" width="760" height="1024" alt="Authentication" />
            <div class="absolute inset-0 bg-gradient-to-r from-slate-900 to-transparent"></div>
        </div>

    </div>

    @stack('scripts')
</body>
</html>
