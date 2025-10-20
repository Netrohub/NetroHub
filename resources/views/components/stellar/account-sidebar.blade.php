<!-- Account Sidebar Component -->
<div class="w-full md:w-64 bg-card/50 backdrop-blur-sm border border-border/50 rounded-2xl p-6">
    <nav class="space-y-2">
        <a href="{{ route('account.index') }}" class="flex items-center px-4 py-3 rounded-lg text-foreground/70 hover:text-primary hover:bg-primary/10 transition-colors {{ request()->routeIs('account.index') ? 'text-primary bg-primary/10' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            {{ __('Dashboard') }}
        </a>
        
        <a href="{{ route('account.orders') }}" class="flex items-center px-4 py-3 rounded-lg text-foreground/70 hover:text-primary hover:bg-primary/10 transition-colors {{ request()->routeIs('account.orders') ? 'text-primary bg-primary/10' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            {{ __('Orders') }}
        </a>
        
        <a href="{{ route('account.wallet') }}" class="flex items-center px-4 py-3 rounded-lg text-foreground/70 hover:text-primary hover:bg-primary/10 transition-colors {{ request()->routeIs('account.wallet') ? 'text-primary bg-primary/10' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
            </svg>
            {{ __('Wallet') }}
        </a>
        
        <a href="{{ route('account.notifications') }}" class="flex items-center px-4 py-3 rounded-lg text-foreground/70 hover:text-primary hover:bg-primary/10 transition-colors {{ request()->routeIs('account.notifications') ? 'text-primary bg-primary/10' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.828 7l2.586 2.586a2 2 0 002.828 0L12 7H4.828z"/>
            </svg>
            {{ __('Notifications') }}
        </a>
        
        <a href="{{ route('account.sales') }}" class="flex items-center px-4 py-3 rounded-lg text-foreground/70 hover:text-primary hover:bg-primary/10 transition-colors {{ request()->routeIs('account.sales') ? 'text-primary bg-primary/10' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
            </svg>
            {{ __('Sales') }}
        </a>
        
        <a href="{{ route('account.payouts') }}" class="flex items-center px-4 py-3 rounded-lg text-foreground/70 hover:text-primary hover:bg-primary/10 transition-colors {{ request()->routeIs('account.payouts') ? 'text-primary bg-primary/10' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
            </svg>
            {{ __('Payouts') }}
        </a>
        
        <a href="{{ route('account.challenges') }}" class="flex items-center px-4 py-3 rounded-lg text-foreground/70 hover:text-primary hover:bg-primary/10 transition-colors {{ request()->routeIs('account.challenges') ? 'text-primary bg-primary/10' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
            </svg>
            {{ __('Challenges') }}
        </a>
    </nav>
</div>
