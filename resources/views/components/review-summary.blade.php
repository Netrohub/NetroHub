@props(['product'])

@php
    $ratingAvg = $product->rating_avg ?? 0;
    $ratingCount = $product->rating_count ?? 0;
    
    // Get rating distribution
    $ratingDistribution = $product->reviews()
        ->where('status', 'approved')
        ->selectRaw('rating, COUNT(*) as count')
        ->groupBy('rating')
        ->pluck('count', 'rating')
        ->toArray();
@endphp

<div class="bg-dark-800/50 border border-gaming rounded-2xl p-6">
    <h3 class="text-xl font-bold text-white mb-4">Customer Reviews</h3>
    
    <div class="flex items-start gap-8">
        {{-- Overall Rating --}}
        <div class="text-center">
            <div class="text-5xl font-black text-white mb-2">{{ number_format($ratingAvg, 1) }}</div>
            <x-rating-stars :rating="$ratingAvg" size="lg" :showNumber="false" />
            <div class="text-sm text-muted-400 mt-2">{{ $ratingCount }} {{ Str::plural('review', $ratingCount) }}</div>
        </div>
        
        {{-- Rating Distribution --}}
        <div class="flex-1">
            @for ($i = 5; $i >= 1; $i--)
                @php
                    $count = $ratingDistribution[$i] ?? 0;
                    $percentage = $ratingCount > 0 ? ($count / $ratingCount) * 100 : 0;
                @endphp
                <div class="flex items-center gap-3 mb-2">
                    <span class="text-sm text-white w-6">{{ $i }}★</span>
                    <div class="flex-1 h-2 bg-dark-700 rounded-full overflow-hidden">
                        <div class="h-full bg-yellow-400" style="width: {{ $percentage }}%"></div>
                    </div>
                    <span class="text-sm text-muted-400 w-12 text-right">{{ $count }}</span>
                </div>
            @endfor
        </div>
    </div>
</div>

