<x-layouts.stellar>
    <x-slot name="title">{{ __('Home') }} - {{ config('app.name') }}</x-slot>

<!-- Hero -->
<section>
    <div class="relative max-w-6xl mx-auto px-4 sm:px-6">

        <!-- Particles animation -->
        <div class="absolute inset-0 -z-10" aria-hidden="true">
            <canvas data-particle-animation></canvas>
        </div>

        <!-- Illustration -->
        <div class="absolute inset-0 -z-10 -mx-28 rounded-b-[3rem] pointer-events-none overflow-hidden" aria-hidden="true">
            <div class="absolute left-1/2 -translate-x-1/2 bottom-0 -z-10">
                <img src="{{ asset('stellar-assets/images/glow-bottom.svg') }}" class="max-w-none" width="2146" height="774" alt="Hero Illustration">
            </div>
        </div>

        <div class="pt-32 pb-16 md:pt-52 md:pb-32">

            <!-- Hero content -->
            <div class="max-w-3xl mx-auto text-center">
            <div class="mb-6" data-aos="fade-down">
                <div class="inline-flex relative before:absolute before:inset-0 before:bg-purple-500 before:blur-md">
                    <a class="btn-sm py-0.5 text-slate-300 hover:text-white transition duration-150 ease-in-out group [background:linear-gradient(var(--color-purple-500),var(--color-purple-500))_padding-box,linear-gradient(var(--color-purple-500),var(--color-purple-200)_75%,transparent_100%)_border-box] relative before:absolute before:inset-0 before:bg-slate-800/50 before:rounded-full before:pointer-events-none shadow-sm" href="{{ url('/pricing') }}">
                    <span class="relative inline-flex items-center">
                      {{ __('اختر خطتك الآن 🚀') }} <span class="tracking-normal text-purple-500 group-hover:translate-x-0.5 transition-transform duration-150 ease-in-out ml-1">-&gt;</span>
                    </span>
                  </a>
                </div>
            </div>
            <h1 class="text-4xl font-bold bg-clip-text text-transparent bg-linear-to-r from-slate-200/60 via-slate-200 to-slate-200/60 pb-4" data-aos="fade-down">
  @php($title = __('منصّتك الموثوقة لبيع وشراء الحسابات الرقمية 🔐'))
  {!! str_replace(['🔐','⚡','✨'], ['<span class="emoji">🔐️</span>','<span class="emoji">⚡️</span>','<span class="emoji">✨️</span>'], e($title)) !!}
</h1>

                <p class="text-lg text-slate-300 mb-8" data-aos="fade-down" data-aos-delay="200">{{ __('Our landing page template works on all devices, so you only have to set it up once, and get beautiful results forever.') }}</p>
                <div class="max-w-xs mx-auto sm:max-w-none sm:inline-flex sm:justify-center space-y-4 sm:space-y-0 sm:space-x-4" data-aos="fade-down" data-aos-delay="400">
                    <div>
                        <a class="btn text-slate-900 bg-linear-to-r from-white/80 via-white to-white/80 hover:bg-white w-full transition duration-150 ease-in-out group" href="{{ url('/pricing') }}">
                            {{ __('Get Started') }} <span class="tracking-normal text-purple-500 group-hover:translate-x-0.5 transition-transform duration-150 ease-in-out ml-1">-&gt;</span>
                        </a>
                    </div>
                    <div>
                        <a class="btn text-slate-200 hover:text-white bg-slate-900/25 hover:bg-slate-900/30 w-full transition duration-150 ease-in-out" href="#0">
                            <svg class="shrink-0 fill-slate-300 mr-3" xmlns="http://www.w3.org/2000/svg" width="16" height="16">
                                <path d="m1.999 0 1 2-1 2 2-1 2 1-1-2 1-2-2 1zM11.999 0l1 2-1 2 2-1 2 1-1-2 1-2-2 1zM11.999 10l1 2-1 2 2-1 2 1-1-2 1-2-2 1zM6.292 7.586l2.646-2.647L11.06 7.06 8.413 9.707zM0 13.878l5.586-5.586 2.122 2.121L2.12 16z" />
                            </svg>
                            <span>{{ __('Read the docs') }}</span>
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

