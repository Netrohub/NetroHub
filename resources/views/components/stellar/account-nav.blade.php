<nav class="space-y-1">
    <a href="{{ route('account.index') }}" 
       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('account.index') && request('tab') !== 'settings' ? 'bg-purple-500 text-white shadow-lg shadow-purple-500/25' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        <span class="font-medium">{{ __('Dashboard') }}</span>
    </a>

    <a href="{{ route('account.orders') }}" 
       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('account.orders') ? 'bg-purple-500 text-white shadow-lg shadow-purple-500/25' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
        </svg>
        <span class="font-medium">{{ __('My Orders') }}</span>
    </a>

    <a href="{{ route('disputes.index') }}" 
       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('disputes.*') ? 'bg-purple-500 text-white shadow-lg shadow-purple-500/25' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
        </svg>
        <span class="font-medium">{{ __('Disputes') }}</span>
    </a>

    <a href="{{ route('account.sales') }}" 
       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('account.sales') ? 'bg-purple-500 text-white shadow-lg shadow-purple-500/25' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 8h6m-5 0a3 3 0 110 6H9l3 3m-3-6h6m6 1a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span class="font-medium">{{ __('My Sales') }}</span>
    </a>

    <a href="{{ route('account.wallet') }}" 
       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('account.wallet') ? 'bg-purple-500 text-white shadow-lg shadow-purple-500/25' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
        </svg>
        <span class="font-medium">{{ __('Wallet') }}</span>
    </a>

    <a href="{{ route('account.payouts') }}" 
       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('account.payouts') ? 'bg-purple-500 text-white shadow-lg shadow-purple-500/25' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
        </svg>
        <span class="font-medium">{{ __('Payouts') }}</span>
    </a>

    <a href="{{ route('account.notifications') }}" 
       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('account.notifications') ? 'bg-purple-500 text-white shadow-lg shadow-purple-500/25' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>
        <span class="font-medium">{{ __('Notifications') }}</span>
        @if(isset($unreadNotifications) && $unreadNotifications > 0)
            <span class="ml-auto bg-purple-500 text-white text-xs font-bold px-2 py-1 rounded-full">{{ $unreadNotifications }}</span>
        @endif
    </a>

    <a href="{{ route('account.challenges') }}" 
       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('account.challenges') ? 'bg-purple-500 text-white shadow-lg shadow-purple-500/25' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
        </svg>
        <span class="font-medium">{{ __('Challenges') }}</span>
    </a>

    <div class="border-t border-slate-700 my-4"></div>

    <a href="{{ route('account.index', ['tab' => 'settings']) }}#account-settings" 
       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('account.index') && request('tab') === 'settings' ? 'bg-purple-500 text-white shadow-lg shadow-purple-500/25' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        <span class="font-medium">{{ __('Settings') }}</span>
    </a>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="w-full flex items-center px-4 py-3 rounded-lg text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-colors">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            <span class="font-medium">{{ __('Log Out') }}</span>
        </button>
    </form>
</nav>

