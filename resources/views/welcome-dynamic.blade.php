@extends('layouts.app')

@section('title', \App\Models\SiteSetting::get('site_name', 'NetroHub'))

@section('content')
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
<section class="relative overflow-hidden bg-dark-900 section-padding">
    <!-- Animated Background -->
    <div class="absolute inset-0">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary-500/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-secondary-500/10 rounded-full blur-3xl animate-float animation-delay-2000"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
        <!-- Icon -->
        <div class="inline-flex items-center justify-center w-20 h-20 bg-gaming-gradient rounded-3xl mb-6 shadow-gaming-lg animate-bounce-in">
            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
        </div>
        
        <!-- Title -->
        <h1 class="text-5xl md:text-6xl lg:text-7xl font-black mb-6 text-gradient scroll-fade-in">
            {{ $heroBlock->title }}
        </h1>
        
        <!-- Description -->
        <p class="text-xl md:text-2xl text-muted-300 max-w-3xl mx-auto mb-10 scroll-fade-in animation-delay-100">
            {{ $heroBlock->content }}
        </p>
        
        <!-- CTAs -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center scroll-fade-in animation-delay-200">
            <a href="{{ $heroBlock->metadata['cta_primary_link'] ?? '/products' }}" 
               class="btn-secondary btn-lg group">
                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                {{ $heroBlock->metadata['cta_primary_text'] ?? 'Browse Products' }}
            </a>
            <a href="{{ $heroBlock->metadata['cta_secondary_link'] ?? '/sell' }}" 
               class="btn-primary btn-lg group">
                <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                {{ $heroBlock->metadata['cta_secondary_text'] ?? 'Start Selling' }}
            </a>
        </div>
    </div>
</section>
@endif

{{-- Stats Section --}}
@if($statsBlock && $statsBlock->canView(auth()->user()))
<section class="bg-dark-800/50 backdrop-blur-sm border-y border-gaming py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 scroll-stagger">
            @foreach($statsBlock->metadata['stats'] ?? [] as $stat)
                <div class="text-center scroll-fade-in">
                    <div class="text-4xl md:text-5xl font-black text-gradient mb-2">
                        <span data-count="{{ $stat['value'] }}" data-duration="2000">0</span>{{ $stat['suffix'] ?? '' }}
                    </div>
                    <p class="text-sm md:text-base text-muted-400 font-medium">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Categories Section --}}
@if($categories->isNotEmpty())
<section class="section-padding bg-dark-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 scroll-fade-in">
            <h2 class="text-3xl md:text-4xl font-black text-white mb-4">Popular Categories</h2>
            <p class="text-muted-400 text-lg">Browse our most popular digital product categories</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 scroll-stagger">
            @foreach($categories as $category)
                <a href="{{ route('products.index', ['category' => $category->slug]) }}" 
                   class="group scroll-fade-in">
                    <div class="card card-hover p-6 text-center h-full">
                        <div class="flex justify-center mb-4">
                            <div class="w-16 h-16 rounded-2xl bg-gaming-gradient flex items-center justify-center shadow-gaming group-hover:scale-110 transition-transform duration-300">
                                <x-platform-icon :category="$category->name" size="lg" class="filter brightness-0 invert" />
                            </div>
                        </div>
                        <h3 class="font-bold text-lg mb-2 group-hover:text-primary-400 transition-colors">
                            {{ $category->name }}
                        </h3>
                        <p class="text-sm text-muted-400">
                            {{ number_format($category->products_count) }} products
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
        
        <div class="text-center mt-10 scroll-fade-in">
            <a href="{{ route('products.index') }}" class="link text-lg font-semibold">
                View all categories →
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
            <h2 class="text-3xl md:text-4xl font-black text-white mb-4">Featured Products</h2>
            <p class="text-muted-400 text-lg">Handpicked premium products from top sellers</p>
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

@endsection

