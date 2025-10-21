<x-layouts.app>
    <x-slot name="title">{{ __('Welcome') }} - {{ config('app.name') }}</x-slot>
    
    <!-- Starfield Background -->
    <x-starfield />
    
    <!-- Hero Section -->
    <x-hero />
    
    <!-- Category Grid Section -->
    <x-category-grid />
    
    <!-- Featured Products Section -->
    <section class="py-16 relative">
        <!-- Background glow effect -->
        <div class="absolute inset-0 gradient-cosmic opacity-30"></div>
        
        <div class="max-w-7xl mx-auto px-4 relative z-10">
            <div class="mb-12 text-center space-y-3">
                <h2 class="text-4xl font-black bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">
                    {{ __('Featured Accounts') }}
                </h2>
                <p class="text-foreground/60 text-lg">{{ __('Premium verified accounts from top sellers') }}</p>
            </div>
            
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Featured Product 1 -->
                <x-product-card 
                    id="1"
                    name="Premium Gaming Account - Level 100"
                    price="299.99"
                    category="Gaming"
                    rating="4.8"
                    reviews="234"
                    featured="true"
                    description="High-level gaming account with exclusive items and achievements."
                />
                
                <!-- Featured Product 2 -->
                <x-product-card 
                    id="2"
                    name="Instagram Business Account - 50K Followers"
                    price="199.99"
                    category="Social Media"
                    rating="4.6"
                    reviews="189"
                    featured="true"
                    description="Verified Instagram business account with engaged audience."
                />
                
                <!-- Featured Product 3 -->
                <x-product-card 
                    id="3"
                    name="YouTube Channel - 100K Subscribers"
                    price="599.99"
                    category="Streaming"
                    rating="4.9"
                    reviews="156"
                    featured="true"
                    description="Monetized YouTube channel with consistent content and growth."
                />
                
                <!-- Featured Product 4 -->
                <x-product-card 
                    id="4"
                    name="TikTok Account - 1M Followers"
                    price="399.99"
                    category="Social Media"
                    rating="4.7"
                    reviews="342"
                    featured="false"
                    description="Viral TikTok account with trending content and high engagement."
                />
                
                <!-- Featured Product 5 -->
                <x-product-card 
                    id="5"
                    name="Discord Server - 10K Members"
                    price="149.99"
                    category="Digital Services"
                    rating="4.5"
                    reviews="278"
                    featured="false"
                    description="Active Discord community with premium features and moderation."
                />
                
                <!-- Featured Product 6 -->
                <x-product-card 
                    id="6"
                    name="Crypto Trading Bot - Automated"
                    price="799.99"
                    category="Crypto & Finance"
                    rating="4.8"
                    reviews="167"
                    featured="false"
                    description="Advanced trading bot with proven profitability and risk management."
                />
            </div>
            
            <div class="text-center mt-12">
                <a href="{{ route('products.index') }}" class="btn-glow text-base px-8 py-4 rounded-lg text-primary-foreground font-semibold">
                    {{ __('View All Products') }}
                </a>
            </div>
        </div>
    </section>
    
</x-layouts.app>