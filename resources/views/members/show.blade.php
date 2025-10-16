<x-layouts.stellar>
    <x-slot name="title">{{ $user->name }} - {{ config('app.name') }}</x-slot>

    <!-- Profile Header -->
    <section class="relative pt-32 pb-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6">
            <div class="bg-slate-800/50 rounded-2xl p-8 lg:p-12 border border-slate-700/50" data-aos="fade-up">
                <div class="flex flex-col md:flex-row gap-8 items-center md:items-start">
                    <!-- Avatar -->
                    <div class="w-32 h-32 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <span class="text-5xl font-bold text-white">{{ substr($user->name, 0, 1) }}</span>
                    </div>

                    <!-- Info -->
                    <div class="flex-1 text-center md:text-left">
                        <h1 class="text-3xl font-bold text-slate-100 mb-2">{{ $user->name }}</h1>
                        @if($user->username)
                            <p class="text-slate-400 mb-4">{{ '@' . $user->username }}</p>
                        @endif
                        
                        @if($user->bio)
                            <p class="text-slate-300 mb-4">{{ $user->bio }}</p>
                        @endif

                        <!-- Stats -->
                        <div class="flex flex-wrap gap-6 justify-center md:justify-start mb-4">
                            @if($user->seller)
                                <div class="flex items-center text-slate-300">
                                    <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                    </svg>
                                    <span>{{ $user->seller->products_count ?? 0 }} {{ __('Products') }}</span>
                                </div>
                                @if($user->seller->rating)
                                    <div class="flex items-center text-slate-300">
                                        <svg class="w-5 h-5 mr-2 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        <span>{{ number_format($user->seller->rating, 1) }} {{ __('Rating') }}</span>
                                    </div>
                                @endif
                            @endif
                            <div class="flex items-center text-slate-300">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span>{{ __('Joined') }} {{ $user->created_at->format('M Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Member's Products -->
    @if($user->seller && isset($products) && $products->count() > 0)
        <section class="pb-16 md:pb-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6">
                <h2 class="h3 text-slate-100 mb-8 text-center">{{ __('Products by :name', ['name' => $user->name]) }}</h2>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <div class="group relative" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 8) * 50 }}">
                            <div class="absolute inset-0 bg-gradient-to-b from-slate-800/50 to-slate-900/50 rounded-2xl -m-px opacity-0 group-hover:opacity-100 transition duration-700"></div>
                            <div class="relative bg-slate-800/50 rounded-2xl p-5 border border-slate-700/50 h-full flex flex-col">
                                <div class="flex items-center justify-center w-16 h-16 bg-slate-700 rounded-xl mb-4 mx-auto">
                                    <x-platform-icon :product="$product" size="lg" />
                                </div>
                                <h3 class="text-lg font-bold text-slate-100 mb-2 text-center line-clamp-1">{{ $product->title }}</h3>
                                <p class="text-slate-400 text-sm mb-4 text-center line-clamp-2 flex-grow">{{ Str::limit($product->description, 80) }}</p>
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-2xl font-bold text-white">${{ number_format($product->price, 2) }}</span>
                                    @if($product->category)
                                        <span class="text-xs text-slate-400 bg-slate-700 px-2 py-1 rounded">{{ $product->category->name }}</span>
                                    @endif
                                </div>
                                <a href="{{ route('products.show', $product->slug) }}" 
                                   class="btn text-slate-900 bg-gradient-to-r from-white/80 via-white to-white/80 hover:bg-white w-full text-sm group/btn">
                                    {{ __('View Details') }}
                                    <span class="tracking-normal text-purple-500 group-hover/btn:translate-x-0.5 transition-transform duration-150 ease-in-out ml-1">→</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($products->hasPages())
                    <div class="mt-12">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </section>
    @endif
</x-layouts.stellar>
