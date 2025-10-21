<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'NXO Marketplace') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')
</head>
<body class="font-sans antialiased bg-background text-foreground tracking-tight">
    <div class="flex flex-col min-h-screen overflow-hidden supports-[overflow:clip]:overflow-clip responsive-layout relative">
        <!-- Animated background -->
        <x-starfield />
        
        <!-- Header -->
        <x-navbar />

        <!-- Main Content -->
        <main class="grow relative z-10">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <x-footer />

    </div>

    @stack('scripts')
</body>
</html>
