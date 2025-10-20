@props(['product'])

<div class="group card-hover rounded-2xl overflow-hidden bg-card border border-border/50">
    <a href="{{ route('products.show', $product->slug) }}" class="block">
        <!-- Product Image -->
        <div class="aspect-[4/3] bg-gradient-to-br from-primary/20 to-accent/20 relative overflow-hidden">
            @if($product->thumbnail_url)
                <img src="{{ $product->thumbnail_url }}" 
                     alt="{{ $product->title }}" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                     loading="lazy"
                     width="400"
                     height="300">
            @else
                <div class="w-full h-full flex items-center justify-center">
                    <div class="w-16 h-16 rounded-2xl gradient-primary flex items-center justify-center">
                        <svg class="w-8 h-8 text-primary-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                </div>
            @endif
            
            <!-- Badges -->
            <div class="absolute top-3 left-3 flex flex-col gap-2">
                @if($product->is_featured)
                    <span class="badge-glow px-3 py-1 rounded-full text-xs font-semibold text-primary-foreground">
                        {{ __('Featured') }}
                    </span>
                @endif
                @if($product->type === 'game_account')
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-500/20 text-green-400 border border-green-500/30">
                        {{ __('Gaming') }}
                    </span>
                @elseif($product->type === 'social_account')
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-500/20 text-blue-400 border border-blue-500/30">
                        {{ __('Social') }}
                    </span>
                @else
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-purple-500/20 text-purple-400 border border-purple-500/30">
                        {{ __('Digital') }}
                    </span>
                @endif
            </div>
            
            <!-- Price Badge -->
            <div class="absolute top-3 right-3">
                <span class="px-3 py-1 rounded-full text-sm font-bold bg-card/90 backdrop-blur-sm text-foreground border border-border/50">
                    ${{ number_format($product->price, 2) }}
                </span>
            </div>
        </div>
        
        <!-- Product Info -->
        <div class="p-6">
            <!-- Title -->
            <h3 class="text-lg font-bold text-foreground mb-2 line-clamp-2 group-hover:text-primary transition-colors">
                {{ $product->title }}
            </h3>
            
            <!-- Description -->
            <p class="text-muted-foreground text-sm mb-4 line-clamp-2">
                {{ Str::limit($product->description, 100) }}
            </p>
            
            <!-- Platform/Game Info -->
            @if($product->platform || $product->game_title)
                <div class="flex items-center gap-2 mb-4">
                    @if($product->platform)
                        <span class="px-2 py-1 rounded-md text-xs font-medium bg-muted text-muted-foreground">
                            {{ $product->platform }}
                        </span>
                    @endif
                    @if($product->game_title)
                        <span class="px-2 py-1 rounded-md text-xs font-medium bg-muted text-muted-foreground">
                            {{ $product->game_title }}
                        </span>
                    @endif
                </div>
            @endif
            
            <!-- Seller Info -->
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded-full bg-gradient-primary flex items-center justify-center">
                        <span class="text-xs font-bold text-primary-foreground">
                            {{ strtoupper(substr($product->seller->user->name ?? 'S', 0, 1)) }}
                        </span>
                    </div>
                    <span class="text-sm text-muted-foreground">
                        {{ $product->seller->user->name ?? 'Unknown Seller' }}
                    </span>
                </div>
                
                <!-- Rating -->
                @if($product->rating_avg > 0)
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <span class="text-sm text-muted-foreground">{{ number_format($product->rating_avg, 1) }}</span>
                    </div>
                @endif
            </div>
            
            <!-- Stats -->
            <div class="flex items-center justify-between text-sm text-muted-foreground">
                <div class="flex items-center gap-4">
                    @if($product->sales_count > 0)
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                            {{ $product->sales_count }} {{ __('sold') }}
                        </span>
                    @endif
                    @if($product->views_count > 0)
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            {{ $product->views_count }}
                        </span>
                    @endif
                </div>
                
                <!-- Stock Status -->
                @if($product->stock_count > 0)
                    <span class="text-green-400 font-medium">
                        {{ $product->stock_count }} {{ __('in stock') }}
                    </span>
                @else
                    <span class="text-red-400 font-medium">
                        {{ __('Out of stock') }}
                    </span>
                @endif
            </div>
        </div>
    </a>
</div>
