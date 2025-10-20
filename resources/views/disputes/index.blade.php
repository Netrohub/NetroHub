<x-layouts.app>
    <x-slot name="title">{{ __('My Disputes') }} - {{ config('app.name') }}</x-slot>

    <section class="relative pt-32 pb-12 md:pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            
            <div class="flex items-center justify-between mb-8">
                <h1 class="h2 bg-clip-text text-transparent bg-gradient-to-r from-slate-200/60 via-slate-200 to-slate-200/60">
                    {{ __('My Disputes') }}
                </h1>
                <a href="{{ route('disputes.create') }}" class="btn text-white bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ __('Create Dispute') }}
                </a>
            </div>

            <div class="lg:flex lg:gap-8">
                
                <!-- Sidebar -->
                <x-stellar.account-sidebar />

                <!-- Main Content -->
                <div class="flex-1 min-w-0">
                    
                    <!-- Stats Cards -->
                    <div class="grid md:grid-cols-3 gap-6 mb-8" data-aos="fade-up">
                        <div class="bg-gradient-to-br from-slate-800/80 to-slate-800/50 rounded-2xl p-6 border border-slate-700/50">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-slate-400 text-sm mb-1">{{ __('Open') }}</div>
                                    <div class="text-3xl font-bold text-white">{{ $disputes->where('status', 'open')->count() }}</div>
                                </div>
                                <div class="w-12 h-12 bg-yellow-500/20 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-slate-800/80 to-slate-800/50 rounded-2xl p-6 border border-slate-700/50">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-slate-400 text-sm mb-1">{{ __('In Review') }}</div>
                                    <div class="text-3xl font-bold text-white">{{ $disputes->where('status', 'in_review')->count() }}</div>
                                </div>
                                <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-slate-800/80 to-slate-800/50 rounded-2xl p-6 border border-slate-700/50">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-slate-400 text-sm mb-1">{{ __('Resolved') }}</div>
                                    <div class="text-3xl font-bold text-white">{{ $disputes->whereIn('status', ['resolved_refund', 'resolved_upheld'])->count() }}</div>
                                </div>
                                <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Disputes List -->
                    @if($disputes->count() > 0)
                        <div class="space-y-6">
                            @foreach($disputes as $dispute)
                                <div class="bg-slate-800/50 rounded-2xl border border-slate-700/50 overflow-hidden hover:border-purple-500/30 transition-colors" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 5) * 50 }}">
                                    <!-- Dispute Header -->
                                    <div class="p-6 border-b border-slate-700/50">
                                        <div class="flex flex-wrap items-start justify-between gap-4">
                                            <div class="flex items-start gap-4 flex-1">
                                                <div class="w-12 h-12 bg-slate-700 rounded-lg flex items-center justify-center flex-shrink-0">
                                                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                    </svg>
                                                </div>
                                                <div class="flex-1">
                                                    <div class="text-slate-100 font-bold text-lg mb-1">{{ $dispute->reason }}</div>
                                                    <div class="text-sm text-slate-400 mb-2">
                                                        {{ __('Order #:number', ['number' => $dispute->order->order_number ?? $dispute->order_id]) }}
                                                    </div>
                                                    @if($dispute->orderItem)
                                                        <div class="text-sm text-slate-300">
                                                            <span class="text-slate-400">{{ __('Product:') }}</span> {{ $dispute->orderItem->product_title }}
                                                        </div>
                                                    @endif
                                                    <div class="text-xs text-slate-500 mt-2">
                                                        {{ __('Created :time', ['time' => $dispute->created_at->diffForHumans()]) }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col items-end gap-2">
                                                @php
                                                    $statusConfig = [
                                                        'open' => ['bg' => 'bg-yellow-500/20', 'text' => 'text-yellow-400', 'border' => 'border-yellow-500/30', 'label' => 'Open'],
                                                        'in_review' => ['bg' => 'bg-blue-500/20', 'text' => 'text-blue-400', 'border' => 'border-blue-500/30', 'label' => 'In Review'],
                                                        'resolved_refund' => ['bg' => 'bg-green-500/20', 'text' => 'text-green-400', 'border' => 'border-green-500/30', 'label' => 'Resolved - Refunded'],
                                                        'resolved_upheld' => ['bg' => 'bg-purple-500/20', 'text' => 'text-purple-400', 'border' => 'border-purple-500/30', 'label' => 'Resolved - Upheld'],
                                                    ];
                                                    $config = $statusConfig[$dispute->status] ?? ['bg' => 'bg-gray-500/20', 'text' => 'text-gray-400', 'border' => 'border-gray-500/30', 'label' => $dispute->status];
                                                @endphp
                                                <span class="inline-flex items-center text-xs px-3 py-1 rounded-full {{ $config['bg'] }} {{ $config['text'] }} border {{ $config['border'] }}">
                                                    {{ $config['label'] }}
                                                </span>
                                                @if($dispute->messages->count() > 0)
                                                    <div class="text-xs text-slate-400 flex items-center gap-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                                        </svg>
                                                        {{ $dispute->messages->count() }} {{ __('messages') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Dispute Preview -->
                                    <div class="p-6 bg-slate-900/30">
                                        <div class="text-slate-300 text-sm mb-4 line-clamp-2">{{ $dispute->description }}</div>
                                        
                                        <!-- Actions -->
                                        <div class="flex flex-wrap gap-3">
                                            <a href="{{ route('disputes.show', $dispute) }}" class="btn text-white bg-purple-500 hover:bg-purple-600">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                {{ __('View Details') }}
                                            </a>
                                            @if($dispute->order)
                                                <a href="{{ route('orders.delivery', $dispute->order) }}" class="btn text-slate-300 hover:text-white bg-slate-700 hover:bg-slate-600">
                                                    {{ __('View Order') }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        @if($disputes->hasPages())
                            <div class="mt-8">
                                {{ $disputes->links() }}
                            </div>
                        @endif
                    @else
                        <div class="bg-slate-800/50 rounded-2xl p-12 border border-slate-700/50 text-center" data-aos="fade-up">
                            <div class="w-20 h-20 bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-100 mb-2">{{ __('No disputes yet') }}</h3>
                            <p class="text-slate-400 mb-6">{{ __('You haven\'t created any disputes. If you have issues with an order, you can create a dispute.') }}</p>
                            <a href="{{ route('account.orders') }}" class="btn text-slate-900 bg-gradient-to-r from-white/80 via-white to-white/80 hover:bg-white inline-flex">
                                {{ __('View Orders') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>


