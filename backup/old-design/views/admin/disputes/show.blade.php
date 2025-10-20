<x-layouts.stellar>
    <x-slot name="title">{{ __('Review Dispute #:id', ['id' => $dispute->id]) }} - {{ config('app.name') }}</x-slot>

    <section class="relative pt-32 pb-12 md:pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            
            <div class="mb-8">
                <a href="{{ route('admin.disputes.index') }}" class="inline-flex items-center text-purple-400 hover:text-purple-300 mb-4">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    {{ __('Back to Disputes') }}
                </a>
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <h1 class="h2 bg-clip-text text-transparent bg-gradient-to-r from-slate-200/60 via-slate-200 to-slate-200/60">
                        {{ __('Review Dispute #:id', ['id' => $dispute->id]) }}
                    </h1>
                    @php
                        $statusConfig = [
                            'open' => ['bg' => 'bg-yellow-500/20', 'text' => 'text-yellow-400', 'border' => 'border-yellow-500/30', 'label' => 'Open'],
                            'in_review' => ['bg' => 'bg-blue-500/20', 'text' => 'text-blue-400', 'border' => 'border-blue-500/30', 'label' => 'In Review'],
                            'resolved_refund' => ['bg' => 'bg-green-500/20', 'text' => 'text-green-400', 'border' => 'border-green-500/30', 'label' => 'Resolved - Refunded'],
                            'resolved_upheld' => ['bg' => 'bg-purple-500/20', 'text' => 'text-purple-400', 'border' => 'border-purple-500/30', 'label' => 'Resolved - Upheld'],
                        ];
                        $config = $statusConfig[$dispute->status] ?? ['bg' => 'bg-gray-500/20', 'text' => 'text-gray-400', 'border' => 'border-gray-500/30', 'label' => $dispute->status];
                    @endphp
                    <span class="inline-flex items-center text-sm px-4 py-2 rounded-full {{ $config['bg'] }} {{ $config['text'] }} border {{ $config['border'] }} font-semibold">
                        {{ $config['label'] }}
                    </span>
                </div>
            </div>

            <div class="grid lg:grid-cols-3 gap-8">
                
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Dispute Details -->
                    <div class="bg-slate-800/50 rounded-2xl border border-slate-700/50 overflow-hidden" data-aos="fade-up">
                        <div class="p-6 border-b border-slate-700/50 bg-red-500/10">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-red-500/20 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h2 class="text-xl font-bold text-slate-100 mb-2">{{ $dispute->reason }}</h2>
                                    <div class="text-sm text-slate-400">
                                        {{ __('Created :time', ['time' => $dispute->created_at->format('M d, Y \a\t g:i A')]) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-sm font-semibold text-slate-300 mb-3 uppercase tracking-wide">{{ __('Buyer\'s Description') }}</h3>
                            <p class="text-slate-200 whitespace-pre-wrap">{{ $dispute->description }}</p>
                            
                            @if($dispute->evidence && count($dispute->evidence) > 0)
                                <div class="mt-6 pt-6 border-t border-slate-700/50">
                                    <h4 class="text-sm font-semibold text-slate-300 mb-3 uppercase tracking-wide">{{ __('Evidence Submitted') }}</h4>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                        @foreach($dispute->evidence as $file)
                                            <a href="{{ asset('storage/' . $file['path']) }}" target="_blank" 
                                                class="group relative bg-slate-700 rounded-xl p-4 hover:bg-slate-600 transition-all hover:scale-105">
                                                <div class="flex flex-col items-center gap-2">
                                                    @if(str_contains($file['type'] ?? '', 'image'))
                                                        <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                        </svg>
                                                    @else
                                                        <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                                        </svg>
                                                    @endif
                                                    <span class="text-xs text-slate-300 text-center truncate w-full">{{ $file['original_name'] ?? 'File' }}</span>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Conversation -->
                    <div class="bg-slate-800/50 rounded-2xl border border-slate-700/50 overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                        <div class="p-6 border-b border-slate-700/50 flex items-center justify-between">
                            <h2 class="text-xl font-bold text-slate-100">{{ __('Conversation') }}</h2>
                            <div class="flex gap-2">
                                <button onclick="toggleInternalNotes()" class="text-xs px-3 py-1 rounded-lg bg-slate-700 text-slate-300 hover:bg-slate-600">
                                    {{ __('Toggle Internal Notes') }}
                                </button>
                            </div>
                        </div>
                        
                        <div class="p-6 space-y-6 max-h-[700px] overflow-y-auto" id="messages-container">
                            @forelse($dispute->messages()->latest()->get()->reverse() as $message)
                                <div class="message-item {{ $message->is_internal ? 'internal-note' : 'public-message' }}">
                                    @if($message->is_internal)
                                        <!-- Internal Note -->
                                        <div class="bg-purple-500/10 border-l-4 border-purple-500 rounded-r-xl p-4">
                                            <div class="flex items-center gap-2 mb-2">
                                                <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                                </svg>
                                                <span class="text-xs font-semibold text-purple-400 uppercase">{{ __('Internal Note') }}</span>
                                                <span class="text-xs text-slate-400">{{ $message->created_at->diffForHumans() }}</span>
                                            </div>
                                            <div class="text-sm text-purple-200">
                                                <span class="font-medium">{{ $message->user->name }}:</span> {{ $message->message }}
                                            </div>
                                        </div>
                                    @else
                                        <!-- Public Message -->
                                        @php
                                            $isModerator = $message->user->isAdmin();
                                            $isBuyer = $message->user_id === $dispute->buyer_id;
                                        @endphp
                                        <div class="flex gap-4">
                                            <div class="flex-shrink-0">
                                                <div class="w-10 h-10 rounded-full {{ $isModerator ? 'bg-gradient-to-br from-purple-500 to-pink-500' : ($isBuyer ? 'bg-blue-500/30' : 'bg-green-500/30') }} flex items-center justify-center text-white font-bold text-sm">
                                                    {{ substr($message->user->name, 0, 1) }}
                                                </div>
                                            </div>
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2 mb-1">
                                                    <span class="text-sm font-medium text-slate-200">{{ $message->user->name }}</span>
                                                    @if($isModerator)
                                                        <span class="text-xs px-2 py-0.5 bg-purple-500/20 text-purple-400 rounded-full border border-purple-500/30">
                                                            {{ __('Moderator') }}
                                                        </span>
                                                    @elseif($isBuyer)
                                                        <span class="text-xs px-2 py-0.5 bg-blue-500/20 text-blue-400 rounded-full">
                                                            {{ __('Buyer') }}
                                                        </span>
                                                    @else
                                                        <span class="text-xs px-2 py-0.5 bg-green-500/20 text-green-400 rounded-full">
                                                            {{ __('Seller') }}
                                                        </span>
                                                    @endif
                                                    <span class="text-xs text-slate-500">{{ $message->created_at->diffForHumans() }}</span>
                                                </div>
                                                <div class="bg-slate-700/30 border border-slate-600 rounded-2xl p-4">
                                                    <p class="text-slate-200 whitespace-pre-wrap text-sm">{{ $message->message }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="text-center py-8 text-slate-400">
                                    <p>{{ __('No messages yet') }}</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- Message Forms -->
                        @if(!in_array($dispute->status, ['resolved_refund', 'resolved_upheld']))
                            <div class="border-t border-slate-700/50">
                                <!-- Public Message Form -->
                                <div class="p-6 bg-slate-900/30">
                                    <h3 class="text-sm font-semibold text-slate-300 mb-3">{{ __('Send Public Message') }}</h3>
                                    <form action="{{ route('admin.disputes.message', $dispute) }}" method="POST" class="space-y-3">
                                        @csrf
                                        <textarea name="message" rows="3" required minlength="3"
                                            class="form-textarea w-full bg-slate-700 border-slate-600 text-slate-100 rounded-lg focus:border-purple-500 focus:ring-purple-500 text-sm"
                                            placeholder="{{ __('Send a message to both parties...') }}"></textarea>
                                        <input type="hidden" name="is_internal" value="0">
                                        <button type="submit" class="btn-sm text-white bg-purple-500 hover:bg-purple-600">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                            </svg>
                                            {{ __('Send Public Message') }}
                                        </button>
                                    </form>
                                </div>

                                <!-- Internal Note Form -->
                                <div class="p-6 bg-purple-500/5 border-t border-slate-700/50">
                                    <h3 class="text-sm font-semibold text-purple-300 mb-3 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                        {{ __('Add Internal Note (Moderator Only)') }}
                                    </h3>
                                    <form action="{{ route('admin.disputes.internal-note', $dispute) }}" method="POST" class="space-y-3">
                                        @csrf
                                        <textarea name="note" rows="2" required minlength="3"
                                            class="form-textarea w-full bg-slate-700 border-purple-500/30 text-slate-100 rounded-lg focus:border-purple-500 focus:ring-purple-500 text-sm"
                                            placeholder="{{ __('Add an internal note visible only to moderators...') }}"></textarea>
                                        <button type="submit" class="btn-sm text-white bg-purple-600 hover:bg-purple-700">
                                            {{ __('Add Internal Note') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Resolution Form -->
                    @if(!in_array($dispute->status, ['resolved_refund', 'resolved_upheld']))
                        <div class="bg-gradient-to-br from-slate-800/80 to-slate-800/50 rounded-2xl border border-slate-700/50 p-6" data-aos="fade-up" data-aos-delay="200">
                            <h2 class="text-xl font-bold text-slate-100 mb-4">{{ __('Resolve Dispute') }}</h2>
                            
                            @if($dispute->status === 'open')
                                <form action="{{ route('admin.disputes.take-action', $dispute) }}" method="POST" class="mb-6">
                                    @csrf
                                    <button type="submit" class="btn text-white bg-blue-500 hover:bg-blue-600">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                        {{ __('Take Into Review') }}
                                    </button>
                                </form>
                            @endif

                            <form action="{{ route('admin.disputes.resolve', $dispute) }}" method="POST" class="space-y-4">
                                @csrf
                                
                                <div>
                                    <label class="block text-sm font-medium text-slate-200 mb-3">{{ __('Resolution Decision') }}</label>
                                    <div class="grid grid-cols-2 gap-4">
                                        <label class="relative flex items-center p-4 bg-slate-700/50 border-2 border-slate-600 rounded-xl cursor-pointer hover:border-green-500/50 transition-colors">
                                            <input type="radio" name="resolution" value="refund" required class="sr-only peer">
                                            <div class="flex-1 peer-checked:text-green-400">
                                                <div class="flex items-center gap-3 mb-2">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <span class="font-bold">{{ __('Refund Buyer') }}</span>
                                                </div>
                                                <p class="text-xs text-slate-400">{{ __('Buyer\'s claim is valid') }}</p>
                                            </div>
                                            <div class="absolute inset-0 border-2 border-green-500 rounded-xl opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                        </label>

                                        <label class="relative flex items-center p-4 bg-slate-700/50 border-2 border-slate-600 rounded-xl cursor-pointer hover:border-purple-500/50 transition-colors">
                                            <input type="radio" name="resolution" value="upheld" required class="sr-only peer">
                                            <div class="flex-1 peer-checked:text-purple-400">
                                                <div class="flex items-center gap-3 mb-2">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                                    </svg>
                                                    <span class="font-bold">{{ __('Uphold Seller') }}</span>
                                                </div>
                                                <p class="text-xs text-slate-400">{{ __('Seller is in the right') }}</p>
                                            </div>
                                            <div class="absolute inset-0 border-2 border-purple-500 rounded-xl opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                        </label>
                                    </div>
                                </div>

                                <div>
                                    <label for="admin_notes" class="block text-sm font-medium text-slate-200 mb-2">
                                        {{ __('Resolution Notes') }} <span class="text-red-400">*</span>
                                    </label>
                                    <textarea name="admin_notes" id="admin_notes" rows="4" required minlength="10"
                                        class="form-textarea w-full bg-slate-700 border-slate-600 text-slate-100 rounded-lg focus:border-purple-500 focus:ring-purple-500"
                                        placeholder="{{ __('Explain your decision and any actions taken...') }}"></textarea>
                                    <p class="mt-1 text-xs text-slate-400">{{ __('This will be visible to both parties') }}</p>
                                </div>

                                <button type="submit" class="btn text-white bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 shadow-lg w-full">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ __('Submit Resolution') }}
                                </button>
                            </form>
                        </div>
                    @endif

                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    
                    <!-- Quick Actions -->
                    @if(!in_array($dispute->status, ['resolved_refund', 'resolved_upheld']))
                        <div class="bg-slate-800/50 rounded-2xl p-6 border border-slate-700/50" data-aos="fade-up">
                            <h3 class="text-lg font-bold text-slate-100 mb-4">{{ __('Quick Actions') }}</h3>
                            <div class="space-y-2">
                                @if($dispute->status === 'open')
                                    <form action="{{ route('admin.disputes.take-action', $dispute) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-sm text-white bg-blue-500 hover:bg-blue-600 w-full justify-center">
                                            {{ __('Take Into Review') }}
                                        </button>
                                    </form>
                                @endif
                                <a href="{{ route('admin.orders.show', $dispute->order) }}" class="btn-sm text-white bg-slate-700 hover:bg-slate-600 w-full justify-center">
                                    {{ __('View Order') }}
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Order Info -->
                    <div class="bg-slate-800/50 rounded-2xl p-6 border border-slate-700/50" data-aos="fade-up">
                        <h3 class="text-lg font-bold text-slate-100 mb-4">{{ __('Order Details') }}</h3>
                        <div class="space-y-3 text-sm">
                            <div>
                                <span class="text-slate-400">{{ __('Order Number:') }}</span>
                                <div class="text-slate-100 font-medium mt-1">{{ $dispute->order->order_number ?? '#' . $dispute->order_id }}</div>
                            </div>
                            @if($dispute->orderItem)
                                <div class="pt-3 border-t border-slate-700/50">
                                    <span class="text-slate-400">{{ __('Product:') }}</span>
                                    <div class="text-slate-100 mt-2">{{ $dispute->orderItem->product_title }}</div>
                                    <div class="text-slate-400 text-xs mt-1">${{ number_format($dispute->orderItem->price, 2) }}</div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Parties -->
                    <div class="bg-slate-800/50 rounded-2xl p-6 border border-slate-700/50" data-aos="fade-up" data-aos-delay="100">
                        <h3 class="text-lg font-bold text-slate-100 mb-4">{{ __('Parties') }}</h3>
                        <div class="space-y-4 text-sm">
                            <!-- Buyer -->
                            <div>
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="w-8 h-8 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-400 text-xs font-bold">
                                        {{ substr($dispute->buyer->name, 0, 1) }}
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-slate-100 font-medium">{{ $dispute->buyer->name }}</div>
                                        <div class="text-xs text-blue-400">{{ __('Buyer') }}</div>
                                    </div>
                                </div>
                                <div class="text-xs text-slate-400 ml-10">{{ $dispute->buyer->email }}</div>
                            </div>

                            <!-- Seller -->
                            <div class="pt-3 border-t border-slate-700/50">
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="w-8 h-8 rounded-full bg-green-500/20 flex items-center justify-center text-green-400 text-xs font-bold">
                                        {{ substr($dispute->seller->business_name, 0, 1) }}
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-slate-100 font-medium">{{ $dispute->seller->business_name }}</div>
                                        <div class="text-xs text-green-400">{{ __('Seller') }}</div>
                                    </div>
                                </div>
                                @if($dispute->seller->user)
                                    <div class="text-xs text-slate-400 ml-10">{{ $dispute->seller->user->email }}</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Resolution Info -->
                    @if($dispute->resolvedBy)
                        <div class="bg-gradient-to-br from-purple-500/10 to-purple-500/5 rounded-2xl p-6 border border-purple-500/30" data-aos="fade-up" data-aos-delay="200">
                            <h3 class="text-lg font-bold text-purple-300 mb-4">{{ __('Resolution') }}</h3>
                            <div class="space-y-3 text-sm">
                                <div>
                                    <span class="text-purple-300">{{ __('Resolved By:') }}</span>
                                    <div class="text-white font-medium mt-1">{{ $dispute->resolvedBy->name }}</div>
                                </div>
                                <div>
                                    <span class="text-purple-300">{{ __('Decision:') }}</span>
                                    <div class="text-white font-bold mt-1">
                                        {{ $dispute->status === 'resolved_refund' ? __('Refund Approved') : __('Seller Upheld') }}
                                    </div>
                                </div>
                                @if($dispute->admin_notes)
                                    <div class="pt-3 border-t border-purple-500/30">
                                        <span class="text-purple-300">{{ __('Notes:') }}</span>
                                        <p class="text-purple-100 mt-2">{{ $dispute->admin_notes }}</p>
                                    </div>
                                @endif
                                <div class="pt-3 border-t border-purple-500/30 text-xs text-purple-400">
                                    {{ $dispute->resolved_at->format('M d, Y \a\t g:i A') }}
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </section>

    <script>
        function toggleInternalNotes() {
            const notes = document.querySelectorAll('.internal-note');
            notes.forEach(note => {
                note.style.display = note.style.display === 'none' ? 'block' : 'none';
            });
        }

        // Initially show internal notes
        document.addEventListener('DOMContentLoaded', function() {
            // Internal notes visible by default for moderators
        });
    </script>
</x-layouts.stellar>


