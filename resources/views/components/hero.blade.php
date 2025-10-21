<!-- NXO Hero Section - Exact Blueprint Implementation -->
<section class="relative py-24 md:py-32 overflow-hidden">
    <!-- Cosmic gradient background -->
    <div class="absolute inset-0 gradient-nebula opacity-80"></div>
    
    <!-- Glow effects -->
    <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary/20 rounded-full blur-[120px] animate-pulse"></div>
    <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-accent/20 rounded-full blur-[120px] animate-pulse" style="animation-delay: 1s;"></div>
    
    <div class="max-w-7xl mx-auto px-4 relative z-10">
        <div class="flex flex-col items-center text-center space-y-8">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass-card border border-primary/30 mb-4">
                <svg class="h-4 w-4 text-primary animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                </svg>
                <span class="text-sm font-medium bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">
                    {{ __('Welcome to the Future of Digital Trading') }}
                </span>
            </div>
            
            <div class="space-y-6 max-w-4xl">
                <h1 class="text-5xl md:text-7xl font-black tracking-tight leading-tight">
                    {{ __('Digital Marketplace') }}{" "}
                    <span class="bg-gradient-to-r from-primary via-accent to-primary bg-clip-text text-transparent animate-pulse">
                        {{ __('for Gaming & Social') }}
                    </span>
                </h1>
                <p class="text-lg md:text-xl text-foreground/70 max-w-2xl mx-auto leading-relaxed">
                    {{ __('Discover premium gaming accounts, social media profiles, and digital assets. Buy and sell with confidence on our secure platform.') }}
                </p>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-4 pt-4">
                <a href="{{ route('products.index') }}" class="btn-glow group text-base px-8 py-6 rounded-lg text-primary-foreground font-semibold flex items-center gap-2">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    {{ __('Explore Products') }}
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
                <a href="{{ route('sell.index') }}" class="glass-card border-primary/30 hover:border-primary/50 text-base px-8 py-6 rounded-lg text-foreground font-semibold transition-all duration-300">
                    {{ __('Become a Seller') }}
                </a>
            </div>
            
            <!-- Feature badges -->
            <div class="flex flex-wrap justify-center gap-6 pt-8">
                <div class="flex items-center gap-2 text-sm text-foreground/70">
                    <div class="p-2 rounded-lg bg-primary/10 border border-primary/20">
                        <svg class="h-4 w-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <span>{{ __('Secure Payments') }}</span>
                </div>
                <div class="flex items-center gap-2 text-sm text-foreground/70">
                    <div class="p-2 rounded-lg bg-accent/10 border border-accent/20">
                        <svg class="h-4 w-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <span>{{ __('Instant Access') }}</span>
                </div>
                <div class="flex items-center gap-2 text-sm text-foreground/70">
                    <div class="p-2 rounded-lg bg-primary/10 border border-primary/20">
                        <svg class="h-4 w-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                    <span>{{ __('24/7 Support') }}</span>
                </div>
            </div>
        </div>
    </div>
</section>
