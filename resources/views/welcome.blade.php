<x-layouts.app>
    <x-slot name="title">{{ config('app.name') }} - {{ __('Digital Marketplace for Gaming & Social') }}</x-slot>

    <!-- Hero Section -->
    <x-hero />

    <!-- Categories Section -->
    <section class="py-20 relative">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">
                    <span class="bg-gradient-to-r from-primary via-accent to-primary bg-clip-text text-transparent">
                        {{ __('Browse Categories') }}
                    </span>
                </h2>
                <p class="text-muted-foreground text-lg max-w-2xl mx-auto">
                    {{ __('Discover premium digital assets across gaming and social media platforms') }}
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Gaming Accounts -->
                <div class="group glass-card rounded-2xl p-8 text-center hover:scale-105 transition-all duration-300">
                    <div class="w-16 h-16 mx-auto mb-6 rounded-2xl gradient-primary flex items-center justify-center">
                        <svg class="w-8 h-8 text-primary-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-foreground mb-3">{{ __('Gaming Accounts') }}</h3>
                    <p class="text-muted-foreground mb-6">{{ __('Premium gaming accounts with rare items, high levels, and exclusive content') }}</p>
                    <a href="{{ route('games') }}" class="inline-flex items-center text-primary hover:text-accent transition-colors font-semibold">
                        {{ __('Explore Games') }}
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
                
                <!-- Social Media -->
                <div class="group glass-card rounded-2xl p-8 text-center hover:scale-105 transition-all duration-300">
                    <div class="w-16 h-16 mx-auto mb-6 rounded-2xl gradient-primary flex items-center justify-center">
                        <svg class="w-8 h-8 text-primary-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-foreground mb-3">{{ __('Social Media') }}</h3>
                    <p class="text-muted-foreground mb-6">{{ __('Verified social media accounts with followers, engagement, and premium content') }}</p>
                    <a href="{{ route('products.index', ['category' => 'social']) }}" class="inline-flex items-center text-primary hover:text-accent transition-colors font-semibold">
                        {{ __('Browse Social') }}
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
                
                <!-- Digital Products -->
                <div class="group glass-card rounded-2xl p-8 text-center hover:scale-105 transition-all duration-300">
                    <div class="w-16 h-16 mx-auto mb-6 rounded-2xl gradient-primary flex items-center justify-center">
                        <svg class="w-8 h-8 text-primary-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-foreground mb-3">{{ __('Digital Products') }}</h3>
                    <p class="text-muted-foreground mb-6">{{ __('Software, courses, ebooks, and other digital assets for your needs') }}</p>
                    <a href="{{ route('products.index', ['category' => 'digital']) }}" class="inline-flex items-center text-primary hover:text-accent transition-colors font-semibold">
                        {{ __('View Products') }}
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="py-20 relative">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">
                    <span class="bg-gradient-to-r from-primary via-accent to-primary bg-clip-text text-transparent">
                        {{ __('Featured Products') }}
                    </span>
                </h2>
                <p class="text-muted-foreground text-lg max-w-2xl mx-auto">
                    {{ __('Handpicked premium products from our top sellers') }}
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse(\App\Models\Product::featured()->active()->inStock()->with(['seller', 'category'])->limit(8)->get() as $product)
                    <x-product-card :product="$product" />
                @empty
                    <div class="col-span-full text-center py-12">
                        <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-muted flex items-center justify-center">
                            <svg class="w-10 h-10 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-foreground mb-2">{{ __('No featured products yet') }}</h3>
                        <p class="text-muted-foreground mb-6">{{ __('Check back soon for amazing featured products!') }}</p>
                        <a href="{{ route('products.index') }}" class="btn-glow px-6 py-3 rounded-lg text-primary-foreground font-semibold">
                            {{ __('Browse All Products') }}
                        </a>
                    </div>
                @endforelse
            </div>
            
            @if(\App\Models\Product::featured()->active()->inStock()->count() > 8)
                <div class="text-center mt-12">
                    <a href="{{ route('products.index', ['featured' => true]) }}" class="btn-glow px-8 py-4 rounded-lg text-primary-foreground font-semibold text-lg">
                        {{ __('View All Featured Products') }}
                        <svg class="inline-block ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 relative">
        <div class="container mx-auto px-4">
            <div class="glass-card rounded-3xl p-12 text-center max-w-4xl mx-auto">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">
                    <span class="bg-gradient-to-r from-primary via-accent to-primary bg-clip-text text-transparent">
                        {{ __('Ready to Get Started?') }}
                    </span>
                </h2>
                <p class="text-muted-foreground text-lg mb-8 max-w-2xl mx-auto">
                    {{ __('Join thousands of users buying and selling digital assets on our secure platform.') }}
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @auth
                        <a href="{{ route('products.index') }}" class="btn-glow px-8 py-4 rounded-lg text-primary-foreground font-semibold text-lg">
                            {{ __('Browse Products') }}
                        </a>
                        @if(auth()->user()->seller)
                            <a href="{{ route('seller.dashboard') }}" class="px-8 py-4 rounded-lg border border-border hover:border-primary/50 text-foreground font-semibold text-lg transition-all duration-300 hover:bg-primary/5">
                                {{ __('Seller Dashboard') }}
                            </a>
                        @else
                            <a href="{{ route('sell.index') }}" class="px-8 py-4 rounded-lg border border-border hover:border-primary/50 text-foreground font-semibold text-lg transition-all duration-300 hover:bg-primary/5">
                                {{ __('Start Selling') }}
                            </a>
                        @endif
                    @else
                        <a href="{{ route('register') }}" class="btn-glow px-8 py-4 rounded-lg text-primary-foreground font-semibold text-lg">
                            {{ __('Get Started Free') }}
                        </a>
                        <a href="{{ route('login') }}" class="px-8 py-4 rounded-lg border border-border hover:border-primary/50 text-foreground font-semibold text-lg transition-all duration-300 hover:bg-primary/5">
                            {{ __('Sign In') }}
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
