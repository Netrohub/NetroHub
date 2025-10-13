<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ session('direction', 'ltr') }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - {{ __('Page Not Found') }} | NetroHub</title>
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
            <div class="mx-auto w-20 h-20 sm:w-24 sm:h-24 bg-primary-500/20 rounded-full flex items-center justify-center mb-6 sm:mb-8">
                <svg class="w-10 h-10 sm:w-12 sm:h-12 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

            <!-- Error Message -->
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-black mb-4 text-white">404</h1>
            <h2 class="text-xl sm:text-2xl font-bold mb-4 text-white">{{ __('Page Not Found') }}</h2>
            <p class="text-sm sm:text-base text-muted-300 mb-8 leading-relaxed">
                {{ __("The page you're looking for doesn't exist or has been moved.") }}
            </p>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center">
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-2 px-5 py-3 sm:px-6 sm:py-3 text-sm sm:text-base font-bold bg-gaming-gradient text-white rounded-xl transition-all duration-300 shadow-gaming hover:shadow-gaming-lg min-h-[44px]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    {{ __('Go Home') }}
                </a>
                <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center gap-2 px-5 py-3 sm:px-6 sm:py-3 text-sm sm:text-base font-bold bg-dark-800/70 hover:bg-dark-700/70 text-white rounded-xl transition-all duration-300 shadow-lg hover:shadow-gaming min-h-[44px]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    {{ __('Browse Products') }}
                </a>
            </div>
        </div>
    </div>
</body>
</html>