<!-- Clients -->
<section>
    <div class="relative max-w-6xl mx-auto px-4 sm:px-6">

        <!-- Particles animation -->
        <div class="absolute inset-0 max-w-6xl mx-auto px-4 sm:px-6">
            <div class="absolute inset-0 -z-10" aria-hidden="true">
                <canvas data-particle-animation data-particle-quantity="5"></canvas>
            </div>
        </div>

        <div class="py-12 md:py-16">
            <div class="overflow-hidden">

                <div class="inline-flex w-full flex-nowrap overflow-hidden [mask-image:_linear-gradient(to_right,transparent_0,_black_128px,_black_calc(100%-128px),transparent_100%)]">
                    <ul class="flex animate-infinite-scroll items-center justify-center md:justify-start [&_img]:max-w-none [&_li]:mx-8">
                        <li>
                            <img src="{{ asset('stellar-assets/images/client-01.svg') }}" alt="Client 1">
                        </li>
                        <li>
                            <img src="{{ asset('stellar-assets/images/client-02.svg') }}" alt="Client 2">
                        </li>
                        <li>
                            <img src="{{ asset('stellar-assets/images/client-03.svg') }}" alt="Client 3">
                        </li>
                        <li>
                            <img src="{{ asset('stellar-assets/images/client-04.svg') }}" alt="Client 4">
                        </li>
                        <li>
                            <img src="{{ asset('stellar-assets/images/client-05.svg') }}" alt="Client 5">
                        </li>
                        <li>
                            <img src="{{ asset('stellar-assets/images/client-06.svg') }}" alt="Client 6">
                        </li>
                    </ul>
                    <ul class="flex animate-infinite-scroll items-center justify-center md:justify-start [&_img]:max-w-none [&_li]:mx-8" aria-hidden="true">
                        <li>
                            <img src="{{ asset('stellar-assets/images/client-01.svg') }}" alt="Client 1">
                        </li>
                        <li>
                            <img src="{{ asset('stellar-assets/images/client-02.svg') }}" alt="Client 2">
                        </li>
                        <li>
                            <img src="{{ asset('stellar-assets/images/client-03.svg') }}" alt="Client 3">
                        </li>
                        <li>
                            <img src="{{ asset('stellar-assets/images/client-04.svg') }}" alt="Client 4">
                        </li>
                        <li>
                            <img src="{{ asset('stellar-assets/images/client-05.svg') }}" alt="Client 5">
                        </li>
                        <li>
                            <img src="{{ asset('stellar-assets/images/client-06.svg') }}" alt="Client 6">
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- Features -->
<section>
    <div class="relative max-w-6xl mx-auto px-4 sm:px-6">

        <!-- Illustration -->
        <div class="absolute inset-0 -z-10 -mx-28 rounded-b-[3rem] pointer-events-none overflow-hidden" aria-hidden="true">
            <div class="absolute left-1/2 -translate-x-1/2 bottom-0 -z-10">
                <img src="{{ asset('stellar-assets/images/glow-bottom.svg') }}" class="max-w-none" width="2146" height="774" alt="Hero Illustration">
            </div>
        </div>

        <div class="py-12 md:py-20">

            <!-- Section header -->
            <div class="max-w-3xl mx-auto text-center pb-12 md:pb-20">
                <h2 class="h2 bg-clip-text text-transparent bg-linear-to-r from-slate-200/60 via-slate-200 to-slate-200/60 pb-4">{{ __('Popular Categories') }}</h2>
                <p class="text-lg text-slate-300">{{ __('Explore our most popular digital product categories') }}</p>
            </div>

            <!-- Features grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                @forelse($categories as $category)
                <div class="group relative" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="absolute inset-0 bg-gradient-to-b from-slate-800/50 to-slate-900/50 rounded-2xl -m-px opacity-0 group-hover:opacity-100 transition duration-700 ease-out"></div>
                    <div class="relative bg-slate-800 rounded-2xl p-6 lg:p-8">
                        <div class="flex items-center justify-center w-12 h-12 bg-slate-700 rounded-xl mb-4">
                            <x-platform-icon :category="$category->name ?? 'General'" size="lg" />
                        </div>
                        <h3 class="text-xl font-bold text-slate-100 mb-2">{{ $category->name ?? 'General' }}</h3>
                        <p class="text-slate-400 mb-6">{{ $category->description ?? 'Premium digital products in this category' }}</p>
                        <div class="flex items-center text-sm text-slate-300">
                            <span>{{ $category->products_count ?? 0 }} {{ __('products') }}</span>
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                        <a class="absolute inset-0" href="{{ route('products.index', ['category' => $category->slug ?? 'general']) }}"><span class="sr-only">{{ __('View') }} {{ $category->name ?? 'General' }}</span></a>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-slate-400">{{ __('No categories available at the moment.') }}</p>
                </div>
                @endforelse
            </div>

        </div>
    </div>
</section>

