<x-layouts.stellar>
    <x-slot name="title">{{ \App\Models\SiteSetting::get('site_name', config('app.name')) }}</x-slot>

<section class="relative pt-32 pb-12">
@php
    $heroBlock = \App\Models\ContentBlock::getByIdentifier('homepage_hero');
    $featuresBlock = \App\Models\ContentBlock::getByIdentifier('homepage_features');
    $statsBlock = \App\Models\ContentBlock::getByIdentifier('homepage_stats');
    $howItWorksBlock = \App\Models\ContentBlock::getByIdentifier('homepage_how_it_works');
    $testimonialsBlock = \App\Models\ContentBlock::getByIdentifier('homepage_testimonials');
    $ctaBlock = \App\Models\ContentBlock::getByIdentifier('homepage_cta');
@endphp

{{-- Hero Section --}}
@if($heroBlock && $heroBlock->canView(auth()->user()))
<section class="relative overflow-hidden bg-dark-900 py-12 sm:py-16 md:py-20 lg:py-24">
    <!-- Animated Background -->
    <div class="absolute inset-0">
        <div class="absolute top-1/4 left-1/4 w-64 h-64 sm:w-96 sm:h-96 bg-primary-500/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-1/4 right-1/4 w-64 h-64 sm:w-96 sm:h-96 bg-secondary-500/10 rounded-full blur-3xl animate-float animation-delay-2000"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <!-- Icon -->
        <div class="inline-flex items-center justify-center w-14 h-14 sm:w-16 sm:h-16 md:w-20 md:h-20 bg-gaming-gradient rounded-2xl sm:rounded-3xl mb-4 sm:mb-6 shadow-gaming-lg animate-bounce-in">
            <svg class="w-7 h-7 sm:w-8 sm:h-8 md:w-10 md:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
        </div>
        
        <!-- Title -->
        <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-black mb-4 sm:mb-6 text-gradient leading-tight sm:leading-snug scroll-fade-in">
            {{ $heroBlock->title }}
        </h1>
        
        <!-- Description -->
        <p class="text-base sm:text-lg md:text-xl lg:text-2xl text-muted-300 max-w-3xl mx-auto mb-6 sm:mb-8 md:mb-10 leading-relaxed scroll-fade-in animation-delay-100">
            {{ $heroBlock->content }}
        </p>
        
        <!-- CTAs -->
        <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center items-stretch sm:items-center scroll-fade-in animation-delay-200 max-w-lg mx-auto sm:max-w-none">
            <a href="{{ route('products.index') }}" 
               class="inline-flex items-center justify-center gap-2 px-6 py-3 text-base font-bold bg-slate-700/50 hover:bg-slate-600/50 text-white rounded-xl transition-all duration-300 shadow-lg min-h-[48px] group">
                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                {{ __('أقرا الوثائق') }}
            </a>
            @auth
                @if(auth()->user()->hasVerifiedEmail() && auth()->user()->kyc_verified && auth()->user()->phone_verified)
                    <a href="{{ route('sell.index') }}" 
                       class="inline-flex items-center justify-center gap-2 px-6 py-3 text-base font-bold bg-gradient-to-r from-purple-400 via-purple-500 to-purple-600 hover:from-purple-500 hover:via-purple-600 hover:to-purple-700 text-white rounded-xl transition-all duration-300 shadow-lg shadow-purple-500/25 hover:shadow-purple-500/40 min-h-[48px] group">
                        <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        {{ __('ابدأ الآن') }} 🚀
                    </a>
                @else
                    <a href="{{ route('account.verification.checklist') }}" 
                       class="inline-flex items-center justify-center gap-2 px-6 py-3 text-base font-bold bg-gradient-to-r from-purple-400 via-purple-500 to-purple-600 hover:from-purple-500 hover:via-purple-600 hover:to-purple-700 text-white rounded-xl transition-all duration-300 shadow-lg shadow-purple-500/25 hover:shadow-purple-500/40 min-h-[48px] group">
                        <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        {{ __('ابدأ الآن') }} 🚀
                    </a>
                @endif
            @else
                <a href="{{ route('register') }}" 
                   class="inline-flex items-center justify-center gap-2 px-6 py-3 text-base font-bold bg-gradient-to-r from-purple-400 via-purple-500 to-purple-600 hover:from-purple-500 hover:via-purple-600 hover:to-purple-700 text-white rounded-xl transition-all duration-300 shadow-lg shadow-purple-500/25 hover:shadow-purple-500/40 min-h-[48px] group">
                    <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    {{ __('ابدأ الآن') }} 🚀
                </a>
            @endauth
        </div>
    </div>
