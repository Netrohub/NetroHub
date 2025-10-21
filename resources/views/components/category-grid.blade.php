<!-- NXO Category Grid Component - Exact Blueprint Implementation -->
<section class="py-16 relative">
    <div class="max-w-7xl mx-auto px-4">
        <div class="mb-12 text-center space-y-3">
            <h2 class="text-4xl font-black bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">
                {{ __('Browse by Platform') }}
            </h2>
            <p class="text-foreground/60 text-lg">{{ __('Choose your preferred platform to explore') }}</p>
        </div>
        
        <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-6">
            <!-- Gaming Platforms -->
            <div class="glass-card cursor-pointer p-6 text-center group hover:scale-105 transition-all duration-300">
                <div class="mb-4 flex justify-center">
                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-primary/20 to-accent/20 border border-primary/30 group-hover:border-primary/50 group-hover:scale-110 transition-all duration-300">
                        <svg class="h-7 w-7 text-primary group-hover:text-accent transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <h3 class="mb-2 font-bold text-foreground group-hover:text-primary transition-colors">{{ __('Gaming') }}</h3>
                <p class="text-sm text-muted-foreground font-medium">213 {{ __('items') }}</p>
            </div>

            <!-- Social Media -->
            <div class="glass-card cursor-pointer p-6 text-center group hover:scale-105 transition-all duration-300">
                <div class="mb-4 flex justify-center">
                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-primary/20 to-accent/20 border border-primary/30 group-hover:border-primary/50 group-hover:scale-110 transition-all duration-300">
                        <svg class="h-7 w-7 text-primary group-hover:text-accent transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
                <h3 class="mb-2 font-bold text-foreground group-hover:text-primary transition-colors">{{ __('Social Media') }}</h3>
                <p class="text-sm text-muted-foreground font-medium">156 {{ __('items') }}</p>
            </div>

            <!-- Streaming -->
            <div class="glass-card cursor-pointer p-6 text-center group hover:scale-105 transition-all duration-300">
                <div class="mb-4 flex justify-center">
                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-primary/20 to-accent/20 border border-primary/30 group-hover:border-primary/50 group-hover:scale-110 transition-all duration-300">
                        <svg class="h-7 w-7 text-primary group-hover:text-accent transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
                <h3 class="mb-2 font-bold text-foreground group-hover:text-primary transition-colors">{{ __('Streaming') }}</h3>
                <p class="text-sm text-muted-foreground font-medium">98 {{ __('items') }}</p>
            </div>

            <!-- E-commerce -->
            <div class="glass-card cursor-pointer p-6 text-center group hover:scale-105 transition-all duration-300">
                <div class="mb-4 flex justify-center">
                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-primary/20 to-accent/20 border border-primary/30 group-hover:border-primary/50 group-hover:scale-110 transition-all duration-300">
                        <svg class="h-7 w-7 text-primary group-hover:text-accent transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                </div>
                <h3 class="mb-2 font-bold text-foreground group-hover:text-primary transition-colors">{{ __('E-commerce') }}</h3>
                <p class="text-sm text-muted-foreground font-medium">189 {{ __('items') }}</p>
            </div>

            <!-- Digital Services -->
            <div class="glass-card cursor-pointer p-6 text-center group hover:scale-105 transition-all duration-300">
                <div class="mb-4 flex justify-center">
                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-primary/20 to-accent/20 border border-primary/30 group-hover:border-primary/50 group-hover:scale-110 transition-all duration-300">
                        <svg class="h-7 w-7 text-primary group-hover:text-accent transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <h3 class="mb-2 font-bold text-foreground group-hover:text-primary transition-colors">{{ __('Digital Services') }}</h3>
                <p class="text-sm text-muted-foreground font-medium">127 {{ __('items') }}</p>
            </div>

            <!-- Crypto & Finance -->
            <div class="glass-card cursor-pointer p-6 text-center group hover:scale-105 transition-all duration-300">
                <div class="mb-4 flex justify-center">
                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-primary/20 to-accent/20 border border-primary/30 group-hover:border-primary/50 group-hover:scale-110 transition-all duration-300">
                        <svg class="h-7 w-7 text-primary group-hover:text-accent transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                        </svg>
                    </div>
                </div>
                <h3 class="mb-2 font-bold text-foreground group-hover:text-primary transition-colors">{{ __('Crypto & Finance') }}</h3>
                <p class="text-sm text-muted-foreground font-medium">245 {{ __('items') }}</p>
            </div>
        </div>
    </div>
</section>
