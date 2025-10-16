<header class="absolute w-full z-30">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="flex items-center justify-between h-16 md:h-20">

            <!-- Site branding -->
            <div class="flex-1">
                <a class="inline-flex items-center" href="{{ route('home') }}" aria-label="{{ config('app.name') }}">
                    <svg class="w-8 h-8 fill-current text-purple-500" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                        <path d="M31.952 14.751a260.51 260.51 0 00-4.359-4.407C23.932 6.734 20.16 3.182 16.171 0c1.634.017 3.21.28 4.692.751 3.487 3.114 6.846 6.398 10.163 9.737.493 1.346.811 2.776.926 4.262zm-1.388 7.883c-2.496-2.597-5.051-5.12-7.737-7.471-3.706-3.246-10.693-9.81-15.736-7.418-4.552 2.158-4.717 10.543-4.96 16.238A15.926 15.926 0 010 16C0 9.799 3.528 4.421 8.686 1.766c1.82.593 3.593 1.675 5.038 2.587 6.569 4.14 12.29 9.71 17.792 15.57-.237.94-.557 1.846-.952 2.711zm-4.505 5.81a56.161 56.161 0 00-1.007-.823c-2.574-2.054-6.087-4.805-9.394-4.044-3.022.695-4.264 4.267-4.97 7.52a15.945 15.945 0 01-3.665-1.85c.366-3.242.89-6.675 2.405-9.364 2.315-4.107 6.287-3.072 9.613-1.132 3.36 1.96 6.417 4.572 9.313 7.417a16.097 16.097 0 01-2.295 2.275z" />
                    </svg>
                    <span class="ml-4 text-xl font-bold text-slate-100">{{ \App\Models\SiteSetting::get('site_name', config('app.name')) }}</span>
                </a>
            </div>

            <!-- Desktop navigation -->
            <nav class="hidden md:flex md:grow">
                <!-- Desktop menu links -->
                <ul class="flex grow justify-center flex-wrap items-center">
                    <li>
                        <a class="font-medium text-sm text-slate-300 hover:text-white mx-4 lg:mx-5 transition duration-150 ease-in-out" href="{{ route('products.index') }}">{{ __('Products') }}</a>
                    </li>
                    <li>
                        <a class="font-medium text-sm text-slate-300 hover:text-white mx-4 lg:mx-5 transition duration-150 ease-in-out" href="{{ route('pricing.index') }}">{{ __('Pricing') }}</a>
                    </li>
                    <li>
                        <a class="font-medium text-sm text-slate-300 hover:text-white mx-4 lg:mx-5 transition duration-150 ease-in-out" href="{{ route('members.index') }}">{{ __('Members') }}</a>
                    </li>
                    @auth
                        <li>
                            <a class="font-medium text-sm text-slate-300 hover:text-white mx-4 lg:mx-5 transition duration-150 ease-in-out" href="{{ route('account.index') }}">{{ __('Dashboard') }}</a>
                        </li>
                    @endauth
                </ul>
            </nav>

            <!-- Desktop sign in links -->
            <ul class="hidden md:flex flex-1 justify-end items-center">
                @guest
                    <li class="flex items-center gap-3">
                        <a href="{{ route('login') }}" class="group relative px-3 py-1.5 rounded-md text-xs font-medium text-slate-300 hover:text-white transition-all duration-300 flex items-center justify-center border border-slate-600/50 hover:border-purple-500/50 hover:bg-slate-800/30 backdrop-blur-sm">
                            <svg class="w-3 h-3 mr-1.5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            {{ __('تسجيل الدخول') }}
                            <div class="absolute inset-0 rounded-md bg-gradient-to-r from-transparent via-white/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </a>
                        
                        <a href="{{ route('register') }}" class="group relative px-3 py-1.5 rounded-md text-xs font-bold text-white transition-all duration-300 flex items-center justify-center bg-gradient-to-r from-purple-600 to-purple-500 hover:from-purple-500 hover:to-purple-400 shadow-md hover:shadow-purple-500/25 transform hover:scale-105">
                            <svg class="w-3 h-3 mr-1.5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            {{ __('إنشاء حساب') }}
                            <svg class="w-2.5 h-2.5 ml-1 group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 12 12">
                                <path d="M4 8L8 4m0 0l4 4M8 4v8" stroke="currentColor" stroke-width="2" fill="none"/>
                            </svg>
                            <div class="absolute inset-0 rounded-md bg-gradient-to-r from-white/10 via-white/20 to-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </a>
                    </li>
                @else
                    <li class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center text-slate-300 hover:text-white transition duration-150 ease-in-out">
                            <span class="mr-2">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 12 12">
                                <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-slate-800 rounded-lg border border-slate-700 py-2 shadow-xl z-50">
                            <a href="{{ route('account.index') }}" class="block px-4 py-2 text-sm text-slate-300 hover:bg-slate-700 hover:text-white">{{ __('Dashboard') }}</a>
                            <a href="{{ route('account.orders') }}" class="block px-4 py-2 text-sm text-slate-300 hover:bg-slate-700 hover:text-white">{{ __('Orders') }}</a>
                            <a href="{{ route('cart.index') }}" class="block px-4 py-2 text-sm text-slate-300 hover:bg-slate-700 hover:text-white">{{ __('Cart') }}</a>
                            <div class="border-t border-slate-700 my-2"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-slate-300 hover:bg-slate-700 hover:text-white">{{ __('Log out') }}</button>
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>

            <!-- Mobile menu -->
            <div class="md:hidden ml-4" x-data="{ mobileMenuOpen: false }">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="hamburger" :class="{ 'active': mobileMenuOpen }">
                    <span class="sr-only">Menu</span>
                    <svg class="w-6 h-6 fill-current text-slate-300 hover:text-white transition duration-150 ease-in-out" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <rect y="4" width="24" height="2" rx="1" />
                        <rect y="11" width="24" height="2" rx="1" />
                        <rect y="18" width="24" height="2" rx="1" />
                    </svg>
                </button>

                <!-- Mobile navigation -->
                <nav x-show="mobileMenuOpen" x-transition class="fixed top-0 left-0 w-full h-screen bg-slate-900 z-50 overflow-auto">
                    <div class="px-4 py-6">
                        <div class="flex items-center justify-between mb-8">
                            <a class="inline-flex" href="{{ route('home') }}">
                                <svg class="w-8 h-8 fill-current text-purple-500" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M31.952 14.751a260.51 260.51 0 00-4.359-4.407C23.932 6.734 20.16 3.182 16.171 0c1.634.017 3.21.28 4.692.751 3.487 3.114 6.846 6.398 10.163 9.737.493 1.346.811 2.776.926 4.262zm-1.388 7.883c-2.496-2.597-5.051-5.12-7.737-7.471-3.706-3.246-10.693-9.81-15.736-7.418-4.552 2.158-4.717 10.543-4.96 16.238A15.926 15.926 0 010 16C0 9.799 3.528 4.421 8.686 1.766c1.82.593 3.593 1.675 5.038 2.587 6.569 4.14 12.29 9.71 17.792 15.57-.237.94-.557 1.846-.952 2.711zm-4.505 5.81a56.161 56.161 0 00-1.007-.823c-2.574-2.054-6.087-4.805-9.394-4.044-3.022.695-4.264 4.267-4.97 7.52a15.945 15.945 0 01-3.665-1.85c.366-3.242.89-6.675 2.405-9.364 2.315-4.107 6.287-3.072 9.613-1.132 3.36 1.96 6.417 4.572 9.313 7.417a16.097 16.097 0 01-2.295 2.275z" />
                                </svg>
                            </a>
                            <button @click="mobileMenuOpen = false" class="text-slate-400 hover:text-slate-200">
                                <span class="sr-only">Close</span>
                                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18.707 5.293a1 1 0 00-1.414 0L12 10.586 6.707 5.293a1 1 0 00-1.414 1.414L10.586 12l-5.293 5.293a1 1 0 101.414 1.414L12 13.414l5.293-5.293a1 1 0 000-1.414z" />
                                </svg>
                            </button>
                        </div>
                        <ul class="space-y-4">
                            <li><a class="text-slate-300 hover:text-white text-lg transition duration-150 ease-in-out" href="{{ route('products.index') }}">{{ __('Products') }}</a></li>
                            <li><a class="text-slate-300 hover:text-white text-lg transition duration-150 ease-in-out" href="{{ route('pricing.index') }}">{{ __('Pricing') }}</a></li>
                            <li><a class="text-slate-300 hover:text-white text-lg transition duration-150 ease-in-out" href="{{ route('members.index') }}">{{ __('Members') }}</a></li>
                            @auth
                                <li><a class="text-slate-300 hover:text-white text-lg transition duration-150 ease-in-out" href="{{ route('account.index') }}">{{ __('Dashboard') }}</a></li>
                                <li><a class="text-slate-300 hover:text-white text-lg transition duration-150 ease-in-out" href="{{ route('cart.index') }}">{{ __('Cart') }}</a></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="text-slate-300 hover:text-white text-lg transition duration-150 ease-in-out">{{ __('Log out') }}</button>
                                    </form>
                                </li>
                            @else
                                <!-- Mobile Auth Buttons - Enhanced -->
                                <div class="space-y-3 pt-4 border-t border-slate-700">
                                    <a href="{{ route('login') }}" class="group block w-full px-4 py-3 text-center text-slate-300 hover:text-white bg-slate-800/50 hover:bg-slate-800/70 border border-slate-600/50 hover:border-purple-500/50 rounded-lg text-sm font-medium transition-all duration-300 flex items-center justify-center shadow-sm hover:shadow-md">
                                        <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }} group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        {{ __('تسجيل الدخول') }}
                                        <div class="absolute inset-0 rounded-lg bg-gradient-to-r from-transparent via-white/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    </a>
                                    
                                    <a href="{{ route('register') }}" class="group relative block w-full px-4 py-3 text-center bg-gradient-to-r from-purple-600 via-purple-500 to-blue-500 hover:from-purple-500 hover:via-purple-400 hover:to-blue-400 text-white rounded-lg text-sm font-bold transition-all duration-300 shadow-lg hover:shadow-purple-500/25 transform hover:scale-105 flex items-center justify-center">
                                        <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }} group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                        </svg>
                                        {{ __('إنشاء حساب') }}
                                        <svg class="w-3 h-3 {{ app()->getLocale() === 'ar' ? 'mr-1' : 'ml-1' }} group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 12 12">
                                            <path d="M4 8L8 4m0 0l4 4M8 4v8" stroke="currentColor" stroke-width="2" fill="none"/>
                                        </svg>
                                        <div class="absolute inset-0 rounded-lg bg-gradient-to-r from-white/10 via-white/20 to-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    </a>
                                </div>
                            @endguest
                        </ul>
                    </div>
                </nav>
            </div>

        </div>
    </div>
</header>

