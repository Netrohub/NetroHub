<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ session('direction', 'ltr') }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 - {{ __('Access Denied') }} | NXO</title>
    @vite(['resources/css/app.css'])
    <link rel="preconnect" href="https://fonts.bunny.net">
    @if(app()->getLocale() === 'ar')
    <link href="https://fonts.bunny.net/css?family=tajawal:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    @else
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    @endif
</head>
<body class="bg-dark-900 text-white font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full text-center">
            <!-- Error Icon -->
            <div class="mx-auto w-20 h-20 sm:w-24 sm:h-24 bg-red-500/20 rounded-full flex items-center justify-center mb-6 sm:mb-8">
                <svg class="w-10 h-10 sm:w-12 sm:h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>

            <!-- Error Message -->
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-black mb-4 text-white">403</h1>
            <h2 class="text-xl sm:text-2xl font-bold mb-4 text-white">{{ __('Access Denied') }}</h2>
            <p class="text-sm sm:text-base text-muted-300 mb-8 leading-relaxed">
                {{ $message ?? __('You do not have permission to access this resource.') }}
            </p>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center">
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-2 px-5 py-3 sm:px-6 sm:py-3 text-sm sm:text-base font-bold bg-gaming-gradient text-white rounded-xl transition-all duration-300 shadow-gaming hover:shadow-gaming-lg min-h-[44px]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    {{ __('Go Home') }}
                </a>
                <a href="javascript:history.back()" class="inline-flex items-center justify-center gap-2 px-5 py-3 sm:px-6 sm:py-3 text-sm sm:text-base font-bold bg-dark-800/70 hover:bg-dark-700/70 text-white rounded-xl transition-all duration-300 shadow-lg hover:shadow-gaming min-h-[44px]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    {{ __('Go Back') }}
                </a>
            </div>
        </div>
    </div>
</body>
</html>

