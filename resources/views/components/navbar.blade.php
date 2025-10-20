<!-- NXO Navbar Component - Exact Design Specifications -->
<nav class="sticky top-0 z-50 w-full border-b border-border/50 glass-card">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex h-16 items-center justify-between">
            <!-- Logo Section -->
            <div class="flex items-center gap-8">
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="relative flex h-[42px] w-[42px] items-center justify-center">
                        <div class="absolute inset-0 rounded-full gradient-primary blur-md opacity-75 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative flex h-[42px] w-[42px] items-center justify-center rounded-full gradient-primary shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-primary-foreground" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2L2 7L12 12L22 7L12 2Z" fill="currentColor" fill-opacity="0.9"/>
                                <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>
                    <span class="text-xl font-bold text-gradient tracking-tight">
                        NXO
                    </span>
                </a>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center gap-6">
                    <a href="{{ route('home') }}" class="text-sm font-medium text-foreground/70 hover:text-primary transition-colors relative group {{ request()->routeIs('home') ? 'text-primary' : '' }}">
                        {{ __('Home') }}
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 gradient-primary group-hover:w-full transition-all duration-300 {{ request()->routeIs('home') ? 'w-full' : '' }}"></span>
                    </a>
                    <a href="{{ route('products.index') }}" class="text-sm font-medium text-foreground/70 hover:text-primary transition-colors relative group {{ request()->routeIs('products.*') ? 'text-primary' : '' }}">
                        {{ __('Products') }}
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 gradient-primary group-hover:w-full transition-all duration-300 {{ request()->routeIs('products.*') ? 'w-full' : '' }}"></span>
                    </a>
                    <a href="{{ route('games') }}" class="text-sm font-medium text-foreground/70 hover:text-primary transition-colors relative group {{ request()->routeIs('games') ? 'text-primary' : '' }}">
                        {{ __('Games') }}
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 gradient-primary group-hover:w-full transition-all duration-300 {{ request()->routeIs('games') ? 'w-full' : '' }}"></span>
                    </a>
                    <a href="{{ route('leaderboard') }}" class="text-sm font-medium text-foreground/70 hover:text-primary transition-colors relative group {{ request()->routeIs('leaderboard') ? 'text-primary' : '' }}">
                        {{ __('Leaderboard') }}
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 gradient-primary group-hover:w-full transition-all duration-300 {{ request()->routeIs('leaderboard') ? 'w-full' : '' }}"></span>
                    </a>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="hidden lg:flex flex-1 max-w-md mx-8">
                <div class="relative w-full">
                    <svg class="absolute left-3 top-1/2 h-6 w-6 -translate-y-1/2 icon-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input 
                        type="search" 
                        placeholder="{{ __('Search game accounts, social accounts...') }}" 
                        class="w-full pl-10 form-input"
                    />
                </div>
            </div>

            <!-- Right Side Actions -->
            <div class="flex items-center gap-2">
                <!-- User Account -->
                @auth
                    <a href="{{ route('account.index') }}" class="hidden md:flex items-center justify-center h-9 w-9 rounded-md hover:bg-primary/10 transition-colors">
                        <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="hidden md:flex items-center justify-center h-9 w-9 rounded-md hover:bg-primary/10 transition-colors">
                        <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </a>
                @endauth

                <!-- Cart -->
                <a href="{{ route('cart.index') }}" class="relative flex items-center justify-center h-9 w-9 rounded-md hover:bg-primary/10 transition-colors">
                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    @if(auth()->check() && session('cart', []) !== [])
                        <span class="absolute -right-1 -top-1 flex h-5 w-5 items-center justify-center rounded-full gradient-primary text-[10px] font-bold text-primary-foreground shadow-lg">
                            {{ count(session('cart', [])) }}
                        </span>
                    @endif
                </a>

                <!-- Mobile Menu Button -->
                <button type="button" class="md:hidden flex items-center justify-center h-9 w-9 rounded-md hover:bg-primary/10 transition-colors" x-data="{ open: false }" @click="open = !open">
                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="md:hidden" x-data="{ open: false }" x-show="open" x-transition>
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 glass-card rounded-lg mt-2">
                <a href="{{ route('home') }}" class="block px-3 py-2 text-base font-medium text-foreground hover:text-primary transition-colors">
                    {{ __('Home') }}
                </a>
                <a href="{{ route('products.index') }}" class="block px-3 py-2 text-base font-medium text-foreground hover:text-primary transition-colors">
                    {{ __('Products') }}
                </a>
                <a href="{{ route('games') }}" class="block px-3 py-2 text-base font-medium text-foreground hover:text-primary transition-colors">
                    {{ __('Games') }}
                </a>
                <a href="{{ route('leaderboard') }}" class="block px-3 py-2 text-base font-medium text-foreground hover:text-primary transition-colors">
                    {{ __('Leaderboard') }}
                </a>
            </div>
        </div>
    </div>
</nav>
