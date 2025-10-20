<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="scroll-smooth" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link rel="dns-prefetch" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/stellar.css', 'resources/js/stellar.js'])
    
    <!-- Emoji Support -->
    <style>
        /* Prefer color emoji fonts globally */
        h1, h2, h3, h4, h5, h6, p {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji", "Apple Color Emoji", Roboto, Helvetica, Arial, sans-serif;
        }

        /* Ensure emojis render in native color even inside gradient text */
        .emoji {
            -webkit-background-clip: initial !important;
            background-clip: initial !important;
            -webkit-text-fill-color: initial !important;
            color: inherit !important;
            font-family: "Segoe UI Emoji", "Apple Color Emoji", "Noto Color Emoji", inherit;
        }

        /* If emoji is inside gradient text, override Tailwind text-transparent */
        .bg-clip-text.text-transparent .emoji {
            color: #e5e7eb !important; /* slate-200 */
            -webkit-text-fill-color: initial !important;
            background: none !important;
        }

        body {
            text-rendering: optimizeLegibility;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
    </style>
    
    @stack('styles')
</head>
<body class="font-sans antialiased bg-slate-900 text-slate-100 tracking-tight">
    <div class="flex flex-col min-h-screen overflow-hidden supports-[overflow:clip]:overflow-clip">
        
        <!-- Header -->
        @include('components.stellar.header')

        <!-- Main Content -->
        <main class="grow">
            {{ $slot }}
        </main>

        <!-- Footer -->
        @include('components.stellar.footer')

    </div>

    @stack('scripts')
</body>
</html>
