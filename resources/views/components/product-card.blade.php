<!-- NXO Product Card Component - Exact Blueprint Implementation -->
@props([
    'id' => '',
    'name' => '',
    'price' => 0,
    'image' => '',
    'category' => '',
    'rating' => 0,
    'reviews' => 0,
    'featured' => false,
    'description' => ''
])

<div class="glass-card overflow-hidden group">
    <div class="p-0">
        <div class="relative aspect-square overflow-hidden bg-muted/30">
            @if($image)
                <img
                    src="{{ $image }}"
                    alt="{{ $category }}"
                    class="h-full w-full object-cover transition-all duration-500 group-hover:scale-110"
                />
            @else
                <div class="w-full h-full bg-gradient-to-br from-primary/20 to-accent/20 flex items-center justify-center">
                    <svg class="w-16 h-16 text-primary/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            @endif
            
            @if($featured)
                <div class="absolute left-3 top-3">
                    <span class="badge-glow text-xs font-bold px-2.5 py-1 rounded-full text-primary-foreground border-0">
                        ⭐ {{ __('Featured') }}
                    </span>
                </div>
            @endif
            
            <div class="absolute inset-0 bg-gradient-to-t from-background/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        </div>
        
        <div class="p-4 space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs bg-primary/10 text-primary border border-primary/20 hover:bg-primary/20 px-2 py-1 rounded-md">
                    {{ $category }}
                </span>
                <div class="flex items-center gap-1 text-sm">
                    <svg class="h-3.5 w-3.5 fill-primary text-primary" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.538 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.783.57-1.838-.197-1.538-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.929 8.72c-.783-.57-.381-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292z"/>
                    </svg>
                    <span class="font-semibold text-foreground">{{ number_format($rating, 1) }}</span>
                    <span class="text-muted-foreground">({{ $reviews }})</span>
                </div>
            </div>
            
            <h3 class="line-clamp-2 font-semibold text-base group-hover:text-primary transition-colors">{{ $name }}</h3>
            
            @if($description)
                <p class="text-sm text-muted-foreground line-clamp-2">{{ $description }}</p>
            @endif
            
            <div class="flex items-baseline gap-2">
                <p class="text-2xl font-bold bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">
                    {{ number_format($price, 2) }} {{ __('SAR') }}
                </p>
            </div>
        </div>
    </div>
    
    <div class="p-4 pt-0">
        <button class="w-full gap-2 btn-glow flex items-center justify-center px-4 py-2 rounded-lg text-primary-foreground font-semibold transition-all duration-300">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            {{ __('Add to Cart') }}
        </button>
    </div>
</div>