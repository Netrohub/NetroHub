@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden bg-dark-900">
    <!-- Animated Background -->
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gaming-gradient opacity-10"></div>
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary-500/20 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-secondary-500/20 rounded-full blur-3xl animate-float animation-delay-2000"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-neon-blue/5 rounded-full blur-3xl animate-pulse-slow"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-32">
        <div class="text-center">
            <!-- Hero Icon -->
            <div class="inline-flex items-center justify-center w-20 h-20 md:w-24 md:h-24 bg-gaming-gradient rounded-3xl mb-8 shadow-gaming-xl animate-float relative group">
                <div class="absolute inset-0 bg-gaming-gradient rounded-3xl blur-xl opacity-50 group-hover:opacity-100 transition-opacity"></div>
                <svg class="relative w-10 h-10 md:w-12 md:h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            
            <!-- Hero Title -->
            <h1 class="text-5xl md:text-7xl font-black mb-6 bg-gaming-gradient bg-clip-text text-transparent animate-fade-in leading-tight">
                Buy & Sell Digital Products
            </h1>
            
            <!-- Hero Subtitle -->
            <p class="text-xl md:text-2xl text-muted-300 max-w-3xl mx-auto mb-10 leading-relaxed animate-fade-in animation-delay-200">
                The ultimate marketplace for digital creators. Start selling in seconds with just one click.
            </p>
            
            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center animate-fade-in animation-delay-300">
                <a href="{{ route('products.index') }}" class="btn-lg bg-white text-dark-900 hover:bg-muted-100 hover:scale-105 hover:shadow-2xl transition-all duration-300 min-w-[200px]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Browse Products
                </a>
                <a href="{{ route('sell.entry') }}" class="btn-primary btn-lg min-w-[200px] group">
                    <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Start Selling Now
                </a>
            </div>
            
            <!-- Stats -->
            <div class="mt-16 grid grid-cols-3 gap-8 max-w-3xl mx-auto animate-fade-in animation-delay-500">
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-black text-gradient mb-2">10K+</div>
                    <div class="text-sm text-muted-400">Active Users</div>
                </div>
                <div class="text-center border-l border-r border-gaming">
                    <div class="text-3xl md:text-4xl font-black text-gradient mb-2">50K+</div>
                    <div class="text-sm text-muted-400">Products Sold</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-black text-gradient mb-2">$2M+</div>
                    <div class="text-sm text-muted-400">Revenue Generated</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories -->
@if($categories->isNotEmpty())
<section class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="text-center mb-12">
        <h2 class="text-4xl md:text-5xl font-black text-white mb-4">Popular Categories</h2>
        <p class="text-lg text-muted-400">Discover social media and gaming accounts</p>
    </div>
    
    <div class="flex justify-center">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl">
            @foreach($categories as $category)
                <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="group scroll-fade-in">
                    <div class="card-interactive h-full text-center p-6">
                        <div class="flex justify-center mb-4">
                            <div class="relative w-20 h-20 rounded-2xl bg-gaming-gradient flex items-center justify-center shadow-gaming group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                                <div class="absolute inset-0 bg-gaming-gradient rounded-2xl blur-xl opacity-50 group-hover:opacity-100 transition-opacity"></div>
                                <x-platform-icon :category="$category->name" size="lg" class="relative filter brightness-0 invert" />
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-white group-hover:text-gradient transition-all mb-2">{{ $category->name }}</h3>
                        <p class="text-sm text-muted-400">{{ $category->products_count }} products</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    
    <div class="text-center mt-10">
        <a href="{{ route('products.index') }}" class="btn-outline btn-lg group">
            <span>View All Products</span>
            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </a>
    </div>
</section>
@endif

