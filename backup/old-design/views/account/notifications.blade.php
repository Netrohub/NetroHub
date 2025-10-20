<x-layouts.stellar>
    <x-slot name="title">{{ __('Notifications') }} - {{ config('app.name') }}</x-slot>

    <section class="relative pt-32 pb-12 md:pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            
            <div class="flex items-center justify-between mb-8">
                <h1 class="h2 bg-clip-text text-transparent bg-gradient-to-r from-slate-200/60 via-slate-200 to-slate-200/60">
                    {{ __('Notifications') }}
                </h1>
                @if(isset($notifications) && $notifications->where('read_at', null)->count() > 0)
                    <form action="#" method="POST">
                        @csrf
                        <button type="submit" class="text-purple-400 hover:text-purple-300 text-sm font-medium">
                            {{ __('Mark all as read') }}
                        </button>
                    </form>
                @endif
            </div>

            <div class="lg:flex lg:gap-8">
                
                <!-- Sidebar -->
                <x-stellar.account-sidebar />

                <!-- Main Content -->
                <div class="flex-1 min-w-0">
                    
                    @if(isset($notifications) && $notifications->count() > 0)
                        <div class="space-y-3">
                            @foreach($notifications as $notification)
                                <div class="bg-slate-800/50 rounded-2xl p-6 border {{ $notification->read_at ? 'border-slate-700/50' : 'border-purple-500/30 bg-purple-500/5' }} hover:border-purple-500/50 transition-colors" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 5) * 50 }}">
                                    <div class="flex gap-4">
                                        <div class="w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0 {{ $notification->read_at ? 'bg-slate-700' : 'bg-purple-500/20' }}">
                                            @php
                                                $iconClass = $notification->read_at ? 'text-slate-400' : 'text-purple-400';
                                            @endphp
                                            <svg class="w-6 h-6 {{ $iconClass }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-start justify-between mb-2">
                                                <h3 class="text-slate-100 font-medium">{{ $notification->data['title'] ?? __('Notification') }}</h3>
                                                @if(!$notification->read_at)
                                                    <span class="text-xs bg-purple-500 text-white px-2 py-1 rounded-full">{{ __('New') }}</span>
                                                @endif
                                            </div>
                                            <p class="text-slate-400 text-sm mb-2">{{ $notification->data['message'] ?? '' }}</p>
                                            <div class="flex items-center justify-between">
                                                <span class="text-xs text-slate-500">{{ $notification->created_at->diffForHumans() }}</span>
                                                @if(!$notification->read_at)
                                                    <button class="text-xs text-purple-400 hover:text-purple-300">{{ __('Mark as read') }}</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if($notifications->hasPages())
                            <div class="mt-8">
                                {{ $notifications->links() }}
                            </div>
                        @endif
                    @else
                        <div class="bg-slate-800/50 rounded-2xl p-12 border border-slate-700/50 text-center" data-aos="fade-up">
                            <div class="w-20 h-20 bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-100 mb-2">{{ __('No notifications') }}</h3>
                            <p class="text-slate-400">{{ __('You\'re all caught up!') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</x-layouts.stellar>