</section>
@endif

{{-- Stats Section --}}
@if($statsBlock && $statsBlock->canView(auth()->user()))
<section class="bg-dark-800/50 backdrop-blur-sm border-y border-gaming py-8 sm:py-10 md:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 md:gap-8 scroll-stagger">
            @foreach($statsBlock->metadata['stats'] ?? [] as $stat)
                <div class="text-center scroll-fade-in">
                    <div class="text-3xl sm:text-4xl md:text-5xl font-black text-gradient mb-1 sm:mb-2 leading-none">
                        <span data-count="{{ $stat['value'] }}" data-duration="2000">0</span>{{ $stat['suffix'] ?? '' }}
                    </div>
                    <p class="text-xs sm:text-sm md:text-base text-muted-400 font-medium">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Categories Section --}}
@if($categories->isNotEmpty())
<section class="py-12 sm:py-16 md:py-20 bg-dark-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8 sm:mb-10 md:mb-12 scroll-fade-in">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-black text-white mb-3 sm:mb-4 leading-tight">{{ __('Popular Categories') }}</h2>
            <p class="text-muted-400 text-sm sm:text-base md:text-lg">{{ __('Browse our most popular digital product categories') }}</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 scroll-stagger">
            @foreach($categories as $category)
                <a href="{{ route('products.index', ['category' => $category->slug]) }}" 
                   class="group scroll-fade-in">
                    <div class="card card-hover p-4 sm:p-5 md:p-6 text-center h-full">
                        <div class="flex justify-center mb-3 sm:mb-4">
                            <div class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 rounded-xl sm:rounded-2xl bg-gaming-gradient flex items-center justify-center shadow-gaming group-hover:scale-110 transition-transform duration-300">
                                <x-platform-icon :category="$category->name" size="lg" class="filter brightness-0 invert" />
                            </div>
                        </div>
                        <h3 class="font-bold text-sm sm:text-base md:text-lg mb-1 sm:mb-2 group-hover:text-primary-400 transition-colors line-clamp-1">
                            {{ $category->name }}
                        </h3>
                        <p class="text-sm text-muted-400">
                            {{ number_format($category->products_count) }} {{ __('products') }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
        
        <div class="text-center mt-10 scroll-fade-in">
            <a href="{{ route('products.index') }}" class="link text-lg font-semibold">
                {{ __('View all categories') }} →
            </a>
        </div>
    </div>
</section>
@endif

{{-- Featured Products --}}
@if($featuredProducts->isNotEmpty())
<section class="section-padding bg-dark-800/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 scroll-fade-in">
            <h2 class="text-3xl md:text-4xl font-black text-white mb-4">{{ __('Featured Products') }}</h2>
            <p class="text-muted-400 text-lg">{{ __('Handpicked premium products from top sellers') }}</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 scroll-stagger">
            @foreach($featuredProducts as $product)
                <div class="scroll-fade-in">
                    <div class="card card-hover overflow-hidden h-full flex flex-col">
                        <!-- Product Image -->
                        <div class="aspect-video bg-gaming-gradient rounded-xl overflow-hidden mb-4 img-hover-zoom">
                            <img src="{{ $product->thumbnail_url ?? '/img/placeholder.jpg' }}" 
                                 alt="{{ $product->title }}" 
                                 class="w-full h-full object-cover"
                                 loading="lazy">
                        </div>
                        
                        <!-- Product Info -->
                        <div class="p-4 flex-1 flex flex-col">
                            <h3 class="font-bold text-lg mb-2 line-clamp-2">{{ $product->title }}</h3>
                            
                            <!-- Rating & Sales -->
                            <div class="flex items-center gap-3 text-sm text-muted-400 mb-4">
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.519-4.674z"/>
                                    </svg>
                                    <span>{{ number_format($product->rating, 1) }}</span>
                                </div>
                                <span>•</span>
                                <span>{{ number_format($product->sales_count) }} sales</span>
                            </div>
                            
                            <!-- Price & CTA -->
                            <div class="flex items-center justify-between mt-auto">
                                <span class="text-2xl font-black text-gradient">
                                    ${{ number_format($product->price, 2) }}
                                </span>
                                <a href="{{ route('products.show', $product->slug) }}" 
                                   class="btn-primary btn-sm">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Features Section --}}
