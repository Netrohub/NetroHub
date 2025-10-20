<!-- NXO Product Card Component - Exact Design Specifications -->
<div class="card-hover group">
    <a href="{{ route('products.show', $product->slug) }}" class="block">
        <div class="relative h-48 w-full overflow-hidden rounded-lg mb-4">
            <img 
                src="{{ $product->thumbnail_url }}" 
                alt="{{ $product->title }}" 
                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" 
            />
            <div class="absolute inset-0 bg-gradient-to-t from-background/80 via-transparent to-transparent"></div>
            <div class="absolute bottom-0 left-0 p-4">
                <span class="text-lg font-bold text-primary-foreground">{{ $product->price }} SAR</span>
            </div>
            <div class="absolute top-3 right-3">
                <span class="badge-glow text-xs font-bold px-2.5 py-1 rounded-full text-primary-foreground">
                    {{ $product->category->name }}
                </span>
            </div>
        </div>
        
        <div class="p-4">
            <h3 class="text-lg font-semibold text-foreground group-hover:text-primary transition-colors mb-2">
                {{ $product->title }}
            </h3>
            <p class="text-sm text-muted-foreground mb-3 line-clamp-2">
                {{ $product->description }}
            </p>
            
            <div class="flex items-center justify-between">
                <div class="flex items-center text-sm text-muted-foreground">
                    <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.538 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.783.57-1.838-.197-1.538-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.929 8.72c-.783-.57-.381-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292z"/>
                    </svg>
                    <span>{{ number_format($product->rating_avg, 1) }} ({{ $product->reviews_count }} reviews)</span>
                </div>
                
                <div class="flex items-center gap-2">
                    @if($product->platform)
                        <x-platform-icon :platform="$product->platform" class="w-5 h-5" />
                    @endif
                    @if($product->is_featured)
                        <span class="text-xs font-bold text-accent">Featured</span>
                    @endif
                </div>
            </div>
        </div>
    </a>
</div>