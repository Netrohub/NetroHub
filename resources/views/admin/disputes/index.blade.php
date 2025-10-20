<x-layouts.app>
    <x-slot name="title">{{ __('Dispute Management') }} - {{ config('app.name') }}</x-slot>

    <section class="relative pt-32 pb-12 md:pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            
            <h1 class="h2 bg-clip-text text-transparent bg-gradient-to-r from-slate-200/60 via-slate-200 to-slate-200/60 mb-8">
                {{ __('Dispute Management') }}
            </h1>

            <!-- Stats Dashboard -->
            <div class="grid md:grid-cols-4 gap-6 mb-8" data-aos="fade-up">
                <a href="?status=all" class="bg-gradient-to-br from-slate-800/80 to-slate-800/50 rounded-2xl p-6 border border-slate-700/50 hover:border-purple-500/50 transition-colors">
                    <div class="flex items-center justify-between mb-2">
                        <div class="text-slate-400 text-sm">{{ __('Total Disputes') }}</div>
                        <div class="w-10 h-10 bg-slate-700/50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="text-3xl font-bold text-white">{{ number_format($stats['total']) }}</div>
                </a>

                <a href="?status=open" class="bg-gradient-to-br from-yellow-500/10 to-yellow-500/5 rounded-2xl p-6 border border-yellow-500/30 hover:border-yellow-500/50 transition-colors">
                    <div class="flex items-center justify-between mb-2">
                        <div class="text-yellow-400 text-sm font-medium">{{ __('Open') }}</div>
                        <div class="w-10 h-10 bg-yellow-500/20 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="text-3xl font-bold text-yellow-400">{{ number_format($stats['between_parties']) }}</div>
                </a>

                <a href="?status=in_review" class="bg-gradient-to-br from-blue-500/10 to-blue-500/5 rounded-2xl p-6 border border-blue-500/30 hover:border-blue-500/50 transition-colors">
                    <div class="flex items-center justify-between mb-2">
                        <div class="text-blue-400 text-sm font-medium">{{ __('In Review') }}</div>
                        <div class="w-10 h-10 bg-blue-500/20 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                    </div>
                    <div class="text-3xl font-bold text-blue-400">{{ number_format($stats['escalated']) }}</div>
                </a>

                <a href="?status=resolved" class="bg-gradient-to-br from-green-500/10 to-green-500/5 rounded-2xl p-6 border border-green-500/30 hover:border-green-500/50 transition-colors">
                    <div class="flex items-center justify-between mb-2">
                        <div class="text-green-400 text-sm font-medium">{{ __('Resolved') }}</div>
                        <div class="w-10 h-10 bg-green-500/20 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="text-3xl font-bold text-green-400">{{ number_format($stats['resolved']) }}</div>
                </a>
            </div>

            <!-- Filters -->
            <div class="bg-slate-800/50 rounded-2xl p-6 border border-slate-700/50 mb-8" data-aos="fade-up">
                <div class="flex flex-wrap gap-2">
                    <a href="?status=all" class="btn-sm {{ $status === 'all' ? 'bg-purple-500 text-white' : 'bg-slate-700 text-slate-300 hover:bg-slate-600' }}">
                        {{ __('All') }}
                    </a>
                    <a href="?status=open" class="btn-sm {{ $status === 'open' ? 'bg-purple-500 text-white' : 'bg-slate-700 text-slate-300 hover:bg-slate-600' }}">
                        {{ __('Open') }}
                    </a>
                    <a href="?status=in_review" class="btn-sm {{ $status === 'in_review' ? 'bg-purple-500 text-white' : 'bg-slate-700 text-slate-300 hover:bg-slate-600' }}">
                        {{ __('In Review') }}
                    </a>
                    <a href="?status=resolved_refund" class="btn-sm {{ $status === 'resolved_refund' ? 'bg-purple-500 text-white' : 'bg-slate-700 text-slate-300 hover:bg-slate-600' }}">
                        {{ __('Resolved - Refund') }}
                    </a>
                    <a href="?status=resolved_upheld" class="btn-sm {{ $status === 'resolved_upheld' ? 'bg-purple-500 text-white' : 'bg-slate-700 text-slate-300 hover:bg-slate-600' }}">
                        {{ __('Resolved - Upheld') }}
                    </a>
                </div>
            </div>

            <!-- Disputes Table -->
            @if($disputes->count() > 0)
                <div class="bg-slate-800/50 rounded-2xl border border-slate-700/50 overflow-hidden" data-aos="fade-up">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-900/50 border-b border-slate-700/50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-300 uppercase tracking-wider">{{ __('ID') }}</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-300 uppercase tracking-wider">{{ __('Reason') }}</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-300 uppercase tracking-wider">{{ __('Order') }}</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-300 uppercase tracking-wider">{{ __('Buyer') }}</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-300 uppercase tracking-wider">{{ __('Seller') }}</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-300 uppercase tracking-wider">{{ __('Status') }}</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-300 uppercase tracking-wider">{{ __('Created') }}</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-300 uppercase tracking-wider">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-700/50">
                                @foreach($disputes as $dispute)
                                    <tr class="hover:bg-slate-700/20 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-bold text-slate-100">#{{ $dispute->id }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-slate-100 font-medium">{{ $dispute->reason }}</div>
                                            @if($dispute->orderItem)
                                                <div class="text-xs text-slate-400 mt-1">{{ \Illuminate\Support\Str::limit($dispute->orderItem->product_title, 40) }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-slate-300">{{ $dispute->order->order_number ?? '#' . $dispute->order_id }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-slate-200">{{ $dispute->buyer->name }}</div>
                                            <div class="text-xs text-slate-400">{{ $dispute->buyer->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-slate-200">{{ $dispute->seller->display_name ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $statusConfig = [
                                                    'open' => ['bg' => 'bg-yellow-500/20', 'text' => 'text-yellow-400', 'border' => 'border-yellow-500/30'],
                                                    'in_review' => ['bg' => 'bg-blue-500/20', 'text' => 'text-blue-400', 'border' => 'border-blue-500/30'],
                                                    'resolved_refund' => ['bg' => 'bg-green-500/20', 'text' => 'text-green-400', 'border' => 'border-green-500/30'],
                                                    'resolved_upheld' => ['bg' => 'bg-purple-500/20', 'text' => 'text-purple-400', 'border' => 'border-purple-500/30'],
                                                ];
                                                $config = $statusConfig[$dispute->status] ?? ['bg' => 'bg-gray-500/20', 'text' => 'text-gray-400', 'border' => 'border-gray-500/30'];
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium border {{ $config['bg'] }} {{ $config['text'] }} {{ $config['border'] }}">
                                                {{ ucwords(str_replace('_', ' ', $dispute->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400">
                                            {{ $dispute->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <a href="{{ route('admin.disputes.show', $dispute) }}" class="text-purple-400 hover:text-purple-300 font-medium">
                                                {{ __('Review') }} →
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
                    <h3 class="text-xl font-bold text-slate-100 mb-2">{{ __('No disputes found') }}</h3>
                    <p class="text-slate-400">{{ __('There are no disputes matching your current filter.') }}</p>
                </div>
            @endif
        </div>
    </section>
</x-layouts.app>


