<x-layouts.app>
    <x-slot name="title">{{ __('Members') }} - {{ config('app.name') }}</x-slot>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-12">
        <!-- Soft radial glow -->
        <div class="absolute inset-0 -z-10" aria-hidden="true">
            <div class="absolute left-1/2 -translate-x-1/2 top-10 w-[700px] h-[700px] rounded-full bg-purple-500/20 blur-[120px]"></div>
        </div>
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="text-center">
                <h1 class="h1 bg-clip-text text-transparent bg-gradient-to-r from-slate-200/60 via-slate-200 to-slate-200/60 pb-4" data-aos="fade-down">
                    {{ __('Community Members') }}
                </h1>
                <p class="text-lg text-slate-300 max-w-2xl mx-auto" data-aos="fade-down" data-aos-delay="200">
                    {{ __('Meet our talented community of sellers and buyers') }}
                </p>
            </div>
        </div>
    </section>

    <!-- Search & Filters -->
    <section class="pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="bg-slate-800/50 rounded-2xl p-6 border border-slate-700/50 shadow-lg shadow-black/10" data-aos="fade-up">
                <form method="GET" class="grid md:grid-cols-4 gap-4">
                    <input type="search" name="search" placeholder="{{ __('Search members...') }}" value="{{ request('search') }}" class="form-input w-full md:col-span-2">
                    <select name="filter" class="form-select w-full" onchange="this.form.submit()">
                        <option value="all" {{ request('filter','all') === 'all' ? 'selected' : '' }}>{{ __('All') }}</option>
                        <option value="sellers" {{ request('filter') === 'sellers' ? 'selected' : '' }}>{{ __('Sellers') }}</option>
                        <option value="buyers" {{ request('filter') === 'buyers' ? 'selected' : '' }}>{{ __('Buyers') }}</option>
                        <option value="verified" {{ request('filter') === 'verified' ? 'selected' : '' }}>{{ __('Verified') }}</option>
                    </select>
                    <select name="sort" onchange="this.form.submit()" class="form-select w-full">
                        <option value="latest" {{ request('sort','latest') === 'latest' ? 'selected' : '' }}>{{ __('Newest First') }}</option>
                        <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>{{ __('Name A–Z') }}</option>
                        <option value="sales" {{ request('sort') === 'sales' ? 'selected' : '' }}>{{ __('Top Sellers') }}</option>
                    </select>
                </form>
            </div>
        </div>
    </section>

    <!-- Members Grid -->
    <section class="pb-16 md:pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            @if(isset($users) && $users->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($users as $user)
                        <div class="group relative" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 8) * 50 }}">
                            <div class="absolute inset-0 bg-gradient-to-b from-slate-800/60 to-slate-900/60 rounded-2xl -m-px opacity-0 group-hover:opacity-100 transition duration-700"></div>
                            <div class="relative bg-slate-800/50 rounded-2xl p-6 border border-slate-700/50 text-center shadow-md shadow-black/10">
                                <!-- Avatar -->
                                <div class="w-20 h-20 rounded-full mx-auto mb-4 overflow-hidden border-2 border-slate-700 bg-slate-700">
                                    @if(!empty($user->avatar_url))
                                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center">
                                            <span class="text-2xl font-bold text-white">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Name -->
                                <h3 class="text-lg font-bold text-slate-100 mb-1">{{ $user->name }}</h3>
                                
                                <!-- Username -->
                                @if($user->username)
                                    <p class="text-sm text-slate-400 mb-3">{{ '@' . $user->username }}</p>
                                @endif

                                <!-- Stats -->
                                <div class="flex items-center justify-center gap-4 mb-4 text-sm">
                                    @if($user->seller)
                                        <div class="flex items-center text-slate-400">
                                            <svg class="w-4 h-4 mr-1 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                            </svg>
                                            {{ $user->seller->products_count ?? 0 }}
                                        </div>
                                    @endif
                                    @if($user->seller && $user->seller->rating)
                                        <div class="flex items-center text-slate-400">
                                            <svg class="w-4 h-4 mr-1 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                            {{ number_format($user->seller->rating, 1) }}
                                        </div>
                                    @endif
                                </div>

                                <!-- View Profile Button -->
                                <a href="{{ route('members.show', $user) }}" 
                                   class="btn text-slate-900 bg-gradient-to-r from-white/80 via-white to-white/80 hover:bg-white w-full text-sm group/btn">
                                    {{ __('View Profile') }}
                                    <span class="tracking-normal text-purple-500 group-hover/btn:translate-x-0.5 transition-transform duration-150 ease-in-out ml-1">→</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($users->hasPages())
                    <div class="mt-12">
                        {{ $users->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-16">
                    <div class="w-20 h-20 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-100 mb-2">{{ __('No members found') }}</h3>
                    <p class="text-slate-400">{{ __('Try adjusting your search criteria') }}</p>
                </div>
            @endif
        </div>
    </section>
</x-layouts.app>
