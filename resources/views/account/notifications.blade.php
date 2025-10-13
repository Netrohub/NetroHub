@extends('layouts.app')

@section('content')
<div class="min-h-screen relative overflow-hidden bg-dark-900 py-10">
    <!-- Gaming Background Effects -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary-500/5 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-secondary-500/5 rounded-full blur-3xl animate-float animation-delay-2000"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <a href="{{ route('account.index') }}" class="text-muted-400 hover:text-white transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                        </a>
                        <h1 class="text-4xl font-black text-white bg-gaming-gradient bg-clip-text text-transparent">Notifications</h1>
                    </div>
                    <p class="text-muted-300">Stay updated with your account activity</p>
                </div>
                
                <form action="{{ route('account.notifications') }}" method="POST">
                    @csrf
                    <input type="hidden" name="action" value="mark_all_read">
                    <button type="submit" class="px-4 py-2 bg-dark-700/50 hover:bg-dark-700 border border-gaming rounded-xl text-muted-300 hover:text-white transition text-sm">
                        Mark all as read
                    </button>
                </form>
            </div>
        </div>

        <!-- Notification Filters -->
        <x-ui.card variant="glass" class="p-0 mb-6">
            <nav class="flex overflow-x-auto text-sm">
                @php
                    $tabs = [
                        'all' => 'All',
                        'sales' => 'Sales',
                        'orders' => 'Orders',
                        'payouts' => 'Payouts',
                        'reviews' => 'Reviews',
                        'system' => 'System'
                    ];
                    $currentTab = request('tab', 'all');
                @endphp
                @foreach($tabs as $key => $label)
                    <a href="{{ route('account.notifications', ['tab' => $key]) }}" class="flex items-center gap-2 px-5 py-3 border-b-2 {{ $currentTab === $key ? 'border-primary-500 text-white' : 'border-transparent text-muted-300 hover:text-white' }} whitespace-nowrap">
                        {{ $label }}
                    </a>
                @endforeach
            </nav>
        </x-ui.card>

        <!-- Notifications List -->
        <div class="space-y-4">
            @forelse(auth()->user()->notifications()->paginate(20) as $notification)
                <x-ui.card variant="glass" :hover="true" class="{{ $notification->read_at ? 'opacity-75' : 'border-l-4 border-l-primary-500' }}">
                    <div class="flex items-start gap-4">
                        <!-- Icon -->
                        <div class="flex-shrink-0">
                            @if(isset($notification->data['type']))
                                @if($notification->data['type'] === 'sale')
                                    <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                @elseif($notification->data['type'] === 'order')
                                    <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                    </div>
                                @elseif($notification->data['type'] === 'payout')
                                    <div class="w-12 h-12 bg-purple-500/20 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                @elseif($notification->data['type'] === 'review')
                                    <div class="w-12 h-12 bg-yellow-500/20 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                        </svg>
                                    </div>
                                @else
                                    <div class="w-12 h-12 bg-muted-700 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-muted-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                        </svg>
                                    </div>
                                @endif
                            @else
                                <div class="w-12 h-12 bg-muted-700 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-muted-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <h3 class="text-white font-semibold mb-1">{{ $notification->data['title'] ?? 'Notification' }}</h3>
                            <p class="text-muted-300 text-sm mb-2">{{ $notification->data['message'] ?? $notification->data['body'] ?? 'You have a new notification' }}</p>
                            <div class="flex items-center gap-4 text-xs text-muted-400">
                                <span>{{ $notification->created_at->diffForHumans() }}</span>
                                @if(!$notification->read_at)
                                    <span class="px-2 py-1 bg-primary-500/20 text-primary-400 rounded-lg">New</span>
                                @endif
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex-shrink-0 flex items-center gap-2">
                            @if(isset($notification->data['action_url']))
                                <a href="{{ $notification->data['action_url'] }}" class="px-3 py-2 bg-primary-500 text-white rounded-xl hover:bg-primary-600 transition text-sm">
                                    View
                                </a>
                            @endif
                            
                            @if(!$notification->read_at)
                                <form action="{{ route('account.notifications') }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="action" value="mark_read">
                                    <input type="hidden" name="notification_id" value="{{ $notification->id }}">
                                    <button type="submit" class="p-2 text-muted-400 hover:text-white transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </x-ui.card>
            @empty
                <x-ui.card variant="glass">
                    <div class="text-center py-16">
                        <div class="w-16 h-16 bg-muted-700 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <svg class="w-8 h-8 text-muted-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">No notifications yet</h3>
                        <p class="text-muted-400">You're all caught up! We'll notify you when something happens.</p>
                    </div>
                </x-ui.card>
            @endforelse
        </div>

        <!-- Pagination -->
        @if(auth()->user()->notifications()->count() > 20)
            <div class="mt-8">
                {{ auth()->user()->notifications()->paginate(20)->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

