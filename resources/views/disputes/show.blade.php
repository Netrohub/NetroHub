<x-layouts.app>
    <x-slot name="title">{{ __('Dispute #:id', ['id' => $dispute->id]) }} - {{ config('app.name') }}</x-slot>

    <section class="relative pt-32 pb-12 md:pb-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            
            <div class="mb-8">
                <a href="{{ route('disputes.index') }}" class="inline-flex items-center text-purple-400 hover:text-purple-300 mb-4">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    {{ __('Back to Disputes') }}
                </a>
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <h1 class="h2 bg-clip-text text-transparent bg-gradient-to-r from-slate-200/60 via-slate-200 to-slate-200/60">
                        {{ __('Dispute #:id', ['id' => $dispute->id]) }}
                    </h1>
                    @php
                        $statusConfig = [
                            'open' => ['bg' => 'bg-blue-500/20', 'text' => 'text-blue-400', 'border' => 'border-blue-500/30', 'label' => 'Open - In Discussion'],
                            'resolved' => ['bg' => 'bg-green-500/20', 'text' => 'text-green-400', 'border' => 'border-green-500/30', 'label' => 'Resolved by Buyer'],
                            'escalated' => ['bg' => 'bg-orange-500/20', 'text' => 'text-orange-400', 'border' => 'border-orange-500/30', 'label' => 'Escalated to Moderators'],
                            'in_review' => ['bg' => 'bg-yellow-500/20', 'text' => 'text-yellow-400', 'border' => 'border-yellow-500/30', 'label' => 'Under Moderator Review'],
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
                
                <!-- Main Content - Messages -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Dispute Details Card -->
                    <div class="bg-slate-800/50 rounded-2xl border border-slate-700/50 overflow-hidden" data-aos="fade-up">
                        <div class="p-6 border-b border-slate-700/50">
                            <h2 class="text-xl font-bold text-slate-100 mb-2">{{ $dispute->reason }}</h2>
                            <div class="text-sm text-slate-400">
                                {{ __('Created :time', ['time' => $dispute->created_at->format('M d, Y \a\t g:i A')]) }}
                            </div>
                        </div>
                        <div class="p-6 bg-slate-900/30">
                            <h3 class="text-sm font-semibold text-slate-300 mb-2">{{ __('Initial Description') }}</h3>
                            <p class="text-slate-300">{{ $dispute->description }}</p>
                            
                            @if($dispute->evidence && count($dispute->evidence) > 0)
                                <div class="mt-4 pt-4 border-t border-slate-700/50">
                                    <h4 class="text-sm font-semibold text-slate-300 mb-3">{{ __('Evidence') }}</h4>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                        @foreach($dispute->evidence as $file)
                                            <a href="{{ asset('storage/' . $file['path']) }}" target="_blank" 
                                                class="group relative bg-slate-700 rounded-lg p-3 hover:bg-slate-600 transition-colors">
                                                <div class="flex items-center gap-2">
                                                    @if(str_contains($file['type'] ?? '', 'image'))
                                                        <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                        </svg>
                                                    @else
                                                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                                        </svg>
                                                    @endif
                                                    <span class="text-xs text-slate-300 truncate">{{ $file['original_name'] ?? 'File' }}</span>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Messages Thread -->
                    <div class="bg-slate-800/50 rounded-2xl border border-slate-700/50 overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                        <div class="p-6 border-b border-slate-700/50">
                            <h2 class="text-xl font-bold text-slate-100">{{ __('Conversation') }}</h2>
                        </div>
                        
                        <div class="p-6 space-y-6 max-h-[600px] overflow-y-auto">
                            @forelse($dispute->messages()->where('is_internal', false)->latest()->get()->reverse() as $message)
                                @php
                                    $isCurrentUser = $message->user_id === auth()->id();
                                    $isModerator = $message->user->isAdmin();
                                @endphp
                                
                                <div class="flex gap-4 {{ $isCurrentUser ? 'flex-row-reverse' : '' }}">
                                    <!-- Avatar -->
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br {{ $isModerator ? 'from-purple-500 to-pink-500' : 'from-slate-600 to-slate-700' }} flex items-center justify-center text-white font-bold">
                                            @if($message->user->avatar)
                                                <img src="{{ $message->user->avatar_url }}" alt="{{ $message->user->name }}" class="w-full h-full rounded-full object-cover">
                                            @else
                                                {{ substr($message->user->name, 0, 1) }}
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Message Content -->
                                    <div class="flex-1 {{ $isCurrentUser ? 'items-end' : 'items-start' }} flex flex-col">
                                        <div class="flex items-center gap-2 mb-1 {{ $isCurrentUser ? 'flex-row-reverse' : '' }}">
                                            <span class="text-sm font-medium text-slate-200">{{ $message->user->name }}</span>
                                            @if($isModerator)
                                                <span class="text-xs px-2 py-0.5 bg-purple-500/20 text-purple-400 rounded-full border border-purple-500/30">
                                                    {{ __('Moderator') }}
                                                </span>
                                            @endif
                                            <span class="text-xs text-slate-500">{{ $message->created_at->diffForHumans() }}</span>
                                        </div>
                                        
                                        <div class="bg-slate-700/50 rounded-2xl p-4 {{ $isCurrentUser ? 'bg-purple-500/20 border border-purple-500/30' : 'border border-slate-600' }} max-w-xl">
                                            <p class="text-slate-200 whitespace-pre-wrap">{{ $message->message }}</p>
                                            
                                            @if($message->attachments && count($message->attachments) > 0)
                                                <div class="mt-3 pt-3 border-t border-slate-600/50 space-y-2">
                                                    @foreach($message->attachments as $file)
                                                        <a href="{{ asset('storage/' . $file['path']) }}" target="_blank" 
                                                            class="flex items-center gap-2 text-sm text-purple-400 hover:text-purple-300">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                                            </svg>
                                                            <span class="truncate">{{ $file['original_name'] ?? 'Attachment' }}</span>
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8 text-slate-400">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                    <p>{{ __('No messages yet') }}</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- Action Buttons (Buyer Only) -->
                        @if($dispute->status === 'open' && auth()->id() === $dispute->buyer_id)
                            <div class="p-6 border-t border-slate-700/50 bg-gradient-to-r from-green-500/5 to-blue-500/5">
                                <div class="flex items-center justify-between gap-4">
                                    <div class="flex items-center gap-2 text-sm text-slate-300">
                                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span>{{ __('Issue resolved? Mark it solved or escalate to moderators for help.') }}</span>
                                    </div>
                                    
                                    <div class="flex gap-2">
                                        <form action="{{ route('disputes.mark-resolved', $dispute) }}" method="POST" onsubmit="return confirm('Is your issue fully resolved?')">
                                            @csrf
                                            <button type="submit" class="btn-sm text-white bg-green-500 hover:bg-green-600">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                {{ __('Mark as Resolved') }}
                                            </button>
                                        </form>
                                        <form action="{{ route('disputes.escalate', $dispute) }}" method="POST" onsubmit="return confirm('Escalate this dispute to moderators?')">
                                            @csrf
                                            <button type="submit" class="btn-sm text-white bg-orange-500 hover:bg-orange-600">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                </svg>
                                                {{ __('Escalate to Moderators') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Message Form -->
                        @if(!in_array($dispute->status, ['resolved', 'resolved_refund', 'resolved_upheld']))
                            <div class="p-6 border-t border-slate-700/50 bg-slate-900/30">
                                <form action="{{ route('disputes.message', $dispute) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                    @csrf
                                    
                                    <div>
                                        <textarea name="message" rows="3" required minlength="3"
                                            class="form-textarea w-full bg-slate-700 border-slate-600 text-slate-100 rounded-lg focus:border-purple-500 focus:ring-purple-500"
                                            placeholder="{{ __('Type your message...') }}"></textarea>
                                    </div>

                                    <div class="flex items-center justify-between gap-4">
                                        <div class="flex-1">
                                            <input type="file" name="attachments[]" id="message-attachments" multiple accept=".jpg,.jpeg,.png,.pdf" 
                                                class="hidden">
                                            <label for="message-attachments" class="inline-flex items-center text-sm text-slate-300 hover:text-white cursor-pointer">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                                </svg>
                                                {{ __('Attach files') }}
                                            </label>
                                        </div>
                                        <button type="submit" class="btn text-white bg-purple-500 hover:bg-purple-600">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                            </svg>
                                            {{ __('Send') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @else
                            <div class="p-6 border-t border-slate-700/50 bg-slate-900/30 text-center">
                                <p class="text-slate-400 text-sm">
                                    <svg class="w-5 h-5 inline-block mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    {{ __('This dispute has been resolved. No more messages can be sent.') }}
                                </p>
                            </div>
                        @endif
                    </div>

                </div>

                <!-- Sidebar - Info -->
                <div class="space-y-6">
                    
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
                            <div class="pt-3 border-t border-slate-700/50">
                                <a href="{{ route('orders.delivery', $dispute->order) }}" class="btn-sm text-white bg-slate-700 hover:bg-slate-600 w-full justify-center">
                                    {{ __('View Order') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Parties Involved -->
                    <div class="bg-slate-800/50 rounded-2xl p-6 border border-slate-700/50" data-aos="fade-up" data-aos-delay="100">
                        <h3 class="text-lg font-bold text-slate-100 mb-4">{{ __('Parties Involved') }}</h3>
                        <div class="space-y-4">
                            <!-- Buyer -->
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-400 font-bold">
                                    {{ substr($dispute->buyer->name, 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <div class="text-slate-100 font-medium">{{ $dispute->buyer->name }}</div>
                                    <div class="text-xs text-slate-400">{{ __('Buyer') }}</div>
                                </div>
                            </div>

                            <!-- Seller -->
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-green-500/20 flex items-center justify-center text-green-400 font-bold">
                                    {{ substr($dispute->seller->business_name, 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <div class="text-slate-100 font-medium">{{ $dispute->seller->business_name }}</div>
                                    <div class="text-xs text-slate-400">{{ __('Seller') }}</div>
                                </div>
                            </div>

                            @if($dispute->resolvedBy)
                                <div class="pt-3 border-t border-slate-700/50">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-purple-500/20 flex items-center justify-center text-purple-400 font-bold">
                                            {{ substr($dispute->resolvedBy->name, 0, 1) }}
                                        </div>
                                        <div class="flex-1">
                                            <div class="text-slate-100 font-medium">{{ $dispute->resolvedBy->name }}</div>
                                            <div class="text-xs text-slate-400">{{ __('Resolved by') }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Resolution (if resolved) -->
                    @if(in_array($dispute->status, ['resolved_refund', 'resolved_upheld']))
                        <div class="bg-gradient-to-br from-slate-800/80 to-slate-800/50 rounded-2xl p-6 border border-slate-700/50" data-aos="fade-up" data-aos-delay="200">
                            <h3 class="text-lg font-bold text-slate-100 mb-4">{{ __('Resolution') }}</h3>
                            <div class="space-y-3 text-sm">
                                <div>
                                    <span class="text-slate-400">{{ __('Decision:') }}</span>
                                    <div class="text-slate-100 font-bold mt-1">
                                        {{ $dispute->status === 'resolved_refund' ? __('Refund Approved') : __('Seller Upheld') }}
                                    </div>
                                </div>
                                @if($dispute->admin_notes)
                                    <div class="pt-3 border-t border-slate-700/50">
                                        <span class="text-slate-400">{{ __('Notes:') }}</span>
                                        <p class="text-slate-300 mt-2 text-sm">{{ $dispute->admin_notes }}</p>
                                    </div>
                                @endif
                                <div class="pt-3 border-t border-slate-700/50 text-xs text-slate-500">
                                    {{ __('Resolved :time', ['time' => $dispute->resolved_at->diffForHumans()]) }}
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </section>
</x-layouts.app>

