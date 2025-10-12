@props(['product'])

<div class="card card-hover overflow-hidden h-full flex flex-col group scroll-fade-in">
    <a href="{{ route('products.show', $product->slug) }}" class="block flex-1 flex flex-col">
        <!-- Product Image -->
        <div class="aspect-video bg-gaming-gradient rounded-xl overflow-hidden mb-4 img-hover-zoom relative">
            @if($product->thumbnail_url)
                <img src="{{ $product->thumbnail_url }}" 
                     alt="{{ $product->title }}" 
                     class="w-full h-full object-cover"
                     loading="lazy">
            @else
                <div class="w-full h-full flex items-center justify-center text-white text-5xl font-black">
                    {{ substr($product->title, 0, 1) }}
                </div>
            @endif
            
            <!-- Badges -->
            <div class="absolute top-3 left-3 flex flex-col gap-2">
                {{-- New Badge --}}
                @if($product->created_at->diffInDays() <= 7)
                    <span class="badge-primary animate-pulse">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd"/>
                        </svg>
                        NEW
                    </span>
                @endif
                
                {{-- Trending Badge --}}
                @if(($product->sales_count ?? 0) > 50)
                    <span class="badge-warning">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"/>
                        </svg>
                        TRENDING
                    </span>
                @endif
                
                {{-- Top Rated Badge --}}
                @if(($product->rating ?? 0) >= 4.5)
                    <span class="badge-success">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                        TOP RATED
                    </span>
                @endif
            </div>
            
            <!-- Stock Badge -->
            <div class="absolute top-3 right-3">
                @if($product->isInStock())
                    <span class="badge-success shadow-lg">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        In Stock
                    </span>
                @else
                    <span class="badge-danger shadow-lg">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        Sold Out
                    </span>
                @endif
            </div>
        </div>

        <!-- Product Info -->
        <div class="p-4 flex-1 flex flex-col">
            <!-- Platform Badge -->
            @if($product->metadata['platform'] ?? false)
                <div class="flex items-center gap-2 mb-3">
                    <div class="flex items-center gap-1.5 px-3 py-1 bg-dark-800/50 border border-gaming rounded-full">
                        <x-platform-icon :product="$product" size="xs" />
                        <span class="text-xs text-muted-300 font-medium">{{ $product->metadata['platform'] }}</span>
                    </div>
                </div>
            @endif

            <!-- Title -->
            <h3 class="text-lg font-bold text-white mb-2 line-clamp-2 group-hover:text-primary-400 transition-colors">
                {{ $product->title }}
            </h3>
            
            <!-- Description -->
            <p class="text-sm text-muted-300 line-clamp-2 leading-relaxed mb-4 flex-1">
                {{ $product->description }}
            </p>

            <!-- Meta Info -->
            <div class="flex items-center gap-3 text-xs text-muted-400 mb-4">
                {{-- Rating --}}
                @if($product->rating)
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                        <span class="font-medium text-white">{{ number_format($product->rating, 1) }}</span>
                    </div>
                @endif
                
                {{-- Sales --}}
                @if($product->sales_count)
                    <span class="flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                        </svg>
                        {{ number_format($product->sales_count) }} sales
                    </span>
                @endif
                
                {{-- Seller --}}
                <span class="flex items-center gap-1">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                    {{ Str::limit($product->seller->display_name ?? $product->seller->user->name, 15) }}
                </span>
            </div>

            <!-- Price & CTA -->
            <div class="flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="text-2xl font-black text-gradient">
                        ${{ number_format($product->price, 2) }}
                    </span>
                    @if($product->original_price && $product->original_price > $product->price)
                        <span class="text-sm text-muted-500 line-through">
                            ${{ number_format($product->original_price, 2) }}
                        </span>
                    @endif
                </div>
                <button class="btn-primary btn-sm group-hover:scale-110 transition-transform">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    View
                </button>
            </div>
        </div>
    </a>
    
    <!-- Quick Actions (on hover) -->
    <div class="p-4 pt-0 opacity-0 group-hover:opacity-100 transition-opacity">
        <div class="flex gap-2">
            @auth
                <button onclick="addToWishlist({{ $product->id }})" 
                        class="flex-1 btn-ghost btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </button>
                <button onclick="shareProduct({{ $product->id }})" 
                        class="flex-1 btn-ghost btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                    </svg>
                </button>
            @endauth
        </div>
    </div>
</div>

