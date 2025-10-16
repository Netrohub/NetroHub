<!DOCTYPE html>
<html lang="ar" class="scroll-smooth" dir="rtl">
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
