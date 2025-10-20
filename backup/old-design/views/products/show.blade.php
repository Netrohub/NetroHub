<x-layouts.stellar>
    <x-slot name="title">{{ $product->title }} - {{ config('app.name') }}</x-slot>

    <!-- Breadcrumb -->
    <section class="relative pt-32 pb-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <nav class="flex items-center space-x-2 text-sm" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="text-slate-400 hover:text-slate-200 transition">{{ __('Home') }}</a>
                <span class="text-slate-600">/</span>
                <a href="{{ route('products.index') }}" class="text-slate-400 hover:text-slate-200 transition">{{ __('Products') }}</a>
                @if($product->category)
                <span class="text-slate-600">/</span>
                <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="text-slate-400 hover:text-slate-200 transition">{{ $product->category->name }}</a>
                @endif
                <span class="text-slate-600">/</span>
                <span class="text-slate-200">{{ $product->title }}</span>
            </nav>
        </div>
    </section>

    <!-- Product Details -->
    <section class="relative pb-10 sm:pb-14">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="grid lg:grid-cols-2 gap-8 lg:gap-12">
                
                <!-- Left Column - Product Image/Icon -->
                <div>
                    <div class="sticky top-24">
                        <div class="bg-slate-800 rounded-2xl p-8 lg:p-12 aspect-[4/3] flex items-center justify-center mb-6">
                            @if($product->thumbnail_url ?? false)
                                <img src="{{ $product->thumbnail_url }}" alt="{{ $product->title }}" class="w-full h-full object-cover rounded-xl" loading="lazy" width="600" height="450">
                            @else
                                <div class="w-48 h-48 lg:w-64 lg:h-64 bg-slate-700 rounded-3xl flex items-center justify-center">
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

                <!-- Right Column - Product Info -->
                <div>
                    <!-- Category Badge -->
                    @if($product->category)
                        <span class="inline-block text-sm text-purple-400 bg-purple-500/10 border border-purple-500/30 px-3 py-1 rounded-full mb-4">
                            {{ $product->category->name }}
                        </span>
                    @endif

                    <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-slate-100 mb-2" data-aos="fade-up">{{ $product->title }}</h1>
                    
                    <!-- Rating & Reviews -->
                    @if($product->rating || $product->reviews_count)
                        <div class="flex items-center gap-3 mb-4" data-aos="fade-up" data-aos-delay="50">
                            @if($product->rating)
                                <div class="flex items-center gap-1">
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <span class="text-lg font-bold text-white">★ {{ number_format($product->rating, 1) }}</span>
                                </div>
                            @endif
                            @if($product->reviews_count)
                                <span class="text-slate-400">({{ number_format($product->reviews_count) }} {{ __('reviews') }})</span>
                            @endif
                        </div>
                    @endif
                    
                    <!-- Price -->
                    <div class="flex items-baseline gap-4 mb-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="text-4xl font-bold text-white">
                            ${{ number_format($product->price, 2) }}
                        </div>
                        @if(isset($product->original_price) && $product->original_price > $product->price)
                            <div class="text-xl text-slate-400 line-through">
                                ${{ number_format($product->original_price, 2) }}
                            </div>
                            <div class="text-sm text-green-400 bg-green-500/10 px-2 py-1 rounded">
                                {{ __('Save') }} {{ round((($product->original_price - $product->price) / $product->original_price) * 100) }}%
                            </div>
                        @endif
                    </div>

                    <!-- Description -->
                    <div class="prose prose-invert max-w-none mb-8" data-aos="fade-up" data-aos-delay="200">
                        <p class="text-slate-200 text-lg leading-relaxed">
                            {!! nl2br(e($product->description)) !!}
                        </p>
                    </div>

                    <!-- Add to Cart / Purchase -->
                    <div class="space-y-4 mb-6" data-aos="fade-up" data-aos-delay="300">
                        @auth
                            @if($product->stock > 0 || !isset($product->stock))
                                <form action="{{ route('cart.add', $product) }}" method="POST" class="flex gap-4">
                                    @csrf
                                    <button type="submit" class="btn text-white bg-purple-500 hover:bg-purple-600 w-full lg:flex-1 shadow-lg shadow-purple-500/25 hover:shadow-purple-500/40">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                        </svg>
                                        {{ __('Add to Cart') }}
                                    </button>
                                </form>
                            @else
                                <button disabled class="btn text-slate-400 bg-slate-700 w-full cursor-not-allowed">
                                    {{ __('Out of Stock') }}
                                </button>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn text-white bg-purple-500 hover:bg-purple-600 w-full block text-center shadow-lg shadow-purple-500/25 hover:shadow-purple-500/40">
                                {{ __('Login to Purchase') }}
                            </a>
                        @endauth
                    </div>

                    <!-- Delivery Information -->
                    <div class="bg-slate-800/50 rounded-xl p-4 mb-8 border border-slate-700/50" data-aos="fade-up" data-aos-delay="350">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-blue-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-white mb-1">{{ __('Delivery Details') }}</h4>
                                <p class="text-sm text-slate-200 leading-relaxed">
                                    @if($product->auto_delivery ?? false)
                                        {{ __('Instant delivery after payment confirmation. You will receive the account details immediately.') }}
                                    @else
                                        {{ __('Manual delivery within 24 hours. Our team will process your order and deliver the account details.') }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Product Features/Details -->
                    @if(isset($product->features) && count($product->features) > 0)
                        <div class="bg-slate-800/50 rounded-2xl p-6 mb-8 border border-slate-700/50" data-aos="fade-up" data-aos-delay="400">
                            <h3 class="text-lg font-bold text-slate-100 mb-4">{{ __('What\'s Included') }}</h3>
                            <ul class="space-y-3">
                                @foreach($product->features as $feature)
                                    <li class="flex items-start text-slate-300">
                                        <svg class="w-5 h-5 text-purple-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $feature }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Seller Info -->
                    @if($product->seller)
                        <div class="bg-slate-800/50 rounded-2xl p-6 border border-slate-700/50" data-aos="fade-up" data-aos-delay="500">
                            <h3 class="text-sm font-bold text-slate-100 mb-4">{{ __('Seller Information') }}</h3>
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-slate-700 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <span class="text-lg font-bold text-purple-400">
                                        {{ substr($product->seller->user->name, 0, 1) }}
                                    </span>
                                </div>
                                <div class="flex-grow">
                                    <div class="text-slate-100 font-medium">{{ $product->seller->user->name }}</div>
                                    @if($product->seller->rating)
                                        <div class="flex items-center text-sm text-slate-400">
                                            <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                            {{ number_format($product->seller->rating, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <a href="{{ route('members.show', $product->seller->user) }}" class="text-purple-400 hover:text-purple-300 text-sm">
                                    {{ __('View Profile') }}
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Social Media Link -->
                    @if($product->hasSocialMedia())
                        <div class="bg-slate-800/50 rounded-2xl p-6 border border-slate-700/50 mt-8" data-aos="fade-up" data-aos-delay="550">
                            <h3 class="text-lg font-bold text-slate-100 mb-4 flex items-center">
                                <svg class="w-5 h-5 text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                </svg>
                                {{ __('Visit Account') }}
                            </h3>
                            <p class="text-slate-400 text-sm mb-4">{{ __('Click the button below to visit this social media account') }}</p>
                            
                            <a href="{{ $product->getSocialMediaUrl() }}" 
                               target="_blank" 
                               rel="noopener noreferrer"
                               class="inline-flex items-center justify-center w-full px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-medium rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                                    <x-platform-icon :platform="$product->platform" size="sm" />
                                </div>
                                <div class="text-left">
                                    <div class="text-sm font-medium">{{ __('Visit') }} {{ $product->platform }}</div>
                                    <div class="text-xs opacity-90">@{{ $product->social_username }}</div>
                                </div>
                                <svg class="w-5 h-5 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                            </a>
                            
                            <div class="mt-4 p-3 bg-blue-500/10 border border-blue-500/20 rounded-lg">
                                <div class="flex items-start">
                                    <svg class="w-4 h-4 text-blue-400 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <div class="text-xs text-blue-300">
                                        <strong>{{ __('Note:') }}</strong> {{ __('This link will open in a new tab. You can verify the account details before purchasing.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Product Checklist -->
                    @if(($product->general_checklist && count($product->general_checklist) > 0) || ($product->whiteout_survival_checklist && count($product->whiteout_survival_checklist) > 0))
                        <div class="bg-slate-800/50 rounded-2xl p-6 border border-slate-700/50 mt-8" data-aos="fade-up" data-aos-delay="600">
                            <h3 class="text-lg font-bold text-slate-100 mb-6 flex items-center">
                                <svg class="w-5 h-5 text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ __('Product Information') }}
                            </h3>
                            
                            <!-- General Checklist -->
                            @if($product->general_checklist && count($product->general_checklist) > 0)
                                <div class="space-y-3 mb-6">
                                    @foreach($product->general_checklist as $key => $value)
                                        @if($value)
                                            <div class="flex items-center justify-between p-3 bg-slate-700/30 rounded-lg border border-slate-600/30">
                                                <div class="flex items-center">
                                                    <div class="w-6 h-6 bg-blue-500/20 rounded-md flex items-center justify-center mr-3">
                                                        <svg class="w-3 h-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                        </svg>
                                                    </div>
                                                    <span class="text-slate-200 text-sm font-medium">
                                                        @switch($key)
                                                            @case('auto_delivery')
                                                                {{ __('تسليم تلقائي؟') }}
                                                                @break
                                                            @case('with_original_email')
                                                                {{ __('مع الأيميل الأساسي؟') }}
                                                                @break
                                                            @case('with_current_email')
                                                                {{ __('مع الأيميل الحالي؟') }}
                                                                @break
                                                            @case('linked_to_number')
                                                                {{ __('مربوط برقم؟') }}
                                                                @break
                                                            @case('owner_verified')
                                                                {{ __('صاحب المنتج موثق بهوية؟') }}
                                                                @break
                                                            @default
                                                                {{ ucwords(str_replace('_', ' ', $key)) }}
                                                        @endswitch
                                                    </span>
                                                </div>
                                                <div class="flex items-center">
                                                    @if($value === 'yes')
                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-500/20 text-green-400 border border-green-500/30">
                                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                            </svg>
                                                            {{ __('نعم') }}
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-500/20 text-red-400 border border-red-500/30">
                                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                            </svg>
                                                            {{ __('لا') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif

                            <!-- Whiteout Survival Checklist -->
                            @if($product->whiteout_survival_checklist && count($product->whiteout_survival_checklist) > 0)
                                <div class="border-t border-slate-700/50 pt-6">
                                    <h4 class="text-md font-bold text-slate-100 mb-4 flex items-center">
                                        <svg class="w-4 h-4 text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                                        </svg>
                                        {{ __('Whiteout Survival Specific') }}
                                    </h4>
                                    <div class="space-y-3">
                                        @foreach($product->whiteout_survival_checklist as $key => $value)
                                            @if($value)
                                                <div class="flex items-center justify-between p-3 bg-slate-700/30 rounded-lg border border-slate-600/30">
                                                    <div class="flex items-center">
                                                        <div class="w-6 h-6 bg-blue-500/20 rounded-md flex items-center justify-center mr-3">
                                                            <svg class="w-3 h-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                            </svg>
                                                        </div>
                                                        <span class="text-slate-200 text-sm font-medium">
                                                            @switch($key)
                                                                @case('linked_to_facebook')
                                                                    {{ __('مربوط بالفيس بوك؟') }}
                                                                    @break
                                                                @case('linked_to_google')
                                                                    {{ __('مربوط بقوقل؟') }}
                                                                    @break
                                                                @case('linked_to_apple')
                                                                    {{ __('مربوط بأبل؟') }}
                                                                    @break
                                                                @case('linked_to_game_center')
                                                                    {{ __('مربوط بقيم سنتر؟') }}
                                                                    @break
                                                                @default
                                                                    {{ ucwords(str_replace('_', ' ', $key)) }}
                                                            @endswitch
                                                        </span>
                                                    </div>
                                                    <div class="flex items-center">
                                                        @if($value === 'yes')
                                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-500/20 text-green-400 border border-green-500/30">
                                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                                </svg>
                                                                {{ __('نعم') }}
                                                            </span>
                                                        @else
                                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-500/20 text-red-400 border border-red-500/30">
                                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                                </svg>
                                                                {{ __('لا') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Reviews Section -->
            @if(isset($product->reviews) && $product->reviews->count() > 0)
                <div class="mt-16 pt-16 border-t border-slate-800">
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-slate-100 mb-8">{{ __('Customer Reviews') }}</h2>
                    <div class="space-y-6">
                        @foreach($product->reviews->take(5) as $review)
                            <div class="bg-slate-800/50 rounded-2xl p-6 border border-slate-700/50">
                                <div class="flex items-center mb-4">
                                    <div class="w-10 h-10 bg-slate-700 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-sm font-bold text-purple-400">
                                            {{ substr($review->user->name, 0, 1) }}
                                        </span>
                                    </div>
                                    <div class="flex-grow">
                                        <div class="text-slate-100 font-medium">{{ $review->user->name }}</div>
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-slate-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                    <span class="text-sm text-slate-400">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-slate-300">{{ $review->comment }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
</x-layouts.stellar>
