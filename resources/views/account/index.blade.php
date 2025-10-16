<x-layouts.stellar>
    <x-slot name="title">{{ __('My Account') }} - {{ config('app.name') }}</x-slot>

    <!-- Hero -->
    <section class="relative pt-32 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                <div>
                    <h1 class="h2 bg-clip-text text-transparent bg-gradient-to-r from-slate-200/60 via-slate-200 to-slate-200/60 mb-2">
                        {{ __('أهلًا وسهلًا,') }} {{ auth()->user()->name }}
                    </h1>
                    <p class="text-slate-400">{{ __('أدِر حسابك وتابع أنشطتك') }}</p>
                </div>
                @if($seller ?? false)
                <a href="{{ route('seller.dashboard') }}" class="btn text-white bg-purple-500 hover:bg-purple-600 mt-4 md:mt-0">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    {{ __('Seller Dashboard') }}
                </a>
                @else
                <a href="{{ route('sell.index') }}" class="btn text-slate-900 bg-gradient-to-r from-white/80 via-white to-white/80 hover:bg-white mt-4 md:mt-0">
                    {{ __('Start Selling') }}
                </a>
                @endif
            </div>

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="bg-green-500/10 border border-green-500/50 text-green-300 px-6 py-4 rounded-2xl mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-500/10 border border-red-500/50 text-red-300 px-6 py-4 rounded-2xl mb-6">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <ul class="list-disc list-inside space-y-1 text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Verification Banner -->
            <x-stellar.verification-banner :user="auth()->user()" />
        </div>
    </section>

    <!-- Account Content -->
    <section class="relative pb-12 md:pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="lg:flex lg:gap-8">
                
                <!-- Sidebar -->
                <x-stellar.account-sidebar />

                <!-- Main Content -->
                <div class="flex-1 min-w-0 space-y-8">
                    
                    @if(request('tab') !== 'settings')
                    <!-- Stats Grid -->
                    <div class="grid md:grid-cols-3 gap-6">
                        <!-- Total Orders -->
                        <div class="bg-slate-800/50 rounded-2xl p-6 border border-slate-700/50 hover:border-purple-500/30 transition-colors" data-aos="fade-up">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-slate-400 text-sm font-medium">{{ __('Total Orders') }}</span>
                                <div class="w-10 h-10 bg-purple-500/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="text-3xl font-bold text-white mb-1">{{ $totalOrders ?? auth()->user()->orders()->count() }}</div>
                            <div class="text-xs text-slate-400">{{ __('All time purchases') }}</div>
                        </div>

                        <!-- Wallet Balance -->
                        <div class="bg-slate-800/50 rounded-2xl p-6 border border-slate-700/50 hover:border-green-500/30 transition-colors" data-aos="fade-up" data-aos-delay="100">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-slate-400 text-sm font-medium">{{ __('Wallet Balance') }}</span>
                                <div class="w-10 h-10 bg-green-500/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="text-3xl font-bold text-white mb-1">${{ number_format(auth()->user()->wallet_balance ?? 0, 2) }}</div>
                            <div class="text-xs text-slate-400">{{ __('Available funds') }}</div>
                        </div>

                        <!-- Total Sales -->
                        <div class="bg-slate-800/50 rounded-2xl p-6 border border-slate-700/50 hover:border-blue-500/30 transition-colors" data-aos="fade-up" data-aos-delay="200">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-slate-400 text-sm font-medium">{{ __('Total Sales') }}</span>
                                <div class="w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="text-3xl font-bold text-white mb-1">${{ number_format($totalSales ?? 0, 2) }}</div>
                            <div class="text-xs text-slate-400">{{ __('Earnings to date') }}</div>
                        </div>
                    </div>

                    <!-- Recent Orders -->
                    <div class="bg-slate-800/50 rounded-2xl p-6 lg:p-8 border border-slate-700/50" data-aos="fade-up" data-aos-delay="300">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-bold text-slate-100">{{ __('Recent Orders') }}</h2>
                            <a href="{{ route('account.orders') }}" class="text-purple-400 hover:text-purple-300 text-sm font-medium flex items-center">
                                {{ __('View All') }}
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>

                        @if(isset($recentOrders) && $recentOrders->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentOrders as $order)
                                    <div class="flex items-center justify-between p-4 bg-slate-700/30 rounded-xl hover:bg-slate-700/50 transition-colors">
                                        <div class="flex items-center gap-4 flex-1">
                                            <div class="w-12 h-12 bg-slate-700 rounded-lg flex items-center justify-center">
                                                <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="text-slate-100 font-medium">{{ __('Order #:id', ['id' => $order->id]) }}</div>
                                                <div class="text-sm text-slate-400">{{ $order->created_at->format('M d, Y') }} • {{ $order->items->count() }} {{ __('items') }}</div>
                                            </div>
                                        </div>
                                        <div class="text-right flex-shrink-0">
                                            <div class="text-white font-bold mb-1">${{ number_format($order->total, 2) }}</div>
                                            <span class="text-xs px-2 py-1 rounded-full {{ $order->status === 'completed' ? 'bg-green-500/20 text-green-400' : ($order->status === 'pending' ? 'bg-yellow-500/20 text-yellow-400' : 'bg-red-500/20 text-red-400') }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="w-16 h-16 bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                </div>
                                <p class="text-slate-400 mb-4">{{ __('No orders yet') }}</p>
                                <a href="{{ route('products.index') }}" class="btn text-slate-900 bg-gradient-to-r from-white/80 via-white to-white/80 hover:bg-white inline-flex">
                                    {{ __('Browse Products') }}
                                </a>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Quick Actions -->
                    <div class="grid md:grid-cols-2 gap-6" data-aos="fade-up" data-aos-delay="400">
                        <a href="{{ route('products.index') }}" class="bg-gradient-to-br from-purple-500/10 to-purple-600/10 rounded-2xl p-6 border border-purple-500/30 hover:border-purple-500/50 transition-all group">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-lg font-bold text-slate-100">{{ __('Browse Products') }}</h3>
                                <svg class="w-6 h-6 text-purple-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </div>
                            <p class="text-slate-400 text-sm">{{ __('Discover new digital products and services') }}</p>
                        </a>

                        <a href="{{ route('account.wallet') }}" class="bg-gradient-to-br from-green-500/10 to-green-600/10 rounded-2xl p-6 border border-green-500/30 hover:border-green-500/50 transition-all group">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-lg font-bold text-slate-100">{{ __('Manage Wallet') }}</h3>
                                <svg class="w-6 h-6 text-green-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </div>
                            <p class="text-slate-400 text-sm">{{ __('View transactions and request payouts') }}</p>
                        </a>
                    </div>
                    @endif

                    @if(request('tab') === 'settings')
                    <!-- Profile Information -->
                    <div id="account-settings" class="bg-slate-800/50 rounded-2xl p-6 lg:p-8 border border-slate-700/50" data-aos="fade-up" data-aos-delay="500">
                        <h2 class="text-xl font-bold text-slate-100 mb-6">{{ __('Account Settings') }}</h2>
                        
                        <form action="{{ route('account.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <!-- Avatar Upload Section -->
                            <div class="mb-8">
                                <label class="block text-sm text-slate-300 font-medium mb-3">{{ __('Profile Avatar') }}</label>
                                <div class="flex items-center gap-6">
                                    <!-- Current Avatar -->
                                    <div class="relative">
                                        <div id="avatar-preview" class="w-24 h-24 rounded-2xl overflow-hidden bg-slate-700 border-2 border-slate-600">
                                            @if(auth()->user()->avatar_url)
                                                <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-slate-400 text-2xl font-bold">
                                                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Upload Button -->
                                    <div class="flex-1">
                                        <input type="file" name="avatar" id="avatar-input" accept="image/*" class="hidden">
                                        <label for="avatar-input" class="btn text-white bg-purple-500 hover:bg-purple-600 cursor-pointer inline-flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            {{ __('Upload Avatar') }}
                                        </label>
                                        <p class="text-xs text-slate-400 mt-2">{{ __('JPG, PNG or GIF. Max 5MB.') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="border-t border-slate-700 mb-6"></div>
                            
                            <!-- Form Fields -->
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm text-slate-300 font-medium mb-2">{{ __('Username') }} <span class="text-red-400">*</span></label>
                                    <input type="text" name="username" value="{{ old('username', auth()->user()->username ?? '') }}" class="form-input w-full" required>
                                    <p class="text-xs text-slate-400 mt-1">{{ __('Your unique username') }}</p>
                                    @error('username')
                                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm text-slate-300 font-medium mb-2">{{ __('Display Name') }}</label>
                                    <input type="text" name="display_name" value="{{ old('display_name', $seller->display_name ?? auth()->user()->name) }}" class="form-input w-full">
                                    <p class="text-xs text-slate-400 mt-1">{{ __('Public display name (seller profile)') }}</p>
                                    @error('display_name')
                                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm text-slate-300 font-medium mb-2">{{ __('Email') }} <span class="text-red-400">*</span></label>
                                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="form-input w-full" required>
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm text-slate-300 font-medium mb-2">{{ __('Phone Number') }}</label>
                                    <input type="tel" name="phone" value="{{ old('phone', auth()->user()->phone) }}" class="form-input w-full" placeholder="+971501234567">
                                    <p class="text-xs text-slate-400 mt-1">{{ __('Include country code') }}</p>
                                    @error('phone')
                                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm text-slate-300 font-medium mb-2">{{ __('Bio / Tagline') }}</label>
                                    <textarea name="tagline" rows="4" class="form-textarea w-full" placeholder="{{ __('Tell us about yourself...') }}">{{ old('tagline', $seller->bio ?? '') }}</textarea>
                                    <p class="text-xs text-slate-400 mt-1">{{ __('This will be shown on your seller profile') }}</p>
                                    @error('tagline')
                                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-8 flex items-center gap-4">
                                <button type="submit" class="btn text-white bg-purple-500 hover:bg-purple-600 shadow-lg">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    {{ __('Save Changes') }}
                                </button>
                                <a href="{{ route('account.index') }}" class="btn-secondary">
                                    {{ __('Cancel') }}
                                </a>
                            </div>
                        </form>
                    </div>

                    <!-- Account Information -->
                    <div class="bg-slate-800/50 rounded-2xl p-6 lg:p-8 border border-slate-700/50" data-aos="fade-up" data-aos-delay="600">
                        <h2 class="text-xl font-bold text-slate-100 mb-6">{{ __('Account Information') }}</h2>
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between py-3 border-b border-slate-700">
                                <div>
                                    <div class="text-sm text-slate-400">{{ __('Account Status') }}</div>
                                    <div class="text-slate-200 font-medium">
                                        @php($emailVerified = (bool) auth()->user()->email_verified_at)
                                        @php($phoneVerified = method_exists(auth()->user(), 'isPhoneVerified') ? auth()->user()->isPhoneVerified() : false)
                                        @php($kycVerified = auth()->user()->seller && method_exists(auth()->user()->seller, 'isKycVerified') ? auth()->user()->seller->isKycVerified() : false)
                                        @if($emailVerified && $phoneVerified && $kycVerified)
                                            <span class="inline-flex items-center gap-1.5 text-green-400">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                                {{ __('Verified') }}
                                            </span>
                                        @else
                                            <div class="flex items-center gap-3">
                                                <span class="inline-flex items-center gap-1.5 text-yellow-400">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                                    {{ __('Unverified') }}
                                                </span>
                                                <a href="{{ route('account.verification.checklist') }}" class="btn btn-xs text-white bg-purple-500 hover:bg-purple-600">{{ __('Complete Verification') }}</a>
                                            </div>
                                            <div class="mt-2 text-xs text-slate-400">
                                                {{ __('Email') }}: {{ $emailVerified ? __('Verified') : __('Pending') }} • {{ __('Phone') }}: {{ $phoneVerified ? __('Verified') : __('Pending') }} • {{ __('KYC') }}: {{ $kycVerified ? __('Verified') : __('Pending') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between py-3 border-b border-slate-700">
                                <div>
                                    <div class="text-sm text-slate-400">{{ __('Member Since') }}</div>
                                    <div class="text-slate-200 font-medium">{{ auth()->user()->created_at->format('F j, Y') }}</div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between py-3">
                                <div>
                                    <div class="text-sm text-slate-400">{{ __('Account ID') }}</div>
                                    <div class="text-slate-200 font-medium font-mono text-sm">#{{ str_pad(auth()->user()->id, 6, '0', STR_PAD_LEFT) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
    <script>
        // If tab=settings, scroll to the settings section smoothly
        (function() {
            const params = new URLSearchParams(window.location.search);
            if (params.get('tab') === 'settings') {
                const el = document.getElementById('account-settings');
                if (el) {
                    el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        })();

        // Avatar preview functionality
        document.getElementById('avatar-input').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('avatar-preview');
                    preview.innerHTML = `<img src="${e.target.result}" alt="Avatar Preview" class="w-full h-full object-cover">`;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
    @endpush
</x-layouts.stellar>
