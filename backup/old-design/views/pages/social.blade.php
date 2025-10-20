<x-layouts.stellar>
    <x-slot name="title">{{ __('Social Accounts') }} - {{ config('app.name') }}</x-slot>

<section class="relative pt-32 pb-12">
<div class="relative overflow-hidden">
    <!-- Gaming Background Effects -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary-500/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-secondary-500/10 rounded-full blur-3xl animate-float animation-delay-2000"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-neon-blue/5 rounded-full blur-3xl animate-pulse-slow"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12 animate-fade-in">
            <div class="relative inline-flex items-center justify-center w-20 h-20 bg-gaming-gradient rounded-3xl mb-8 shadow-gaming-xl group">
                <div class="absolute inset-0 bg-gaming-gradient rounded-3xl blur-xl opacity-50 group-hover:opacity-100 transition-opacity"></div>
                <svg class="relative w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <h1 class="text-5xl md:text-6xl font-black text-white mb-6 bg-gaming-gradient bg-clip-text text-transparent leading-tight">
                Social Accounts
            </h1>
            <p class="text-xl text-muted-300 max-w-2xl mx-auto">
                Premium social media accounts and digital assets from verified sellers
            </p>
        </div>

        @if($products->count() > 0)
            <!-- Products Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                @foreach($products as $product)
                <x-product-card :product="$product" />
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @else
            <!-- No Products Found -->
            <div class="card-glass text-center py-20">
                <svg class="w-24 h-24 mx-auto text-muted-400 mb-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <h3 class="text-3xl font-bold text-white mb-4">No Social Accounts Found</h3>
                <p class="text-muted-400 mb-8 max-w-md mx-auto">
                    No social account products are currently available. Check back later or browse other categories!
                </p>
                <a href="{{ route('products.index') }}" class="btn-primary btn-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Browse All Products
                </a>
            </div>
        @endif
    </div>
</div>
</section>

</x-layouts.stellar>
