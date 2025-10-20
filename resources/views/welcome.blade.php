<x-layouts.app>
    <x-slot name="title">{{ __('Welcome') }} - {{ config('app.name') }}</x-slot>
    
    <!-- Hero Section -->
    <x-hero />
    
    <!-- Features Section -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-foreground mb-4">
                    {{ __('Why Choose NXO?') }}
                </h2>
                <p class="text-lg text-muted-foreground max-w-2xl mx-auto">
                    {{ __('We provide a secure, reliable platform for buying and selling digital assets.') }}
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="glass-card p-8 text-center">
                    <div class="w-16 h-16 mx-auto mb-6 rounded-full gradient-primary flex items-center justify-center">
                        <svg class="w-8 h-8 text-primary-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-foreground mb-3">{{ __('Secure Transactions') }}</h3>
                    <p class="text-muted-foreground">{{ __('All transactions are protected with advanced encryption and secure payment processing.') }}</p>
                </div>
                
                <div class="glass-card p-8 text-center">
                    <div class="w-16 h-16 mx-auto mb-6 rounded-full gradient-primary flex items-center justify-center">
                        <svg class="w-8 h-8 text-primary-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-foreground mb-3">{{ __('Instant Delivery') }}</h3>
                    <p class="text-muted-foreground">{{ __('Get your digital assets delivered instantly after successful payment.') }}</p>
                </div>
                
                <div class="glass-card p-8 text-center">
                    <div class="w-16 h-16 mx-auto mb-6 rounded-full gradient-primary flex items-center justify-center">
                        <svg class="w-8 h-8 text-primary-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.25a9.75 9.75 0 100 19.5 9.75 9.75 0 000-19.5z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-foreground mb-3">{{ __('24/7 Support') }}</h3>
                    <p class="text-muted-foreground">{{ __('Our support team is available around the clock to help you with any issues.') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="py-20 bg-card/30">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-foreground mb-4">
                    {{ __('Featured Products') }}
                </h2>
                <p class="text-lg text-muted-foreground max-w-2xl mx-auto">
                    {{ __('Discover our most popular gaming accounts and social media profiles.') }}
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @for($i = 0; $i < 8; $i++)
                    <div class="card-hover">
                        <div class="relative h-48 w-full overflow-hidden rounded-lg mb-4">
                            <div class="w-full h-full bg-gradient-to-br from-primary/20 to-accent/20 flex items-center justify-center">
                                <svg class="w-16 h-16 text-primary/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="absolute top-3 right-3">
                                <span class="badge-glow text-xs font-bold px-2.5 py-1 rounded-full text-primary-foreground">
                                    Gaming
                                </span>
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold text-foreground mb-2">Premium Gaming Account</h3>
                        <p class="text-sm text-muted-foreground mb-3 line-clamp-2">High-level gaming account with exclusive items and achievements.</p>
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-bold text-primary">299 SAR</span>
                            <div class="flex items-center text-sm text-muted-foreground">
                                <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.538 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.783.57-1.838-.197-1.538-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.929 8.72c-.783-.57-.381-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292z"/>
                                </svg>
                                <span>4.8 (127)</span>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
            
            <div class="text-center mt-12">
                <a href="{{ route('products.index') }}" class="btn-primary btn-desktop px-8 py-4 rounded-lg text-primary-foreground font-semibold text-lg">
                    {{ __('View All Products') }}
                </a>
            </div>
        </div>
    </section>
    
</x-layouts.app>