<!-- Featured Products -->
@if($featuredProducts->count() > 0)
<section>
    <div class="relative max-w-6xl mx-auto px-4 sm:px-6">

        <div class="py-12 md:py-20">

            <!-- Section header -->
            <div class="max-w-3xl mx-auto text-center pb-12 md:pb-20">
                <h2 class="h2 bg-clip-text text-transparent bg-linear-to-r from-slate-200/60 via-slate-200 to-slate-200/60 pb-4">{{ __('Featured Products') }}</h2>
                <p class="text-lg text-slate-300">{{ __('Discover our handpicked premium digital products') }}</p>
            </div>

            <!-- Products grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                @foreach($featuredProducts as $product)
                <div class="group relative" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="absolute inset-0 bg-gradient-to-b from-slate-800/50 to-slate-900/50 rounded-2xl -m-px opacity-0 group-hover:opacity-100 transition duration-700 ease-out"></div>
                    <div class="relative bg-slate-800 rounded-2xl p-4">
                        <div class="flex items-center justify-center w-16 h-16 bg-slate-700 rounded-xl mb-3 mx-auto">
                            <x-platform-icon :product="$product" size="lg" />
                        </div>
                        <h3 class="text-lg font-bold text-slate-100 mb-2 text-center">{{ $product->title }}</h3>
                        <p class="text-slate-400 text-sm mb-4 text-center line-clamp-2">{{ $product->description }}</p>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-2xl font-bold text-white">${{ number_format($product->price, 2) }}</span>
                            @if($product->category)
                            <span class="text-xs text-slate-400 bg-slate-700 px-2 py-1 rounded">{{ $product->category->name }}</span>
                            @endif
                        </div>
                        <a class="btn text-slate-900 bg-linear-to-r from-white/80 via-white to-white/80 hover:bg-white w-full transition duration-150 ease-in-out group" href="{{ route('products.show', $product->slug) }}">
                            {{ __('View Details') }} <span class="tracking-normal text-purple-500 group-hover:translate-x-0.5 transition-transform duration-150 ease-in-out ml-1">-&gt;</span>
                        </a>
                        <a class="absolute inset-0" href="{{ route('products.show', $product->slug) }}"><span class="sr-only">{{ __('View') }} {{ $product->title }}</span></a>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </div>
</section>
@endif

<!-- Recent Products -->
@if($recentProducts->count() > 0)
<section>
    <div class="relative max-w-6xl mx-auto px-4 sm:px-6">

        <div class="py-12 md:py-20">

            <!-- Section header -->
            <div class="max-w-3xl mx-auto text-center pb-12 md:pb-20">
                <h2 class="h2 bg-clip-text text-transparent bg-linear-to-r from-slate-200/60 via-slate-200 to-slate-200/60 pb-4">{{ __('Latest Products') }}</h2>
                <p class="text-lg text-slate-300">{{ __('Fresh digital products added to our marketplace') }}</p>
            </div>

            <!-- Products grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                @foreach($recentProducts as $product)
                <div class="group relative" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="absolute inset-0 bg-gradient-to-b from-slate-800/50 to-slate-900/50 rounded-2xl -m-px opacity-0 group-hover:opacity-100 transition duration-700 ease-out"></div>
                    <div class="relative bg-slate-800 rounded-2xl p-4">
                        <div class="flex items-center justify-center w-16 h-16 bg-slate-700 rounded-xl mb-3 mx-auto">
                            <x-platform-icon :product="$product" size="lg" />
                        </div>
                        <h3 class="text-lg font-bold text-slate-100 mb-2 text-center">{{ $product->title }}</h3>
                        <p class="text-slate-400 text-sm mb-4 text-center line-clamp-2">{{ $product->description }}</p>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-2xl font-bold text-white">${{ number_format($product->price, 2) }}</span>
                            @if($product->category)
                            <span class="text-xs text-slate-400 bg-slate-700 px-2 py-1 rounded">{{ $product->category->name }}</span>
                            @endif
                        </div>
                        <a class="btn text-slate-900 bg-linear-to-r from-white/80 via-white to-white/80 hover:bg-white w-full transition duration-150 ease-in-out group" href="{{ route('products.show', $product->slug) }}">
                            {{ __('View Details') }} <span class="tracking-normal text-purple-500 group-hover:translate-x-0.5 transition-transform duration-150 ease-in-out ml-1">-&gt;</span>
                        </a>
                        <a class="absolute inset-0" href="{{ route('products.show', $product->slug) }}"><span class="sr-only">{{ __('View') }} {{ $product->title }}</span></a>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- CTA -->
            <div class="text-center mt-12" data-aos="fade-up">
                <a class="btn text-slate-200 hover:text-white bg-slate-900/25 hover:bg-slate-900/30 transition duration-150 ease-in-out" href="{{ route('products.index') }}">
                    {{ __('View All Products') }} <span class="tracking-normal text-purple-500 group-hover:translate-x-0.5 transition-transform duration-150 ease-in-out ml-1">-&gt;</span>
                </a>
            </div>

        </div>
    </div>
</section>
@endif

</x-layouts.stellar>