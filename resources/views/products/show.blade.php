@extends('layouts.app')

@section('meta_title', $product->title . ' - ' . config('app.name', 'NetroHub'))
@section('meta_description', $product->description ? Str::limit(strip_tags($product->description), 160) : 'Buy ' . $product->title . ' on NetroHub - the ultimate gaming marketplace.')
@section('meta_keywords', $product->title . ', gaming, digital goods, ' . ($product->category ? $product->category->name : '') . ', marketplace')

@section('og_title', $product->title)
@section('og_description', $product->description ? Str::limit(strip_tags($product->description), 160) : 'Buy ' . $product->title . ' on NetroHub')
@section('og_type', 'product')
@section('og_image', $product->thumbnail_url ?: asset('img/netrohub-og.png'))

@section('twitter_title', $product->title)
@section('twitter_description', $product->description ? Str::limit(strip_tags($product->description), 160) : 'Buy ' . $product->title . ' on NetroHub')
@section('twitter_image', $product->thumbnail_url ?: asset('img/netrohub-og.png'))

@section('content')
<div class="min-h-screen relative overflow-hidden bg-dark-900 py-8">
    <!-- Gaming Background Effects -->
    <div class="absolute inset-0">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary-500/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-secondary-500/10 rounded-full blur-3xl animate-float animation-delay-2000"></div>
        <div class="absolute top-3/4 left-1/3 w-64 h-64 bg-neon-blue/5 rounded-full blur-3xl animate-float animation-delay-4000"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Gaming Breadcrumb -->
        <nav class="mb-8 animate-fade-in">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="{{ route('home') }}" class="text-muted-400 hover:text-primary-400 transition-colors">🏠 Home</a></li>
                <li class="text-muted-500">/</li>
                <li><a href="{{ route('products.index') }}" class="text-muted-400 hover:text-primary-400 transition-colors">🎮 Products</a></li>
                <li class="text-muted-500">/</li>
                <li><a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="text-muted-400 hover:text-primary-400 transition-colors">{{ $product->category->name }}</a></li>
                <li class="text-muted-500">/</li>
                <li class="text-white font-medium">{{ $product->title }}</li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Gaming Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Gaming Product Header -->
                <x-ui.card variant="glass" class="animate-fade-in animation-delay-200">
                    <!-- Gaming Thumbnail -->
                    <div class="aspect-video bg-gaming-gradient rounded-3xl relative overflow-hidden mb-8">
                        @if($product->thumbnail_url)
                            <img src="{{ asset('storage/' . $product->thumbnail_url) }}" alt="{{ $product->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-white text-8xl font-black">
                                {{ substr($product->title, 0, 1) }}
                            </div>
                        @endif
                        
                        <!-- Gaming Badge -->
                        <div class="absolute top-4 left-4">
                            @if($product->isInStock())
                                <x-ui.badge class="bg-green-500/90 text-white shadow-lg">
                                    ✅ In Stock
                                </x-ui.badge>
                            @else
                                <x-ui.badge class="bg-red-500/90 text-white shadow-lg">
                                    ❌ Sold Out
                                </x-ui.badge>
                            @endif
                        </div>
                    </div>

                    <div class="space-y-6">
                        <!-- Platform Badge -->
                        @if($product->metadata['platform'] ?? false)
                        <div class="flex items-center gap-2">
                            <div class="inline-flex items-center gap-2 px-4 py-2 bg-dark-800/50 border border-gaming rounded-2xl">
                                <x-platform-icon :product="$product" size="sm" />
                                <span class="text-sm text-white font-semibold">{{ $product->metadata['platform'] }}</span>
                            </div>
                        </div>
                        @endif

                        <h1 class="text-4xl font-black text-white mb-6 bg-gaming-gradient bg-clip-text text-transparent">
                            {{ $product->title }}
                        </h1>
                        
                        <!-- Gaming Meta -->
                        <div class="flex flex-wrap items-center gap-6 text-sm">
                            <div class="flex items-center text-muted-300">
                                <svg class="w-5 h-5 mr-2 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span class="font-medium">{{ $product->seller->user->name }}</span>
                            </div>
                            
                            @if($product->rating)
                            <div class="flex items-center text-yellow-400">
                                <svg class="w-5 h-5 mr-2 fill-current" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                                <span class="text-white font-bold">{{ number_format($product->rating, 1) }}</span>
                                <span class="text-muted-400 ml-1">({{ $product->reviews_count }} reviews)</span>
                            </div>
                            @endif
                            
                            <div class="flex items-center text-green-400">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                                <span class="font-bold">{{ $product->sales_count }} sales</span>
                            </div>
                        </div>

                        <!-- Gaming Description -->
                        <div class="space-y-4">
                            <h3 class="text-2xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-3 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Description
                            </h3>
                            <div class="bg-dark-800/50 border border-gaming rounded-2xl p-6">
                                <p class="text-muted-300 whitespace-pre-line leading-relaxed">{{ $product->description }}</p>
                            </div>
                        </div>

                        <!-- Account Details (Metadata) -->
                        @if($product->metadata && ($product->type === 'social_account' || $product->type === 'game_account'))
                        <div class="space-y-4">
                            <h3 class="text-2xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-3 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Account Details
                            </h3>
                            <div class="bg-dark-800/50 border border-gaming rounded-2xl p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Automatic Delivery -->
                                    <div class="flex items-center justify-between p-4 bg-green-500/5 border border-green-500/20 rounded-xl">
                                        <span class="text-muted-300 text-sm">Automatic delivery?</span>
                                        <span class="px-3 py-1 bg-green-500/20 text-green-400 rounded-lg text-sm font-semibold">
                                            {{ ($product->metadata['automatic_delivery'] ?? false) ? 'Yes' : 'No' }}
                                        </span>
                                    </div>

                                    <!-- KYC Verified -->
                                    <div class="flex items-center justify-between p-4 bg-green-500/5 border border-green-500/20 rounded-xl">
                                        <span class="text-muted-300 text-sm">Product owner verified with an ID?</span>
                                        <span class="px-3 py-1 bg-green-500/20 text-green-400 rounded-lg text-sm font-semibold">
                                            {{ ($product->metadata['kyc_verified'] ?? false) ? 'Yes' : 'No' }}
                                        </span>
                                    </div>

                                    @if($product->type === 'social_account')
                                        <!-- With Primary Email -->
                                        <div class="flex items-center justify-between p-4 bg-dark-700/30 border border-gaming rounded-xl">
                                            <span class="text-muted-300 text-sm">With primary email?</span>
                                            <span class="px-3 py-1 {{ ($product->metadata['with_primary_email'] ?? false) ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }} rounded-lg text-sm font-semibold">
                                                {{ ($product->metadata['with_primary_email'] ?? false) ? 'Yes' : 'No' }}
                                            </span>
                                        </div>

                                        <!-- With Current Email -->
                                        <div class="flex items-center justify-between p-4 bg-dark-700/30 border border-gaming rounded-xl">
                                            <span class="text-muted-300 text-sm">With current email?</span>
                                            <span class="px-3 py-1 {{ ($product->metadata['with_current_email'] ?? false) ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }} rounded-lg text-sm font-semibold">
                                                {{ ($product->metadata['with_current_email'] ?? false) ? 'Yes' : 'No' }}
                                            </span>
                                        </div>

                                        <!-- Linked to Number -->
                                        <div class="flex items-center justify-between p-4 bg-dark-700/30 border border-gaming rounded-xl">
                                            <span class="text-muted-300 text-sm">Linked to a number?</span>
                                            <span class="px-3 py-1 {{ ($product->metadata['linked_to_number'] ?? false) ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }} rounded-lg text-sm font-semibold">
                                                {{ ($product->metadata['linked_to_number'] ?? false) ? 'Yes' : 'No' }}
                                            </span>
                                        </div>
                                    @endif

                                    @if($product->type === 'game_account' && $product->game_title === 'Whiteout Survival')
                                        <!-- With Primary Email -->
                                        <div class="flex items-center justify-between p-4 bg-dark-700/30 border border-gaming rounded-xl">
                                            <span class="text-muted-300 text-sm">With primary email?</span>
                                            <span class="px-3 py-1 {{ ($product->metadata['with_primary_email'] ?? false) ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }} rounded-lg text-sm font-semibold">
                                                {{ ($product->metadata['with_primary_email'] ?? false) ? 'Yes' : 'No' }}
                                            </span>
                                        </div>

                                        <!-- Linked to Facebook -->
                                        <div class="flex items-center justify-between p-4 bg-dark-700/30 border border-gaming rounded-xl">
                                            <span class="text-muted-300 text-sm">Linked to Facebook?</span>
                                            <span class="px-3 py-1 {{ ($product->metadata['linked_to_facebook'] ?? false) ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }} rounded-lg text-sm font-semibold">
                                                {{ ($product->metadata['linked_to_facebook'] ?? false) ? 'Yes' : 'No' }}
                                            </span>
                                        </div>

                                        <!-- Linked to Google -->
                                        <div class="flex items-center justify-between p-4 bg-dark-700/30 border border-gaming rounded-xl">
                                            <span class="text-muted-300 text-sm">Linked to Google account?</span>
                                            <span class="px-3 py-1 {{ ($product->metadata['linked_to_google'] ?? false) ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }} rounded-lg text-sm font-semibold">
                                                {{ ($product->metadata['linked_to_google'] ?? false) ? 'Yes' : 'No' }}
                                            </span>
                                        </div>

                                        <!-- Linked to Apple ID -->
                                        <div class="flex items-center justify-between p-4 bg-dark-700/30 border border-gaming rounded-xl">
                                            <span class="text-muted-300 text-sm">Linked to Apple ID?</span>
                                            <span class="px-3 py-1 {{ ($product->metadata['linked_to_apple'] ?? false) ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }} rounded-lg text-sm font-semibold">
                                                {{ ($product->metadata['linked_to_apple'] ?? false) ? 'Yes' : 'No' }}
                                            </span>
                                        </div>

                                        <!-- Linked to Game Center -->
                                        <div class="flex items-center justify-between p-4 bg-dark-700/30 border border-gaming rounded-xl">
                                            <span class="text-muted-300 text-sm">Linked to Game Center?</span>
                                            <span class="px-3 py-1 {{ ($product->metadata['linked_to_game_center'] ?? false) ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }} rounded-lg text-sm font-semibold">
                                                {{ ($product->metadata['linked_to_game_center'] ?? false) ? 'Yes' : 'No' }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Gallery Images (for Whiteout Survival) -->
                        @if($product->gallery_urls && count($product->gallery_urls) > 0 && $product->type === 'game_account' && $product->game_title === 'Whiteout Survival')
                        <div class="space-y-4">
                            <h3 class="text-2xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-3 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Account Screenshots
                            </h3>
                            <div class="bg-dark-800/50 border border-gaming rounded-2xl p-6">
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                    @foreach($product->gallery_urls as $imageUrl)
                                        <a href="{{ asset('storage/' . $imageUrl) }}" target="_blank" class="group relative aspect-video rounded-xl overflow-hidden border border-gaming hover:border-primary-500 transition-all">
                                            <img src="{{ asset('storage/' . $imageUrl) }}" alt="Account screenshot" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-colors flex items-center justify-center">
                                                <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                                </svg>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                                <p class="text-xs text-muted-400 mt-4">Click images to view full size</p>
                            </div>
                        </div>
                        @endif

                        <!-- Gaming Features -->
                        @if($product->features && count($product->features) > 0)
                        <div class="space-y-4">
                            <h3 class="text-2xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-3 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Features
                            </h3>
                            <div class="bg-dark-800/50 border border-gaming rounded-2xl p-6">
                                <ul class="space-y-3">
                                    @foreach($product->features as $feature)
                                    <li class="flex items-start">
                                        <svg class="w-5 h-5 text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-muted-300">{{ $feature }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif

                        <!-- Gaming Tags -->
                        @if($product->tags && count($product->tags) > 0)
                        <div class="space-y-4">
                            <h3 class="text-2xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-3 text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                Tags
                            </h3>
                            <div class="flex flex-wrap gap-3">
                                @foreach($product->tags as $tag)
                                <x-ui.badge class="bg-dark-800/50 text-muted-300 border border-gaming hover:bg-primary-500/20 hover:text-primary-400 hover:border-primary-500 transition-all">
                                    {{ $tag }}
                                </x-ui.badge>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </x-ui.card>

                <!-- Reviews Section -->
                <div class="space-y-8 animate-fade-in animation-delay-400">
                    <!-- Reviews Summary -->
                    @if($product->rating_count > 0)
                        <x-review-summary :product="$product" />
                    @endif


                    <!-- Reviews List -->
                    @php
                        $reviews = $product->reviews()
                            ->where('reviewable_type', App\Models\Product::class)
                            ->where('status', 'approved')
                            ->with(['user', 'repliedBy'])
                            ->latest()
                            ->paginate(10);
                        $canReply = $product->seller_id === auth()->user()?->seller?->id || auth()->user()?->hasRole(['admin', 'staff']);
                    @endphp

                    @if ($reviews->count() > 0)
                        <div>
                            <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                                <svg class="w-6 h-6 mr-3 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                                Customer Reviews ({{ $reviews->total() }})
                            </h2>

                            <div class="space-y-4">
                                @foreach ($reviews as $review)
                                    <x-review-card :review="$review" :canReply="$canReply" />
                                @endforeach
                            </div>

                            <!-- Pagination -->
                            @if ($reviews->hasPages())
                                <div class="mt-8">
                                    {{ $reviews->links() }}
                                </div>
                            @endif
                        </div>
                    @else
                        <x-ui.card variant="glass">
                            <div class="text-center py-12">
                                <div class="inline-flex items-center justify-center w-16 h-16 bg-muted-600/20 rounded-3xl mb-6">
                                    <svg class="w-8 h-8 text-muted-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-white mb-2">No Reviews Yet</h3>
                                <p class="text-muted-400">Be the first to review this product!</p>
                            </div>
                        </x-ui.card>
                    @endif
                </div>

                <!-- Gaming Related Products -->
                @if($relatedProducts->count() > 0)
                <div class="animate-fade-in animation-delay-600">
                    <h2 class="text-3xl font-bold text-white mb-8 flex items-center">
                        <svg class="w-8 h-8 mr-3 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        Related Products
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        @foreach($relatedProducts as $related)
                        <a href="{{ route('products.show', $related->slug) }}" class="group">
                            <x-ui.card variant="glass" hover="true" class="h-full">
                                <div class="aspect-video bg-gaming-gradient rounded-2xl relative overflow-hidden mb-4">
                                    @if($related->thumbnail_url)
                                        <img src="{{ asset('storage/' . $related->thumbnail_url) }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @endif
                                </div>
                                <div class="space-y-3">
                                    <h3 class="text-lg font-bold text-white line-clamp-2 group-hover:text-primary-400 transition-colors">{{ $related->title }}</h3>
                                    <div class="flex items-center justify-between">
                                        <span class="text-2xl font-bold text-white">${{ number_format($related->price, 2) }}</span>
                                        @if($related->rating)
                                            <div class="flex items-center text-yellow-400">
                                                <svg class="w-4 h-4 mr-1 fill-current" viewBox="0 0 20 20">
                                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                </svg>
                                                <span class="text-sm text-white font-medium">{{ number_format($related->rating, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </x-ui.card>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Gaming Sidebar -->
            <div class="lg:col-span-1">
                <div class="sticky top-8 space-y-6">
                    <!-- Gaming Purchase Card -->
                    <x-ui.card variant="glass" class="animate-fade-in animation-delay-300">
                        <div class="space-y-6">
                            <div class="text-center">
                                <div class="text-4xl font-black text-white mb-2">${{ number_format($product->price, 2) }}</div>
                                @if($product->isInStock())
                                    <x-ui.badge class="bg-green-500/90 text-white shadow-lg">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        In Stock
                                    </x-ui.badge>
                                @else
                                    <x-ui.badge class="bg-red-500/90 text-white shadow-lg">
                                        ❌ Out of Stock
                                    </x-ui.badge>
                                @endif
                            </div>

                            @if($product->isInStock())
                                <form action="{{ route('cart.add', $product) }}" method="POST" class="space-y-4">
                                    @csrf
                                    <x-ui.button 
                                        type="submit" 
                                        variant="primary" 
                                        size="lg" 
                                        glow="true"
                                        class="w-full justify-center text-lg py-4"
                                    >
                                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 11-4 0v-6m4 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01" />
                                        </svg>
                                        Add to Cart
                                    </x-ui.button>
                                </form>
                            @else
                                <x-ui.button 
                                    variant="secondary" 
                                    size="lg"
                                    disabled
                                    class="w-full justify-center text-lg py-4 cursor-not-allowed opacity-50"
                                >
                                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Sold Out
                                </x-ui.button>
                            @endif

                            <!-- Gaming Product Info -->
                            <div class="space-y-4 pt-6 border-t border-gaming">
                                <div class="flex items-center justify-between">
                                    <span class="text-muted-400">Category</span>
                                    <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="flex items-center gap-1.5 text-primary-400 hover:text-primary-300 font-medium transition-colors">
                                        <x-platform-icon :category="$product->category->name" size="xs" />
                                        {{ $product->category->name }}
                                    </a>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-muted-400">Delivery</span>
                                    <span class="text-white font-medium capitalize">{{ $product->delivery_type }}</span>
                                </div>
                                @if($product->stock_count)
                                <div class="flex items-center justify-between">
                                    <span class="text-muted-400">Available</span>
                                    <span class="text-white font-medium">{{ $product->stock_count }} units</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </x-ui.card>

                    <!-- Gaming Seller Info -->
                    <x-ui.card variant="glass" class="animate-fade-in animation-delay-400">
                        <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Seller
                        </h3>
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-gaming-gradient rounded-3xl flex items-center justify-center text-white font-black text-xl shadow-gaming-lg">
                                {{ substr($product->seller->user->name, 0, 1) }}
                            </div>
                            <div class="flex-1">
                                <div class="font-bold text-white text-lg">{{ $product->seller->user->name }}</div>
                                <div class="text-muted-400">{{ $product->seller->products_count }} products</div>
                            </div>
                        </div>
                    </x-ui.card>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

@keyframes fade-in {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

.animate-fade-in {
    animation: fade-in 0.8s ease-out forwards;
}

.animation-delay-200 {
    animation-delay: 0.2s;
}

.animation-delay-300 {
    animation-delay: 0.3s;
}

.animation-delay-400 {
    animation-delay: 0.4s;
}

.animation-delay-600 {
    animation-delay: 0.6s;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection