<!-- Stellar Navbar Component -->
<nav class="sticky top-0 z-50 w-full border-b border-border/50 glass-card">
    <div class="container mx-auto px-4">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center gap-8">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="relative flex h-10 w-10 items-center justify-center">
                        <div class="absolute inset-0 rounded-lg gradient-primary blur-md opacity-75 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative flex h-10 w-10 items-center justify-center rounded-lg gradient-primary shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-primary-foreground" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2L2 7L12 12L22 7L12 2Z" fill="currentColor" fill-opacity="0.9"/>
                                <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>
                    <span class="text-xl font-bold bg-gradient-to-r from-primary via-accent to-primary bg-clip-text text-transparent tracking-tight">
                        Nexo
                    </span>
                </a>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center gap-6">
                    <a href="{{ route('home') }}" class="text-sm font-medium text-foreground/70 hover:text-primary transition-colors relative group {{ request()->routeIs('home') ? 'text-primary' : '' }}">
                        {{ __('Home') }}
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-primary group-hover:w-full transition-all duration-300 {{ request()->routeIs('home') ? 'w-full' : '' }}"></span>
                    </a>
                    <a href="{{ route('products.index') }}" class="text-sm font-medium text-foreground/70 hover:text-primary transition-colors relative group {{ request()->routeIs('products.*') ? 'text-primary' : '' }}">
                        {{ __('Products') }}
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-primary group-hover:w-full transition-all duration-300 {{ request()->routeIs('products.*') ? 'w-full' : '' }}"></span>
                    </a>
                    <a href="{{ route('games') }}" class="text-sm font-medium text-foreground/70 hover:text-primary transition-colors relative group {{ request()->routeIs('games') ? 'text-primary' : '' }}">
                        {{ __('Games') }}
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-primary group-hover:w-full transition-all duration-300 {{ request()->routeIs('games') ? 'w-full' : '' }}"></span>
                    </a>
                    <a href="{{ route('leaderboard') }}" class="text-sm font-medium text-foreground/70 hover:text-primary transition-colors relative group {{ request()->routeIs('leaderboard') ? 'text-primary' : '' }}">
                        {{ __('Leaderboard') }}
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-primary group-hover:w-full transition-all duration-300 {{ request()->routeIs('leaderboard') ? 'w-full' : '' }}"></span>
                    </a>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="hidden lg:flex flex-1 max-w-md mx-8">
                <div class="relative w-full">
                    <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-primary/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="search" placeholder="{{ __('Search game accounts, social accounts...') }}" 
                           class="w-full pl-10 pr-4 py-2 bg-muted/50 border border-border/50 rounded-lg focus:border-primary/50 focus:bg-muted/70 focus:outline-none transition-all text-foreground placeholder:text-muted-foreground">
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2">
                <!-- Language Switcher -->
                <div class="relative">
                    <select class="bg-transparent text-sm text-foreground/70 hover:text-primary transition-colors border-none outline-none cursor-pointer">
                        <option value="en">EN</option>
                        <option value="ar">العربية</option>
                    </select>
                </div>
                
                <!-- User Account -->
                @auth
                    <a href="{{ route('account.index') }}" class="hidden md:flex items-center justify-center w-10 h-10 rounded-lg hover:bg-primary/10 hover:text-primary transition-colors">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="hidden md:flex items-center justify-center w-10 h-10 rounded-lg hover:bg-primary/10 hover:text-primary transition-colors">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </a>
                @endauth
                
                <!-- Shopping Cart -->
                <a href="{{ route('cart.index') }}" class="relative flex items-center justify-center w-10 h-10 rounded-lg hover:bg-primary/10 hover:text-primary transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"/>
                    </svg>
                    @if(session('cart') && count(session('cart')) > 0)
                        <span class="absolute -right-1 -top-1 flex h-5 w-5 items-center justify-center rounded-full gradient-primary text-[10px] font-bold text-primary-foreground shadow-lg">
                            {{ count(session('cart')) }}
                        </span>
                    @endif
                </a>
                
                <!-- Mobile Menu Button -->
                <button class="md:hidden flex items-center justify-center w-10 h-10 rounded-lg hover:bg-primary/10 hover:text-primary transition-colors" onclick="toggleMobileMenu()">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden absolute top-full left-0 right-0 bg-card border-b border-border/50 glass-card">
        <div class="container mx-auto px-4 py-4 space-y-4">
            <a href="{{ route('home') }}" class="block text-sm font-medium text-foreground/70 hover:text-primary transition-colors {{ request()->routeIs('home') ? 'text-primary' : '' }}">
                {{ __('Home') }}
            </a>
            <a href="{{ route('products.index') }}" class="block text-sm font-medium text-foreground/70 hover:text-primary transition-colors {{ request()->routeIs('products.*') ? 'text-primary' : '' }}">
                {{ __('Products') }}
            </a>
            <a href="{{ route('games') }}" class="block text-sm font-medium text-foreground/70 hover:text-primary transition-colors {{ request()->routeIs('games') ? 'text-primary' : '' }}">
                {{ __('Games') }}
            </a>
            <a href="{{ route('leaderboard') }}" class="block text-sm font-medium text-foreground/70 hover:text-primary transition-colors {{ request()->routeIs('leaderboard') ? 'text-primary' : '' }}">
                {{ __('Leaderboard') }}
            </a>
            
            <!-- Mobile Search -->
            <div class="pt-4 border-t border-border/50">
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-primary/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="search" placeholder="{{ __('Search...') }}" 
                           class="w-full pl-10 pr-4 py-2 bg-muted/50 border border-border/50 rounded-lg focus:border-primary/50 focus:bg-muted/70 focus:outline-none transition-all text-foreground placeholder:text-muted-foreground">
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
function toggleMobileMenu() {
    const menu = document.getElementById('mobile-menu');
    menu.classList.toggle('hidden');
}
</script>
