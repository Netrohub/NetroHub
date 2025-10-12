<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('meta_title', \App\Models\SiteSetting::get('seo_title', config('app.name', 'NetroHub') . ' - Gaming Marketplace'))</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta_description', \App\Models\SiteSetting::get('seo_description', 'Discover and trade digital gaming goods on NetroHub - the ultimate gaming marketplace for gamers, by gamers.'))">
    <meta name="keywords" content="@yield('meta_keywords', \App\Models\SiteSetting::get('seo_keywords', 'gaming, marketplace, digital goods, games, trading, gaming community'))">
    <meta name="author" content="@yield('meta_author', \App\Models\SiteSetting::get('site_name', 'NetroHub'))">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('og_title', config('app.name', 'NetroHub') . ' - Gaming Marketplace')">
    <meta property="og:description" content="@yield('og_description', 'Discover and trade digital gaming goods on NetroHub - the ultimate gaming marketplace for gamers, by gamers.')">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:image" content="@yield('og_image', asset('img/netrohub-og.png'))">
    <meta property="og:site_name" content="{{ config('app.name', 'NetroHub') }}">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="@yield('twitter_card', 'summary_large_image')">
    <meta name="twitter:title" content="@yield('twitter_title', config('app.name', 'NetroHub') . ' - Gaming Marketplace')">
    <meta name="twitter:description" content="@yield('twitter_description', 'Discover and trade digital gaming goods on NetroHub - the ultimate gaming marketplace for gamers, by gamers.')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('img/netrohub-og.png'))">
    
    <!-- Additional SEO -->
    <link rel="canonical" href="{{ request()->url() }}">
    <meta name="robots" content="@yield('robots', 'index, follow')">
    
    <!-- Google Analytics (GA4) - Production Only -->
    @if(config('services.google_analytics.enabled') && config('services.google_analytics.measurement_id') && app()->environment('production'))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.google_analytics.measurement_id') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ config('services.google_analytics.measurement_id') }}', {
            'user_id': '{{ auth()->id() }}',
            'send_page_view': true
        });
    </script>
    @endif
    
    <!-- PostHog -->
    @if(config('services.posthog.api_key'))
    <script>
        !function(t,e){var o,n,p,r;e.__SV||(window.posthog=e,e._i=[],e.init=function(i,s,a){function g(t,e){var o=e.split(".");2==o.length&&(t=t[o[0]],e=o[1]);t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}}(p=t.createElement("script")).type="text/javascript",p.async=!0,p.src=s.api_host+"/static/array.js",(r=t.getElementsByTagName("script")[0]).parentNode.insertBefore(p,r);var u=e;for(void 0!==a?u=e[a]=[]:a="posthog",u.people=u.people||[],u.toString=function(t){var e="posthog";return"posthog"!==a&&(e+="."+a),t||(e+=" (stub)"),e},u.people.toString=function(){return u.toString(1)+".people (stub)"},o="capture identify alias people.set people.set_once set_config register register_once unregister opt_out_capturing has_opted_out_capturing opt_in_capturing reset isFeatureEnabled onFeatureFlags getFeatureFlag getFeatureFlagPayload reloadFeatureFlags group updateEarlyAccessFeatureEnrollment getEarlyAccessFeatures getActiveMatchingSurveys getSurveys".split(" "),n=0;n<o.length;n++)g(u,o[n]);e._i.push([i,s,a])},e.__SV=1)}(document,window.posthog||[]);
        posthog.init('{{ config('services.posthog.api_key') }}', {
            api_host: '{{ config('services.posthog.host') }}',
            loaded: function(posthog) {
                @auth
                posthog.identify('{{ auth()->id() }}', {
                    email: '{{ auth()->user()->email }}',
                    name: '{{ auth()->user()->name }}',
                });
                @endauth
            }
        });
    </script>
    @endif

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&family=poppins:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    @stack('styles')
</head>
<body class="bg-dark-900 text-white font-sans antialiased">
    <!-- Impersonation Warning Banner -->
    @if(session('impersonator_id'))
        <div class="bg-red-600 text-white text-center py-2 px-4 relative z-50">
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                    <span class="font-semibold">You are impersonating {{ auth()->user()->name }}</span>
                </div>
                <a href="{{ route('impersonate.stop') }}" class="bg-red-700 hover:bg-red-800 px-4 py-1 rounded text-sm font-medium transition-colors">
                    Stop Impersonating
                </a>
            </div>
        </div>
    @endif

    <!-- Gaming Background Effects -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-primary-500/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-secondary-500/10 rounded-full blur-3xl animate-float animation-delay-2000"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-neon-blue/5 rounded-full blur-2xl animate-pulse-slow"></div>
    </div>
    <!-- Gaming Navigation -->
    <nav class="bg-black/40 backdrop-blur-xl border-b border-gaming sticky top-0 z-50 shadow-2xl transition-transform duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 md:h-18">
                <!-- Logo -->
                <div class="flex items-center flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                        <div class="relative w-10 h-10 md:w-12 md:h-12 bg-gaming-gradient rounded-xl flex items-center justify-center shadow-gaming group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            <div class="absolute inset-0 bg-gaming-gradient rounded-xl opacity-50 blur-lg group-hover:opacity-100 transition-opacity"></div>
                            <svg class="relative w-6 h-6 md:w-7 md:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <span class="text-xl md:text-2xl font-black bg-gaming-gradient bg-clip-text text-transparent tracking-tight">
                            {{ \App\Models\SiteSetting::get('site_name', 'NetroHub') }}
                        </span>
                    </a>
                </div>
                
                <!-- Center Navigation -->
                <div class="hidden md:flex items-center justify-center flex-1">
                    @php($nav=[
                        ['label'=>'Home','route'=>route('home')],
                        ['label'=>'Social','route'=>'/social'],
                        ['label'=>'Games','route'=>'/games'],
                        ['label'=>'Members','route'=>'/members'],
                        ['label'=>'Leaderboard','route'=>'/leaderboard'],
                        ['label'=>'Platform Store','route'=>route('pricing.index')],
                    ])
                    <div class="flex items-center gap-1">
                        @foreach($nav as $link)
                            @php($active = url()->current() === $link['route'])
                            <a href="{{ $link['route'] }}" 
                               class="relative px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-300 
                                      {{ $active ? 'text-white' : 'text-muted-300 hover:text-white' }} 
                                      group">
                                {{ $link['label'] }}
                                @if($active)
                                    <span class="absolute inset-0 bg-dark-800/70 rounded-xl -z-10 shadow-gaming"></span>
                                    <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-1/2 h-0.5 bg-gaming-gradient rounded-full"></span>
                                @else
                                    <span class="absolute inset-0 bg-dark-800/40 rounded-xl -z-10 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                                    <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-0 h-0.5 bg-gaming-gradient rounded-full group-hover:w-1/2 transition-all duration-300"></span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Right Section -->
                <div class="hidden md:flex items-center gap-3">
                    <!-- Start Selling Button -->
                    <a href="{{ route('sell.index') }}" class="btn-primary btn-sm group">
                        <svg class="w-4 h-4 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Start Selling
                    </a>
                    
                    <!-- Cart -->
                    <a href="{{ route('cart.index') }}" class="relative text-muted-300 hover:text-white transition-all duration-300 group">
                        <div class="p-2.5 rounded-xl hover:bg-dark-800/70 hover:shadow-glow transition-all duration-300">
                            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        @if(session()->has('cart') && count(session('cart')) > 0)
                            <span class="absolute -top-1 -right-1 bg-gaming-gradient text-white text-xs rounded-full h-5 min-w-[20px] px-1 flex items-center justify-center font-bold shadow-gaming animate-pulse">{{ count(session('cart')) }}</span>
                        @endif
                    </a>

                    <!-- Language toggle -->
                    @auth
                    <form method="POST" action="{{ route('locale.toggle') }}">
                        @csrf
                        <button class="px-3 py-2 rounded-xl text-sm font-medium text-muted-300 hover:text-white hover:bg-dark-800/50">{{ session('locale','en')==='ar' ? '🇺🇸' : '🇸🇦' }}</button>
                    </form>
                    @endauth

                    <!-- Wallet balance -->
                    @auth
                        @php($balance = auth()->user()->seller?->getWalletBalance() ?? 0)
                        <div class="group relative px-4 py-2.5 rounded-xl text-sm font-bold text-white bg-dark-800/70 border border-gaming hover:border-primary-500/50 hover:shadow-glow transition-all duration-300">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-neon-green" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-gradient-success">${{ number_format($balance,2) }}</span>
                            </div>
                        </div>
                    @endauth

                    @auth
                        <!-- User Dropdown (existing) -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-2 px-2 py-2 rounded-xl text-muted-300 hover:text-white hover:bg-dark-800/50 transition-all duration-300 group">
                                <div class="w-9 h-9 rounded-xl bg-gaming-gradient p-0.5 shadow-gaming group-hover:scale-110 transition-transform">
                                    <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="w-full h-full rounded-lg object-cover">
                                </div>
                                <svg class="w-4 h-4 group-hover:rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div x-show="open" @click.away="open = false" x-cloak
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 mt-3 w-64 bg-dark-800/95 backdrop-blur-xl border border-gaming rounded-2xl shadow-gaming-xl py-2 z-50 overflow-hidden">
                                <div class="px-4 py-3 border-b border-gaming">
                                    <p class="text-sm font-medium text-white">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-muted-400">{{ auth()->user()->email }}</p>
                                </div>
                                <!-- My Account dropdown items -->
                                <a href="{{ route('account.index') }}" class="flex items-center px-4 py-3 text-sm text-white/90 hover:text-white hover:bg-dark-700/50 transition-all duration-200">🏠 My Account</a>
                                <a href="{{ route('account.orders') }}" class="flex items-center px-4 py-3 text-sm text-muted-300 hover:text-white hover:bg-dark-700/50 transition-all duration-200">📦 Orders</a>
                                <a href="{{ route('account.sales') }}" class="flex items-center px-4 py-3 text-sm text-muted-300 hover:text-white hover:bg-dark-700/50 transition-all duration-200">💸 Sales</a>
                                <a href="{{ route('account.wallet') }}" class="flex items-center px-4 py-3 text-sm text-muted-300 hover:text-white hover:bg-dark-700/50 transition-all duration-200">👛 Wallet</a>
                                <a href="{{ route('account.payouts') }}" class="flex items-center px-4 py-3 text-sm text-muted-300 hover:text-white hover:bg-dark-700/50 transition-all duration-200">🏧 Payouts / Cashbox</a>
                                <a href="{{ route('account.promote') }}" class="flex items-center px-4 py-3 text-sm text-muted-300 hover:text-white hover:bg-dark-700/50 transition-all duration-200">📣 Promote Product</a>
                                <a href="{{ route('account.notifications') }}" class="relative flex items-center px-4 py-3 text-sm text-muted-300 hover:text-white hover:bg-dark-700/50 transition-all duration-200">
                                    🔔 Notifications
                                    @php(
                                        $unread = \Illuminate\Support\Facades\Schema::hasTable('notifications') && method_exists(auth()->user(), 'unreadNotifications')
                                            ? auth()->user()->unreadNotifications()->count()
                                            : 0
                                    )
                                    @if($unread > 0)
                                        <span class="ml-2 inline-flex items-center justify-center text-xs bg-red-600 text-white rounded-full h-5 min-w-[20px] px-1">{{ $unread }}</span>
                                    @endif
                                </a>
                                <a href="{{ route('account.blocked') }}" class="flex items-center px-4 py-3 text-sm text-muted-300 hover:text-white hover:bg-dark-700/50 transition-all duration-200">🚫 Blocked List</a>
                                <a href="{{ route('account.fees') }}" class="flex items-center px-4 py-3 text-sm text-muted-300 hover:text-white hover:bg-dark-700/50 transition-all duration-200">🧮 Fees Calculator</a>
                                
                                <!-- Verification Section -->
                                <div class="border-t border-gaming my-2"></div>
                                <div class="px-4 py-2">
                                    <p class="text-xs font-medium text-muted-400 uppercase tracking-wider">Verification</p>
                                </div>
                                
                                <!-- KYC Verification -->
                                <a href="{{ route('account.kyc.show') }}" class="flex items-center justify-between px-4 py-3 text-sm text-muted-300 hover:text-white hover:bg-dark-700/50 transition-all duration-200">
                                    <span class="flex items-center">
                                        🔐 Identity Verification
                                        @if(!auth()->user()->isVerified())
                                            <span class="ml-2 inline-flex items-center justify-center text-xs bg-red-600 text-white rounded-full h-4 w-4">!</span>
                                        @endif
                                    </span>
                                    {!! auth()->user()->getVerificationStatusBadge() !!}
                                </a>
                                
                                <!-- Phone Verification -->
                                <a href="{{ route('account.phone.show') }}" class="flex items-center justify-between px-4 py-3 text-sm text-muted-300 hover:text-white hover:bg-dark-700/50 transition-all duration-200">
                                    <span>📱 Phone Verification</span>
                                    {!! auth()->user()->getPhoneVerificationStatusBadge() !!}
                                </a>
                                <form method="POST" action="{{ route('account.privacy.toggle') }}" class="px-4 py-2">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center justify-between text-sm text-muted-300 hover:text-white hover:bg-dark-700/50 transition-all duration-200 px-0 py-1">
                                        <span>🕶️ Privacy Mode</span>
                                        <span class="ml-3 inline-flex items-center h-6">
                                            <span class="relative inline-flex items-center w-10 h-6 bg-dark-700 rounded-full border border-gaming">
                                                <span class="absolute left-0.5 top-0.5 inline-block w-5 h-5 rounded-full bg-white transition-transform duration-200 {{ auth()->user()->privacy_mode ? 'translate-x-4 bg-primary-400' : '' }}"></span>
                                            </span>
                                        </span>
                                    </button>
                                </form>
                                <a href="{{ route('account.challenges') }}" class="flex items-center px-4 py-3 text-sm text-muted-300 hover:text-white hover:bg-dark-700/50 transition-all duration-200">🏆 Challenges</a>
                                <div class="border-t border-gaming mt-2 pt-2">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex items-center w-full px-4 py-3 text-sm text-red-400 hover:text-red-300 hover:bg-red-900/20 transition-all duration-200">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            🚪 Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-muted-300 hover:text-white px-4 py-2 rounded-xl text-sm font-medium transition-all duration-300 hover:bg-dark-800/50">
                            🔐 Login
                        </a>
                        <a href="{{ route('register') }}" class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-xl text-sm font-bold transition-all duration-300 shadow-lg hover:shadow-gaming">
                            ⚡ Register
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-muted-300 hover:text-white p-2 rounded-xl hover:bg-dark-800/50 transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

        <!-- Announcements -->
        @include('components.announcements')
        
        <!-- Verification Banner -->
        @include('components.verification-banner')

    <!-- Page Content -->
    <main class="relative z-10">
        <!-- Gaming Flash Messages -->
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                <x-ui.alert type="success" class="animate-slide-up">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">Success!</span>
                    </div>
                    <p class="mt-1">{{ session('success') }}</p>
                </x-ui.alert>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                <x-ui.alert type="error" class="animate-slide-up">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">Error!</span>
                    </div>
                    <p class="mt-1">{{ session('error') }}</p>
                </x-ui.alert>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Gaming Footer -->
    <footer class="relative mt-16 bg-gaming-gradient-dark border-t border-gaming">
        <div class="absolute inset-0 bg-gradient-to-r from-dark-900 via-dark-800 to-dark-900 opacity-90"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Brand -->
                <div class="md:col-span-1">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-gaming-gradient rounded-xl flex items-center justify-center shadow-gaming">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <span class="text-2xl font-black bg-gaming-gradient bg-clip-text text-transparent">
                            {{ \App\Models\SiteSetting::get('site_name', 'NetroHub') }}
                        </span>
                    </div>
                    <p class="text-muted-400 text-sm leading-relaxed">
                        {{ \App\Models\SiteSetting::get('site_description', 'The ultimate gaming marketplace for digital assets. Trade, sell, and discover the best gaming products.') }}
                    </p>
                    <div class="flex space-x-4 mt-6">
                        @if(\App\Models\SiteSetting::get('twitter_handle'))
                            <a href="https://twitter.com/{{ ltrim(\App\Models\SiteSetting::get('twitter_handle'), '@') }}" target="_blank" class="w-8 h-8 bg-dark-800/50 rounded-lg flex items-center justify-center text-muted-400 hover:text-white hover:bg-primary-500 transition-all duration-300">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                </svg>
                            </a>
                        @endif
                        @if(\App\Models\SiteSetting::get('facebook_url'))
                            <a href="{{ \App\Models\SiteSetting::get('facebook_url') }}" target="_blank" class="w-8 h-8 bg-dark-800/50 rounded-lg flex items-center justify-center text-muted-400 hover:text-white hover:bg-primary-500 transition-all duration-300">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                                </svg>
                            </a>
                        @endif
                        @if(\App\Models\SiteSetting::get('instagram_url'))
                            <a href="{{ \App\Models\SiteSetting::get('instagram_url') }}" target="_blank" class="w-8 h-8 bg-dark-800/50 rounded-lg flex items-center justify-center text-muted-400 hover:text-white hover:bg-primary-500 transition-all duration-300">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </a>
                        @endif
                        @if(\App\Models\SiteSetting::get('discord_url'))
                            <a href="{{ \App\Models\SiteSetting::get('discord_url') }}" target="_blank" class="w-8 h-8 bg-dark-800/50 rounded-lg flex items-center justify-center text-muted-400 hover:text-white hover:bg-primary-500 transition-all duration-300">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515.074.074 0 0 0-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 0 0-5.487 0 12.64 12.64 0 0 0-.617-1.25.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37a.07.07 0 0 0-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 0 0 .031.057 19.9 19.9 0 0 0 5.993 3.03.078.078 0 0 0 .084-.028 14.09 14.09 0 0 0 1.226-1.994.076.076 0 0 0-.041-.106 13.107 13.107 0 0 1-1.872-.892.077.077 0 0 1-.008-.128 10.2 10.2 0 0 0 .372-.292.074.074 0 0 1 .077-.01c3.928 1.793 8.18 1.793 12.062 0a.074.074 0 0 1 .078.01c.12.098.246.198.373.292a.077.077 0 0 1-.006.127 12.299 12.299 0 0 1-1.873.892.077.077 0 0 0-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 0 0 .084.028 19.839 19.839 0 0 0 6.002-3.03.077.077 0 0 0 .032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 0 0-.031-.03zM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.956-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.956 2.418-2.157 2.418zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.955-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.946 2.418-2.157 2.418z"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Marketplace -->
                <div>
                    <h4 class="font-bold text-white mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        🎮 Marketplace
                    </h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="{{ route('products.index') }}" class="text-muted-400 hover:text-white transition-colors duration-200 flex items-center group">
                            <svg class="w-4 h-4 mr-2 text-primary-500 group-hover:text-primary-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Browse Products
                        </a></li>
                        <li><a href="{{ route('sell.index') }}" class="text-muted-400 hover:text-white transition-colors duration-200 flex items-center group">
                            <svg class="w-4 h-4 mr-2 text-secondary-500 group-hover:text-secondary-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Start Selling
                        </a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h4 class="font-bold text-white mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        🛠️ Support
                    </h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="text-muted-400 hover:text-white transition-colors duration-200">Help Center</a></li>
                        <li><a href="#" class="text-muted-400 hover:text-white transition-colors duration-200">Contact Us</a></li>
                        <li><a href="#" class="text-muted-400 hover:text-white transition-colors duration-200">Discord Community</a></li>
                    </ul>
                </div>

                <!-- Legal -->
                <div>
                    <h4 class="font-bold text-white mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        ⚖️ Legal
                    </h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="{{ route('terms') }}" class="text-muted-400 hover:text-white transition-colors duration-200">Terms & Conditions</a></li>
                        <li><a href="{{ route('privacy') }}" class="text-muted-400 hover:text-white transition-colors duration-200">Privacy Policy</a></li>
                        <li><a href="#" class="text-muted-400 hover:text-white transition-colors duration-200">Refund Policy</a></li>
                    </ul>
                </div>
            </div>
            
            <!-- Bottom Bar -->
            <div class="border-t border-gaming mt-12 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-muted-400 text-sm text-center md:text-left">
                        &copy; {{ date('Y') }} {{ \App\Models\SiteSetting::get('company_name', \App\Models\SiteSetting::get('site_name', 'NetroHub')) }}. All rights reserved.
                    </p>
                    <div class="flex flex-wrap items-center justify-center gap-4 md:gap-6">
                        <span class="text-xs text-muted-500 flex items-center gap-1">
                            <svg class="w-4 h-4 text-neon-green" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                            </svg>
                            Secure Payments
                        </span>
                        <span class="text-xs text-muted-500 flex items-center gap-1">
                            <svg class="w-4 h-4 text-primary-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                            </svg>
                            Instant Delivery
                        </span>
                        <span class="text-xs text-muted-500 flex items-center gap-1">
                            <svg class="w-4 h-4 text-secondary-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            24/7 Support
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
