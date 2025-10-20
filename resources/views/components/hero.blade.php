<!-- NXO Hero Section - Exact Design Specifications -->
<section class="relative py-20 md:py-32 overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-primary/5 rounded-full blur-3xl"></div>
        <div class="absolute top-1/4 right-1/4 w-[400px] h-[400px] bg-accent/5 rounded-full blur-3xl"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <!-- Main Heading -->
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-black mb-6">
                <span class="text-gradient">
                    {{ __('Digital Marketplace') }}
                </span>
                <br>
                <span class="text-foreground">
                    {{ __('for Gaming & Social') }}
                </span>
            </h1>
            
            <!-- Subtitle -->
            <p class="text-lg md:text-xl text-muted-foreground mb-8 max-w-2xl mx-auto leading-relaxed">
                {{ __('Discover premium gaming accounts, social media profiles, and digital assets. Buy and sell with confidence on our secure platform.') }}
            </p>
            
            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-12">
                <a href="{{ route('products.index') }}" class="btn-primary px-8 py-4 rounded-lg text-primary-foreground font-semibold text-lg shadow-lg hover:shadow-xl transition-all duration-300">
                    {{ __('Browse Products') }}
                    <svg class="inline-block ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
                <a href="{{ route('sell.index') }}" class="btn-secondary px-8 py-4 rounded-lg text-foreground font-semibold text-lg transition-all duration-300">
                    {{ __('Start Selling') }}
                </a>
            </div>
            
            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-3xl mx-auto">
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-primary mb-2">10K+</div>
                    <div class="text-muted-foreground">{{ __('Active Users') }}</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-accent mb-2">50K+</div>
                    <div class="text-muted-foreground">{{ __('Products Sold') }}</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-primary-cyan mb-2">99.9%</div>
                    <div class="text-muted-foreground">{{ __('Satisfaction Rate') }}</div>
                </div>
            </div>
        </div>
    </div>
</section>
