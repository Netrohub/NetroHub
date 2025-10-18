<nav class="space-y-2">
    <a href="{{ route('account.index') }}" 
       class="flex items-center px-4 py-4 rounded-lg transition-all duration-300 {{ request()->routeIs('account.index') && request('tab') !== 'settings' ? 'bg-purple-500 text-white shadow-lg shadow-purple-500/25' : 'text-slate-300 hover:bg-slate-700 hover:text-white hover:scale-105' }}">
        <div class="text-2xl mr-4">🏠</div>
        <span class="font-medium text-base">{{ __('Dashboard') }}</span>
    </a>

    <a href="{{ route('account.orders') }}" 
       class="flex items-center px-4 py-4 rounded-lg transition-all duration-300 {{ request()->routeIs('account.orders') ? 'bg-purple-500 text-white shadow-lg shadow-purple-500/25' : 'text-slate-300 hover:bg-slate-700 hover:text-white hover:scale-105' }}">
        <div class="text-2xl mr-4">📦</div>
        <span class="font-medium text-base">{{ __('My Orders') }}</span>
    </a>

    <a href="{{ route('disputes.index') }}" 
       class="flex items-center px-4 py-4 rounded-lg transition-all duration-300 {{ request()->routeIs('disputes.*') ? 'bg-purple-500 text-white shadow-lg shadow-purple-500/25' : 'text-slate-300 hover:bg-slate-700 hover:text-white hover:scale-105' }}">
        <div class="text-2xl mr-4">⚖️</div>
        <span class="font-medium text-base">{{ __('Disputes') }}</span>
    </a>

    <a href="{{ route('account.sales') }}" 
       class="flex items-center px-4 py-4 rounded-lg transition-all duration-300 {{ request()->routeIs('account.sales') ? 'bg-purple-500 text-white shadow-lg shadow-purple-500/25' : 'text-slate-300 hover:bg-slate-700 hover:text-white hover:scale-105' }}">
        <div class="text-2xl mr-4">💰</div>
        <span class="font-medium text-base">{{ __('My Sales') }}</span>
    </a>

    <a href="{{ route('account.wallet') }}" 
       class="flex items-center px-4 py-4 rounded-lg transition-all duration-300 {{ request()->routeIs('account.wallet') ? 'bg-purple-500 text-white shadow-lg shadow-purple-500/25' : 'text-slate-300 hover:bg-slate-700 hover:text-white hover:scale-105' }}">
        <div class="text-2xl mr-4">💳</div>
        <span class="font-medium text-base">{{ __('Wallet') }}</span>
    </a>

    <a href="{{ route('account.payouts') }}" 
       class="flex items-center px-4 py-4 rounded-lg transition-all duration-300 {{ request()->routeIs('account.payouts') ? 'bg-purple-500 text-white shadow-lg shadow-purple-500/25' : 'text-slate-300 hover:bg-slate-700 hover:text-white hover:scale-105' }}">
        <div class="text-2xl mr-4">💸</div>
        <span class="font-medium text-base">{{ __('Payouts') }}</span>
    </a>

    <a href="{{ route('account.notifications') }}" 
       class="flex items-center px-4 py-4 rounded-lg transition-all duration-300 {{ request()->routeIs('account.notifications') ? 'bg-purple-500 text-white shadow-lg shadow-purple-500/25' : 'text-slate-300 hover:bg-slate-700 hover:text-white hover:scale-105' }}">
        <div class="text-2xl mr-4">🔔</div>
        <span class="font-medium text-base">{{ __('Notifications') }}</span>
        @if(isset($unreadNotifications) && $unreadNotifications > 0)
            <span class="ml-auto bg-purple-500 text-white text-xs font-bold px-2 py-1 rounded-full">{{ $unreadNotifications }}</span>
        @endif
    </a>

    <a href="{{ route('account.challenges') }}" 
       class="flex items-center px-4 py-4 rounded-lg transition-all duration-300 {{ request()->routeIs('account.challenges') ? 'bg-purple-500 text-white shadow-lg shadow-purple-500/25' : 'text-slate-300 hover:bg-slate-700 hover:text-white hover:scale-105' }}">
        <div class="text-2xl mr-4">🏆</div>
        <span class="font-medium text-base">{{ __('Challenges') }}</span>
    </a>

    <div class="border-t border-slate-700 my-4"></div>

    <a href="{{ route('account.index', ['tab' => 'settings']) }}#account-settings" 
       class="flex items-center px-4 py-4 rounded-lg transition-all duration-300 {{ request()->routeIs('account.index') && request('tab') === 'settings' ? 'bg-purple-500 text-white shadow-lg shadow-purple-500/25' : 'text-slate-300 hover:bg-slate-700 hover:text-white hover:scale-105' }}">
        <div class="text-2xl mr-4">⚙️</div>
        <span class="font-medium text-base">{{ __('Settings') }}</span>
    </a>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="w-full flex items-center px-4 py-4 rounded-lg text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-all duration-300 hover:scale-105">
            <div class="text-2xl mr-4">🚪</div>
            <span class="font-medium text-base">{{ __('Log Out') }}</span>
        </button>
    </form>
</nav>

