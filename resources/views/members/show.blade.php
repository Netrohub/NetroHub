@extends('layouts.app')

@section('meta_title', ($user->seller->display_name ?? $user->name) . ' - ' . config('app.name', 'NetroHub'))
@section('meta_description', $user->seller->bio ? Str::limit($user->seller->bio, 160) : 'View ' . ($user->seller->display_name ?? $user->name) . '\'s profile on NetroHub - the ultimate gaming marketplace.')
@section('meta_keywords', $user->seller->display_name ?? $user->name . ', gaming, seller, profile, marketplace')

@section('og_title', $user->seller->display_name ?? $user->name)
@section('og_description', $user->seller->bio ? Str::limit($user->seller->bio, 160) : 'View ' . ($user->seller->display_name ?? $user->name) . '\'s profile on NetroHub')
@section('og_type', 'profile')
@section('og_image', $user->getAvatarUrlAttribute(null))

@section('twitter_title', $user->seller->display_name ?? $user->name)
@section('twitter_description', $user->seller->bio ? Str::limit($user->seller->bio, 160) : 'View ' . ($user->seller->display_name ?? $user->name) . '\'s profile on NetroHub')
@section('twitter_image', $user->getAvatarUrlAttribute(null))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('members.index') }}" class="inline-flex items-center text-muted-400 hover:text-white transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Members
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Sidebar - Profile Card -->
        <div class="lg:col-span-1">
            <x-ui.card variant="glass" class="text-center" :hover="false">
                <!-- Avatar with verification badges -->
                <div class="relative inline-block mb-6">
                    <div class="w-32 h-32 mx-auto rounded-2xl overflow-hidden bg-gaming-gradient shadow-lg">
                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                    </div>
                    
                    <!-- Verification badges -->
                    @if($user->seller && $user->seller->total_sales > 0)
                        <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-neon-green rounded-full border-4 border-dark-800 flex items-center justify-center shadow-lg" title="Verified Seller">
                            <svg class="w-6 h-6 text-dark-900" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    @elseif($user->email_verified_at)
                        <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-neon-blue rounded-full border-4 border-dark-800 flex items-center justify-center shadow-lg" title="Email Verified">
                            <svg class="w-6 h-6 text-dark-900" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    @endif
                </div>
                
                <!-- Name and handle -->
                <h1 class="text-2xl font-bold text-white mb-2">
                    {{ $user->seller->display_name ?? $user->name }}
                </h1>
                <p class="text-sm text-muted-400 mb-6">@{{ Str::slug($user->seller->display_name ?? $user->name) }}</p>
                
                <!-- Bio -->
                @if($user->seller && $user->seller->bio)
                    <div class="mb-6">
                        <p class="text-sm text-muted-300 leading-relaxed">{{ $user->seller->bio }}</p>
                    </div>
                @else
                    <div class="mb-6">
                        <p class="text-sm text-muted-400 italic">
                            @if($user->seller)
                                No bio yet
                            @else
                                Platform Member
                            @endif
                        </p>
                    </div>
                @endif
                
                <!-- Stats -->
                <div class="grid grid-cols-3 gap-4 mb-6">
                    <div class="bg-dark-800/50 border border-gaming rounded-lg p-3">
                        <div class="text-lg font-bold text-white">{{ $user->seller->total_sales ?? 0 }}</div>
                        <div class="text-xs text-muted-400">Sales</div>
                    </div>
                    <div class="bg-dark-800/50 border border-gaming rounded-lg p-3">
                        <div class="text-lg font-bold text-white">{{ $user->seller->products->count() ?? 0 }}</div>
                        <div class="text-xs text-muted-400">Listings</div>
                    </div>
                    <div class="bg-dark-800/50 border border-gaming rounded-lg p-3">
                        <div class="text-lg font-bold text-white">{{ $user->created_at->format('Y') }}</div>
                        <div class="text-xs text-muted-400">Joined</div>
                    </div>
                </div>
                
                <!-- Seller badge -->
                @if($user->seller)
                    <div class="mb-6">
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-neon-green/20 text-neon-green border border-neon-green/30">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                            </svg>
                            Verified Seller
                        </span>
                    </div>
                @endif
                
                <!-- Member since -->
                <div class="text-xs text-muted-400">
                    Member since {{ $user->created_at->format('F Y') }}
                </div>
            </x-ui.card>
        </div>

        <!-- Right Content -->
        <div class="lg:col-span-2">
            @if($user->seller && $user->seller->products->count() > 0)
                <!-- Products Section -->
                <x-ui.card variant="glass">
                    <div class="mb-6">
                        <h2 class="text-xl font-bold text-white">Products</h2>
                        <p class="text-sm text-muted-400">{{ $user->seller->products->count() }} products available</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($user->seller->products as $product)
                            <div class="bg-dark-800/50 border border-gaming rounded-xl p-4 hover:bg-dark-800/70 transition-colors">
                                <div class="flex items-start gap-4">
                                    <div class="w-16 h-16 rounded-lg overflow-hidden bg-dark-700 flex-shrink-0">
                                        @if($product->thumbnail_url)
                                            <img src="{{ $product->thumbnail_url }}" alt="{{ $product->title }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <x-platform-icon :product="$product" size="sm" />
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-semibold text-white line-clamp-2 mb-1">{{ $product->title }}</h3>
                                        @if($product->metadata['platform'] ?? false)
                                            <div class="flex items-center gap-1 text-xs text-muted-400 mb-2">
                                                <x-platform-icon :product="$product" size="xs" />
                                                <span>{{ $product->metadata['platform'] }}</span>
                                            </div>
                                        @endif
                                        <div class="flex items-center justify-between">
                                            <span class="text-lg font-bold text-primary-400">${{ number_format($product->price, 2) }}</span>
                                            <a href="{{ route('products.show', $product->slug) }}" class="text-primary-400 hover:text-primary-300 text-sm font-medium">
                                                View →
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-ui.card>
            @else
                <!-- No Products -->
                <x-ui.card variant="glass" class="text-center py-16">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-muted-500/20 rounded-full mb-6">
                        <svg class="w-8 h-8 text-muted-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">
                        @if($user->seller)
                            No Products Yet
                        @else
                            Not a Seller
                        @endif
                    </h3>
                    <p class="text-muted-400">
                        @if($user->seller)
                            This seller hasn't listed any products yet. Check back later!
                        @else
                            This member is not currently selling any products.
                        @endif
                    </p>
                </x-ui.card>
            @endif
        </div>
    </div>
</div>
@endsection