@if($featuresBlock && $featuresBlock->canView(auth()->user()))
<section class="section-padding bg-dark-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 scroll-fade-in">
            <h2 class="text-3xl md:text-4xl font-black text-white mb-4">{{ $featuresBlock->title }}</h2>
            <p class="text-muted-400 text-lg">{{ $featuresBlock->content }}</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 scroll-stagger">
            @foreach($featuresBlock->metadata['features'] ?? [] as $feature)
                <div class="scroll-fade-in">
                    <div class="card card-glass p-8 text-center h-full hover-lift">
                        <div class="text-5xl mb-4">{{ $feature['icon'] }}</div>
                        <h3 class="text-xl font-bold text-white mb-3">{{ $feature['title'] }}</h3>
                        <p class="text-muted-300 leading-relaxed">{{ $feature['description'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- How It Works --}}
@if($howItWorksBlock && $howItWorksBlock->canView(auth()->user()))
<section class="section-padding bg-dark-800/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 scroll-fade-in">
            <h2 class="text-3xl md:text-4xl font-black text-white mb-4">{{ $howItWorksBlock->title }}</h2>
            <p class="text-muted-400 text-lg">{{ $howItWorksBlock->content }}</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 scroll-stagger">
            @foreach($howItWorksBlock->metadata['steps'] ?? [] as $index => $step)
                <div class="scroll-fade-in">
                    <div class="card card-gradient p-8 text-center h-full relative">
                        <!-- Step Number -->
                        <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 w-12 h-12 bg-gaming-gradient rounded-full flex items-center justify-center text-2xl font-black text-white shadow-gaming">
                            {{ $index + 1 }}
                        </div>
                        
                        <div class="text-5xl mb-6 mt-4">{{ $step['icon'] }}</div>
                        <h3 class="text-xl font-bold text-white mb-3">{{ $step['title'] }}</h3>
                        <p class="text-muted-300 leading-relaxed">{{ $step['description'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Testimonials --}}
@if($testimonialsBlock && $testimonialsBlock->canView(auth()->user()))
<section class="section-padding bg-dark-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 scroll-fade-in">
            <h2 class="text-3xl md:text-4xl font-black text-white mb-4">{{ $testimonialsBlock->title }}</h2>
            <p class="text-muted-400 text-lg">{{ $testimonialsBlock->content }}</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 scroll-stagger">
            @foreach($testimonialsBlock->metadata['testimonials'] ?? [] as $testimonial)
                <div class="scroll-fade-in">
                    <div class="card card-hover p-8 h-full">
                        <!-- Rating -->
                        <div class="flex gap-1 mb-4">
                            @for($i = 0; $i < ($testimonial['rating'] ?? 5); $i++)
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                            @endfor
                        </div>
                        
                        <!-- Content -->
                        <p class="text-muted-300 mb-6 leading-relaxed">"{{ $testimonial['content'] }}"</p>
                        
                        <!-- Author -->
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-full bg-gaming-gradient flex items-center justify-center text-white font-bold text-lg">
                                {{ substr($testimonial['name'], 0, 1) }}
                            </div>
                            <div>
                                <div class="font-bold text-white">{{ $testimonial['name'] }}</div>
                                <div class="text-sm text-muted-400">{{ $testimonial['role'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Final CTA --}}
@if($ctaBlock && $ctaBlock->canView(auth()->user()))
<section class="section-padding bg-gaming-gradient relative overflow-hidden">
    <!-- Animated Background -->
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-0 left-1/4 w-64 h-64 bg-white rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-0 right-1/4 w-64 h-64 bg-white rounded-full blur-3xl animate-pulse animation-delay-1000"></div>
    </div>
    
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center scroll-fade-in">
        <h2 class="text-4xl md:text-5xl font-black text-white mb-6">
            {{ $ctaBlock->title }}
        </h2>
        <p class="text-xl text-white/90 mb-10">
            {{ $ctaBlock->content }}
        </p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ $ctaBlock->metadata['cta_link'] ?? '/register' }}" 
               class="btn-secondary btn-lg bg-white text-dark-900 hover:bg-white/90">
                {{ $ctaBlock->metadata['cta_text'] ?? 'Create Free Account' }}
            </a>
            @if(isset($ctaBlock->metadata['secondary_text']))
                <a href="{{ $ctaBlock->metadata['secondary_link'] ?? '/products' }}" 
                   class="btn-ghost btn-lg text-white border-white hover:bg-white/10">
                    {{ $ctaBlock->metadata['secondary_text'] }}
                </a>
            @endif
        </div>
    </div>
</section>
@endif

{{-- Discord Community Section --}}
<section class="section-padding bg-dark-900 border-t border-gaming">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center scroll-fade-in">
        <!-- Discord Icon -->
        <div class="inline-flex items-center justify-center w-20 h-20 bg-indigo-600 rounded-full mb-6 shadow-lg hover:scale-110 transition-transform duration-300">
            <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515a.074.074 0 0 0-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 0 0-5.487 0a12.64 12.64 0 0 0-.617-1.25a.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37a.07.07 0 0 0-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 0 0 .031.057a19.9 19.9 0 0 0 5.993 3.03a.078.078 0 0 0 .084-.028a14.09 14.09 0 0 0 1.226-1.994a.076.076 0 0 0-.041-.106a13.107 13.107 0 0 1-1.872-.892a.077.077 0 0 1-.008-.128a10.2 10.2 0 0 0 .372-.292a.074.074 0 0 1 .077-.01c3.928 1.793 8.18 1.793 12.062 0a.074.074 0 0 1 .078.01c.12.098.246.198.373.292a.077.077 0 0 1-.006.127a12.299 12.299 0 0 1-1.873.892a.077.077 0 0 0-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 0 0 .084.028a19.839 19.839 0 0 0 6.002-3.03a.077.077 0 0 0 .032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 0 0-.031-.03zM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419c0-1.333.956-2.419 2.157-2.419c1.21 0 2.176 1.096 2.157 2.42c0 1.333-.956 2.418-2.157 2.418zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419c0-1.333.955-2.419 2.157-2.419c1.21 0 2.176 1.096 2.157 2.42c0 1.333-.946 2.418-2.157 2.418z"/>
            </svg>
        </div>
        
        <h2 class="text-3xl md:text-4xl font-black text-white mb-4">
            {{ __('Join Our Discord Community') }}
        </h2>
        <p class="text-lg text-muted-400 mb-8 leading-relaxed">
            {{ __('Connect with thousands of sellers and buyers, get instant support, and stay updated with the latest news and exclusive offers!') }}
        </p>
        
        <!-- Discord Button -->
        @php
            $discordUrl = \App\Models\Setting::get('discord_url', 'https://discord.gg/your-server');
        @endphp
        <a href="{{ $discordUrl }}" 
           target="_blank"
           rel="noopener noreferrer"
           class="inline-flex items-center gap-3 px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white text-lg font-bold rounded-xl transition-all duration-300 shadow-lg hover:shadow-2xl hover:scale-105 group">
            <svg class="w-6 h-6 group-hover:rotate-12 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                <path d="M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515a.074.074 0 0 0-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 0 0-5.487 0a12.64 12.64 0 0 0-.617-1.25a.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37a.07.07 0 0 0-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 0 0 .031.057a19.9 19.9 0 0 0 5.993 3.03a.078.078 0 0 0 .084-.028a14.09 14.09 0 0 0 1.226-1.994a.076.076 0 0 0-.041-.106a13.107 13.107 0 0 1-1.872-.892a.077.077 0 0 1-.008-.128a10.2 10.2 0 0 0 .372-.292a.074.074 0 0 1 .077-.01c3.928 1.793 8.18 1.793 12.062 0a.074.074 0 0 1 .078.01c.12.098.246.198.373.292a.077.077 0 0 1-.006.127a12.299 12.299 0 0 1-1.873.892a.077.077 0 0 0-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 0 0 .084.028a19.839 19.839 0 0 0 6.002-3.03a.077.077 0 0 0 .032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 0 0-.031-.03zM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419c0-1.333.956-2.419 2.157-2.419c1.21 0 2.176 1.096 2.157 2.42c0 1.333-.956 2.418-2.157 2.418zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419c0-1.333.955-2.419 2.157-2.419c1.21 0 2.176 1.096 2.157 2.42c0 1.333-.946 2.418-2.157 2.418z"/>
            </svg>
            {{ __('Join Discord Server') }}
            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
            </svg>
        </a>
        
        <!-- Benefits -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12">
            <div class="text-center">
                <div class="text-3xl mb-2">💬</div>
                <h3 class="font-bold text-white mb-1">{{ __('Instant Support') }}</h3>
                <p class="text-sm text-muted-400">{{ __('Get help from our team and community') }}</p>
            </div>
            <div class="text-center">
                <div class="text-3xl mb-2">🎉</div>
                <h3 class="font-bold text-white mb-1">{{ __('Exclusive Events') }}</h3>
                <p class="text-sm text-muted-400">{{ __('Join giveaways and special promotions') }}</p>
            </div>
            <div class="text-center">
                <div class="text-3xl mb-2">🤝</div>
                <h3 class="font-bold text-white mb-1">{{ __('Active Community') }}</h3>
                <p class="text-sm text-muted-400">{{ __('Connect with sellers and buyers') }}</p>
            </div>
        </div>
    </div>
</section>

</x-layouts.stellar>


