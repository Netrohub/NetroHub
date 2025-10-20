<!-- NXO Account Sidebar Component -->
<div class="lg:w-1/4 mb-8 lg:mb-0">
    <div class="card-hover p-6">
        <h3 class="text-lg font-semibold text-foreground mb-4">{{ __('Account Menu') }}</h3>
        <nav class="space-y-2">
            <a href="{{ route('account.index') }}" class="block px-3 py-2 text-sm text-muted-foreground hover:text-primary transition-colors rounded-lg {{ request()->routeIs('account.index') ? 'bg-primary/10 text-primary' : '' }}">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"/>
                </svg>
                {{ __('Dashboard') }}
            </a>
            <a href="{{ route('account.orders') }}" class="block px-3 py-2 text-sm text-muted-foreground hover:text-primary transition-colors rounded-lg {{ request()->routeIs('account.orders') ? 'bg-primary/10 text-primary' : '' }}">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                {{ __('Orders') }}
            </a>
            <a href="{{ route('account.sales') }}" class="block px-3 py-2 text-sm text-muted-foreground hover:text-primary transition-colors rounded-lg {{ request()->routeIs('account.sales') ? 'bg-primary/10 text-primary' : '' }}">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
                {{ __('Sales') }}
            </a>
            <a href="{{ route('account.wallet') }}" class="block px-3 py-2 text-sm text-muted-foreground hover:text-primary transition-colors rounded-lg {{ request()->routeIs('account.wallet') ? 'bg-primary/10 text-primary' : '' }}">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                </svg>
                {{ __('Wallet') }}
            </a>
            <a href="{{ route('account.payouts') }}" class="block px-3 py-2 text-sm text-muted-foreground hover:text-primary transition-colors rounded-lg {{ request()->routeIs('account.payouts') ? 'bg-primary/10 text-primary' : '' }}">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                {{ __('Payouts') }}
            </a>
            <a href="{{ route('account.notifications') }}" class="block px-3 py-2 text-sm text-muted-foreground hover:text-primary transition-colors rounded-lg {{ request()->routeIs('account.notifications') ? 'bg-primary/10 text-primary' : '' }}">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.828 7l2.586 2.586a2 2 0 002.828 0L12 7H4.828z"/>
                </svg>
                {{ __('Notifications') }}
            </a>
            <a href="{{ route('account.challenges') }}" class="block px-3 py-2 text-sm text-muted-foreground hover:text-primary transition-colors rounded-lg {{ request()->routeIs('account.challenges') ? 'bg-primary/10 text-primary' : '' }}">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                </svg>
                {{ __('Challenges') }}
            </a>
        </nav>
    </div>
</div>
