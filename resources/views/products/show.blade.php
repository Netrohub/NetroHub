<x-layouts.app>
    <x-slot name="title">{{ $product->title }} - {{ config('app.name') }}</x-slot>

    <!-- Breadcrumb -->
    <section class="relative pt-32 pb-8">
        <div class="max-w-7xl mx-auto px-4">
            <nav class="flex items-center space-x-2 text-sm" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="text-muted-foreground hover:text-foreground transition">{{ __('Home') }}</a>
                <span class="text-muted-foreground">/</span>
                <a href="{{ route('products.index') }}" class="text-muted-foreground hover:text-foreground transition">{{ __('Products') }}</a>
                @if($product->category)
                <span class="text-muted-foreground">/</span>
                <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="text-muted-foreground hover:text-foreground transition">{{ $product->category->name }}</a>
                @endif
                <span class="text-muted-foreground">/</span>
                <span class="text-foreground">{{ $product->title }}</span>
            </nav>
        </div>
    </section>

    <!-- Product Details -->
    <section class="relative pb-20">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid lg:grid-cols-2 gap-8 lg:gap-12">
                
                <!-- Left Column - Product Image (4:3 aspect ratio) -->
                <div>
                    <div class="sticky top-24">
                        <div class="card-hover aspect-product flex items-center justify-center mb-6">
                            @if($product->thumbnail_url ?? false)
                                <img src="{{ $product->thumbnail_url }}" alt="{{ $product->title }}" class="w-full h-full object-cover rounded-xl" loading="lazy" width="600" height="450">
                            @else
                                <div class="w-48 h-48 lg:w-64 lg:h-64 bg-muted rounded-3xl flex items-center justify-center">
                                    <x-platform-icon :product="$product" size="3xl" />
                                </div>
                            @endif
                        </div>
                        
                        <!-- Stock Badge -->
                        @if($product->stock > 0 || !isset($product->stock))
                            <div class="inline-flex items-center px-4 py-2 bg-green-500/20 border border-green-500/50 text-green-300 rounded-xl text-sm font-medium">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                {{ __('In Stock') }}
                            </div>
                        @else
                            <div class="inline-flex items-center px-4 py-2 bg-red-500/20 border border-red-500/50 text-red-300 rounded-xl text-sm font-medium">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                {{ __('Out of Stock') }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Column - Product Details -->
                <div>
                    <div class="space-y-6">
                        <!-- Product Title -->
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold text-foreground mb-2">{{ $product->title }}</h1>
                            @if($product->category)
                                <div class="flex items-center gap-2">
                                    <span class="badge-glow text-xs font-bold px-2.5 py-1 rounded-full text-primary-foreground">
                                        {{ $product->category->name }}
                                    </span>
                                    @if($product->platform)
                                        <x-platform-icon :platform="$product->platform" class="w-5 h-5" />
                                    @endif
                                </div>
                            @endif
                        </div>

                        <!-- Price -->
                        <div class="flex items-center gap-4">
                            <span class="text-4xl font-bold text-primary">{{ number_format($product->price, 2) }} SAR</span>
                            @if($product->rating_avg > 0)
                                <div class="flex items-center gap-2">
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-5 h-5 {{ $i <= $product->rating_avg ? 'text-yellow-400' : 'text-muted-foreground' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.538 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.783.57-1.838-.197-1.538-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.929 8.72c-.783-.57-.381-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="text-muted-foreground">({{ $product->reviews_count }} {{ __('reviews') }})</span>
                                </div>
                            @endif
                        </div>

                        <!-- Description -->
                        <div>
                            <h3 class="text-lg font-semibold text-foreground mb-3">{{ __('Description') }}</h3>
                            <p class="text-muted-foreground leading-relaxed">{{ $product->description }}</p>
                        </div>

                        <!-- Features -->
                        @if($product->features)
                            <div>
                                <h3 class="text-lg font-semibold text-foreground mb-3">{{ __('Features') }}</h3>
                                <ul class="space-y-2">
                                    @foreach(json_decode($product->features, true) ?? [] as $feature)
                                        <li class="flex items-center gap-2 text-muted-foreground">
                                            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $feature }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Seller Info -->
                        <div class="card-hover p-6">
                            <h3 class="text-lg font-semibold text-foreground mb-4">{{ __('Seller Information') }}</h3>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-muted rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-foreground">{{ $product->seller->name ?? 'Unknown Seller' }}</div>
                                    <div class="text-sm text-muted-foreground">{{ __('Verified Seller') }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Add to Cart Button -->
                        <div class="space-y-4">
                            @if($product->stock > 0 || !isset($product->stock))
                                <form action="{{ route('cart.add', $product) }}" method="POST" class="space-y-4">
                                    @csrf
                                    <button type="submit" class="btn-primary w-full">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        {{ __('Add to Cart') }}
                                    </button>
                                </form>
                            @else
                                <button disabled class="btn-secondary w-full opacity-50 cursor-not-allowed">
                                    {{ __('Out of Stock') }}
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Reviews Section -->
    @if($product->reviews_count > 0)
        <section class="py-20 bg-card/30">
            <div class="max-w-7xl mx-auto px-4">
                <h2 class="text-3xl font-bold text-foreground mb-8">{{ __('Customer Reviews') }}</h2>
                
                <div class="grid gap-6">
                    @foreach($product->reviews ?? [] as $review)
                        <div class="card-hover p-6">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-muted rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="font-semibold text-foreground">{{ $review->user->name ?? 'Anonymous' }}</span>
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-muted-foreground' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.538 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.783.57-1.838-.197-1.538-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.929 8.72c-.783-.57-.381-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                        <span class="text-sm text-muted-foreground">{{ $review->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <p class="text-muted-foreground">{{ $review->comment }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</x-layouts.app>