<!-- Featured Products -->
@if($featuredProducts->isNotEmpty())
<section class="py-20 bg-gradient-to-b from-dark-900 to-dark-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl md:text-5xl font-black text-white mb-4">Featured Products</h2>
            <p class="text-lg text-muted-400">Hand-picked top quality products for you</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- How It Works -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="text-center mb-16">
        <h2 class="text-4xl md:text-5xl font-black text-white mb-4">How NetroHub Works</h2>
        <p class="text-lg text-muted-400">Get started in three simple steps</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="card-interactive text-center group scroll-fade-in">
            <div class="relative inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gaming-gradient shadow-gaming mx-auto mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                <div class="absolute inset-0 bg-gaming-gradient rounded-2xl blur-xl opacity-50 group-hover:opacity-100 transition-opacity"></div>
                <span class="relative text-4xl">👤</span>
            </div>
            <div class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary-500/20 text-primary-400 font-bold text-sm mb-4">1</div>
            <h3 class="text-2xl font-bold text-white mb-3 group-hover:text-gradient transition-all">Create Account</h3>
            <p class="text-muted-400 leading-relaxed">Sign up in seconds with just your email. One account for both buying and selling.</p>
        </div>
        
        <div class="card-interactive text-center group scroll-fade-in animation-delay-200">
            <div class="relative inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gaming-gradient shadow-gaming mx-auto mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                <div class="absolute inset-0 bg-gaming-gradient rounded-2xl blur-xl opacity-50 group-hover:opacity-100 transition-opacity"></div>
                <span class="relative text-4xl">🚀</span>
            </div>
            <div class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-secondary-500/20 text-secondary-400 font-bold text-sm mb-4">2</div>
            <h3 class="text-2xl font-bold text-white mb-3 group-hover:text-gradient transition-all">List Products</h3>
            <p class="text-muted-400 leading-relaxed">Hit the Sell button and start adding products immediately. It's that simple.</p>
        </div>
        
        <div class="card-interactive text-center group scroll-fade-in animation-delay-300">
            <div class="relative inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gaming-gradient shadow-gaming mx-auto mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                <div class="absolute inset-0 bg-gaming-gradient rounded-2xl blur-xl opacity-50 group-hover:opacity-100 transition-opacity"></div>
                <span class="relative text-4xl">💰</span>
            </div>
            <div class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-neon-green/20 text-neon-green font-bold text-sm mb-4">3</div>
            <h3 class="text-2xl font-bold text-white mb-3 group-hover:text-gradient transition-all">Get Paid</h3>
            <p class="text-muted-400 leading-relaxed">Receive payments instantly. Request payouts anytime to your preferred method.</p>
        </div>
    </div>
</section>

<!-- Recent Products -->
@if($recentProducts->isNotEmpty())
<section class="py-16 bg-dark-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold">Recently Added</h2>
            <a href="{{ route('products.index') }}" class="text-primary-400 hover:text-white font-semibold">
                View All →
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($recentProducts->take(8) as $product)
                <x-ui.card class="overflow-hidden">
                    <div class="aspect-video bg-gaming-gradient rounded-xl overflow-hidden mb-4">
                        <img src="{{ $product->thumbnail_url ?? '/img/placeholder.jpg' }}" alt="{{ $product->title }}" class="w-full h-full object-cover">
                    </div>
                    <h3 class="font-semibold mb-2 line-clamp-2">{{ $product->title }}</h3>
                    <p class="text-sm text-muted-400 mb-3">by {{ $product->seller->display_name }}</p>
                    <div class="flex items-center justify-between">
                        <span class="text-xl font-bold text-primary-400">${{ number_format($product->price, 2) }}</span>
                        <a href="{{ route('products.show', $product->slug) }}" class="text-primary-400 hover:text-white text-sm font-semibold">
                            View →
                        </a>
                    </div>
                </x-ui.card>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="relative overflow-hidden">
    <div class="absolute inset-0 bg-gaming-gradient"></div>
    <div class="absolute inset-0 bg-noise"></div>
    
    <!-- Animated Orbs -->
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-white/10 rounded-full blur-3xl animate-float"></div>
    <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-white/10 rounded-full blur-3xl animate-float animation-delay-2000"></div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-32 text-center">
        <h2 class="text-4xl md:text-6xl font-black text-white mb-6 leading-tight">
            Ready to Start Selling?
        </h2>
        <p class="text-xl md:text-2xl mb-10 text-white/90 max-w-3xl mx-auto leading-relaxed">
            Join thousands of creators already earning on NetroHub. No setup fees, no monthly costs.
        </p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="{{ route('sell.entry') }}" class="btn-xl bg-white text-dark-900 hover:bg-muted-100 hover:scale-105 hover:shadow-2xl transition-all duration-300 min-w-[250px] group">
                <svg class="w-6 h-6 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                Start Selling Now
            </a>
            <a href="{{ route('products.index') }}" class="btn-xl bg-transparent text-white border-2 border-white hover:bg-white/10 transition-all duration-300 min-w-[250px]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Browse Marketplace
            </a>
        </div>
        
        <!-- Trust Indicators -->
        <div class="mt-16 flex flex-wrap justify-center items-center gap-8 text-white/80">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-neon-green" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="font-semibold">Secure Payments</span>
            </div>
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-neon-green" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="font-semibold">Instant Delivery</span>
            </div>
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-neon-green" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="font-semibold">24/7 Support</span>
            </div>
        </div>
    </div>
</section>
@endsection

