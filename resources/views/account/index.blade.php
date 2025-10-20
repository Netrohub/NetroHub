<x-layouts.app>
    <x-slot name="title">{{ __('My Account') }} - {{ config('app.name') }}</x-slot>

    <!-- Hero -->
    <section class="relative pt-32 pb-12">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-foreground mb-2">
                        {{ __('Welcome,') }} {{ auth()->user()->name }}
                    </h1>
                    <p class="text-muted-foreground">{{ __('Manage your account and track your activities') }}</p>
                </div>
                @if($seller ?? false)
                <a href="{{ route('seller.dashboard') }}" class="btn-primary mt-4 md:mt-0">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    {{ __('Seller Dashboard') }}
                </a>
                @else
                <a href="{{ route('sell.index') }}" class="btn-secondary mt-4 md:mt-0">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    {{ __('Start Selling') }}
                </a>
                @endif
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-muted-foreground text-sm font-medium">{{ __('Total Orders') }}</span>
                            <div class="w-10 h-10 bg-primary/20 rounded-lg flex items-center justify-center mt-2">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-foreground">{{ $totalOrders ?? 0 }}</div>
                            <div class="text-xs text-muted-foreground">{{ __('All time purchases') }}</div>
                        </div>
                    </div>
                </div>

                <div class="card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-muted-foreground text-sm font-medium">{{ __('Wallet Balance') }}</span>
                            <div class="w-10 h-10 bg-green-500/20 rounded-lg flex items-center justify-center mt-2">
                                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                </svg>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-foreground">{{ number_format($walletBalance ?? 0, 2) }} SAR</div>
                            <div class="text-xs text-muted-foreground">{{ __('Available funds') }}</div>
                        </div>
                    </div>
                </div>

                <div class="card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-muted-foreground text-sm font-medium">{{ __('Total Sales') }}</span>
                            <div class="w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center mt-2">
                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                </svg>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-foreground">{{ number_format($totalSales ?? 0, 2) }} SAR</div>
                            <div class="text-xs text-muted-foreground">{{ __('Earnings to date') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="card-hover mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-foreground">{{ __('Recent Orders') }}</h2>
                    <a href="{{ route('account.orders') }}" class="text-primary hover:text-primary/80 text-sm font-medium flex items-center">
                        {{ __('View All') }}
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                @if($recentOrders && $recentOrders->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentOrders as $order)
                            <div class="flex items-center justify-between p-4 bg-muted/30 rounded-xl hover:bg-muted/50 transition-colors">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-muted rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-foreground font-medium">{{ __('Order #:id', ['id' => $order->id]) }}</div>
                                        <div class="text-sm text-muted-foreground">{{ $order->created_at->format('M d, Y') }} • {{ $order->items->count() }} {{ __('items') }}</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-foreground font-medium">{{ number_format($order->total, 2) }} SAR</div>
                                    <div class="text-sm text-muted-foreground">
                                        @if($order->status === 'completed')
                                            <span class="text-green-500">{{ __('Completed') }}</span>
                                        @elseif($order->status === 'pending')
                                            <span class="text-yellow-500">{{ __('Pending') }}</span>
                                        @else
                                            <span class="text-muted-foreground">{{ ucfirst($order->status) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-muted rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <p class="text-muted-foreground mb-4">{{ __('No orders yet') }}</p>
                        <a href="{{ route('products.index') }}" class="btn-primary inline-flex">
                            {{ __('Browse Products') }}
                        </a>
                    </div>
                @endif
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <a href="{{ route('products.index') }}" class="card-hover group">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-foreground">{{ __('Browse Products') }}</h3>
                            <svg class="w-6 h-6 text-primary group-hover:translate-x-1 transition-transform mt-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-muted-foreground text-sm mt-2">{{ __('Discover new digital products and services') }}</p>
                </a>

                <a href="{{ route('account.wallet') }}" class="card-hover group">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-foreground">{{ __('Manage Wallet') }}</h3>
                            <svg class="w-6 h-6 text-green-500 group-hover:translate-x-1 transition-transform mt-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-muted-foreground text-sm mt-2">{{ __('View transactions and request payouts') }}</p>
                </a>
            </div>

            <!-- Account Settings -->
            <div class="card-hover">
                <h2 class="text-xl font-bold text-foreground mb-6">{{ __('Account Settings') }}</h2>
                
                <form action="{{ route('account.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Profile Avatar -->
                    <div class="mb-6">
                        <label class="block text-sm text-foreground font-medium mb-3">{{ __('Profile Avatar') }}</label>
                        <div class="flex items-center space-x-4">
                            <div id="avatar-preview" class="w-24 h-24 rounded-2xl overflow-hidden bg-muted border-2 border-border">
                                @if(auth()->user()->avatar_url)
                                    <img src="{{ auth()->user()->avatar_url }}" alt="Avatar" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-muted-foreground text-2xl font-bold">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div>
                                <input type="file" id="avatar-input" name="avatar" accept="image/*" class="hidden" onchange="previewAvatar(this)">
                                <label for="avatar-input" class="btn-primary cursor-pointer inline-flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ __('Change Avatar') }}
                                </label>
                                <p class="text-xs text-muted-foreground mt-2">{{ __('JPG, PNG or GIF. Max 5MB.') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-border mb-6"></div>

                    <!-- Form Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm text-foreground font-medium mb-2">{{ __('Username') }} <span class="text-red-400">*</span></label>
                            <input type="text" name="username" value="{{ old('username', auth()->user()->username) }}" class="form-input w-full" required>
                            <p class="text-xs text-muted-foreground mt-1">{{ __('Your unique username') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm text-foreground font-medium mb-2">{{ __('Display Name') }}</label>
                            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="form-input w-full">
                            <p class="text-xs text-muted-foreground mt-1">{{ __('Public display name (seller profile)') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm text-foreground font-medium mb-2">{{ __('Email') }} <span class="text-red-400">*</span></label>
                            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="form-input w-full" required>
                        </div>

                        <div>
                            <label class="block text-sm text-foreground font-medium mb-2">{{ __('Phone Number') }}</label>
                            <input type="tel" name="phone" value="{{ old('phone', auth()->user()->phone) }}" class="form-input w-full">
                            <p class="text-xs text-muted-foreground mt-1">{{ __('Include country code') }}</p>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm text-foreground font-medium mb-2">{{ __('Bio / Tagline') }}</label>
                            <textarea name="bio" rows="3" class="form-input w-full" placeholder="{{ __('Tell us about yourself...') }}">{{ old('bio', auth()->user()->bio) }}</textarea>
                            <p class="text-xs text-muted-foreground mt-1">{{ __('This will be shown on your seller profile') }}</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="btn-primary">
                            {{ __('Update Profile') }}
                        </button>
                    </div>
                </form>
            </div>

            <!-- Account Information -->
            <div class="card-hover mt-8">
                <h2 class="text-xl font-bold text-foreground mb-6">{{ __('Account Information') }}</h2>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between py-3 border-b border-border">
                        <div>
                            <div class="text-sm text-muted-foreground">{{ __('Account Status') }}</div>
                        </div>
                        <div class="text-foreground font-medium">
                            @if(auth()->user()->is_verified)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ __('Verified') }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    {{ __('Unverified') }}
                                </span>
                                <a href="{{ route('account.verification.checklist') }}" class="btn-primary ml-2">{{ __('Complete Verification') }}</a>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center justify-between py-3 border-b border-border">
                        <div>
                            <div class="text-sm text-muted-foreground">{{ __('Member Since') }}</div>
                        </div>
                        <div class="text-foreground font-medium">{{ auth()->user()->created_at->format('F j, Y') }}</div>
                    </div>

                    <div class="flex items-center justify-between py-3">
                        <div>
                            <div class="text-sm text-muted-foreground">{{ __('Account ID') }}</div>
                        </div>
                        <div class="text-foreground font-medium font-mono text-sm">#{{ str_pad(auth()->user()->id, 6, '0', STR_PAD_LEFT) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
    <script>
        function previewAvatar(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatar-preview').innerHTML = '<img src="' + e.target.result + '" alt="Avatar" class="w-full h-full object-cover">';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    @endpush
</x-layouts.app>