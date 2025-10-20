@props(['review', 'canReply' => false])

<div class="bg-dark-800/30 border border-gaming rounded-2xl p-6 hover:border-primary-500/30 transition-all">
    <div class="flex items-start gap-4">
        {{-- Avatar --}}
        <div class="flex-shrink-0">
            <img src="{{ $review->user->getAvatarUrlAttribute(null) }}" 
                 alt="{{ $review->user->name }}" 
                 class="w-12 h-12 rounded-full border-2 border-gaming">
        </div>
        
        <div class="flex-1 min-w-0">
            {{-- Header --}}
            <div class="flex items-start justify-between gap-4 mb-2">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <h4 class="font-semibold text-white">{{ $review->user->name }}</h4>
                        @if ($review->isVerifiedPurchase())
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-500/20 text-green-400 border border-green-500/30">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Verified Purchase
                            </span>
                        @endif
                    </div>
                    <div class="flex items-center gap-3">
                        <x-rating-stars :rating="$review->rating" size="sm" :showNumber="false" />
                        <span class="text-xs text-muted-400">{{ $review->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                
                {{-- Actions Menu --}}
                <div class="flex items-center gap-2">
                    @auth
                        @if ($review->user_id === auth()->id())
                            {{-- Edit/Delete for author --}}
                            <button onclick="editReview({{ $review->id }})" class="text-sm text-primary-400 hover:text-primary-300">
                                Edit
                            </button>
                            <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="inline" onsubmit="return confirm('Delete this review?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-400 hover:text-red-300">Delete</button>
                            </form>
                        @else
                            {{-- Report for others --}}
                            @if (!$review->isReported())
                                <form action="{{ route('reviews.report', $review) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-sm text-muted-400 hover:text-white">
                                        Report
                                    </button>
                                </form>
                            @else
                                <span class="text-xs text-yellow-400">Reported</span>
                            @endif
                        @endif
                    @endauth
                </div>
            </div>
            
            {{-- Review Title --}}
            @if ($review->title)
                <h5 class="text-lg font-semibold text-white mb-2">{{ $review->title }}</h5>
            @endif
            
            {{-- Review Body --}}
            <p class="text-muted-300 leading-relaxed whitespace-pre-wrap">{{ $review->body }}</p>
            
            {{-- Seller/Staff Reply --}}
            @if ($review->hasReply())
                <div class="mt-4 pl-4 border-l-2 border-primary-500/30 bg-dark-900/50 p-4 rounded-lg">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-4 h-4 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                        </svg>
                        <span class="text-sm font-semibold text-primary-400">
                            Response from {{ $review->repliedBy->name ?? 'Seller' }}
                        </span>
                    </div>
                    <p class="text-sm text-muted-300">{{ $review->replied_body }}</p>
                </div>
            @endif
            
            {{-- Reply Form (for seller/staff) --}}
            @if ($canReply && !$review->hasReply())
                <div class="mt-4" id="reply-form-{{ $review->id }}" style="display: none;">
                    <form action="{{ route('reviews.reply', $review) }}" method="POST" class="space-y-3">
                        @csrf
                        <textarea name="replied_body" rows="3" 
                                  class="w-full bg-dark-800 border border-gaming rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent resize-none"
                                  placeholder="Write your response..." required></textarea>
                        <div class="flex gap-2">
                            <x-ui.button type="submit" variant="primary" size="sm">Post Reply</x-ui.button>
                            <x-ui.button type="button" variant="secondary" size="sm" onclick="document.getElementById('reply-form-{{ $review->id }}').style.display='none'">Cancel</x-ui.button>
                        </div>
                    </form>
                </div>
                <button onclick="document.getElementById('reply-form-{{ $review->id }}').style.display='block'" 
                        class="mt-3 text-sm text-primary-400 hover:text-primary-300">
                    Reply to this review
                </button>
            @endif
        </div>
    </div>
</div>

