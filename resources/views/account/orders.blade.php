@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-6">
        <h1 class="text-3xl font-black text-white">Orders</h1>
        <p class="text-muted-300">View all purchases you made.</p>
    </div>

    <x-ui.card variant="glass" class="p-0 mb-6">
        <nav class="flex overflow-x-auto text-sm">
            @php
                $tabs = ['social' => 'Social', 'games' => 'Games', 'services' => 'Services'];
            @endphp
            @foreach($tabs as $key => $label)
                <a href="{{ route('account.orders', ['tab' => $key]) }}" class="flex items-center gap-2 px-5 py-3 border-b-2 {{ $tab === $key ? 'border-primary-500 text-white' : 'border-transparent text-muted-300 hover:text-white' }} whitespace-nowrap">
                    <x-platform-icon :category="$label" size="xs" />
                    {{ $label }}
                </a>
            @endforeach
        </nav>
    </x-ui.card>

    <x-ui.card variant="glass">
        <div class="mb-4">
            <h2 class="text-xl font-bold text-white">{{ Str::title($tab) }}</h2>
            <p class="text-sm text-muted-400">All your orders in this category.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="text-left text-muted-400">
                    <tr>
                        <th class="px-4 py-3">Product</th>
                        <th class="px-4 py-3">Amount</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Order Date</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gaming">
                    @forelse($orders as $order)
                        @php
                            $product = optional($order->items->first())->product;
                            $hasReview = $product ? $product->reviews()
                                ->where('reviewable_type', App\Models\Product::class)
                                ->where('user_id', auth()->id())
                                ->exists() : false;
                            $canReview = $product && $order->payment_status === 'completed' && !$hasReview;
                        @endphp
                        <tr class="hover:bg-dark-800/50">
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl overflow-hidden bg-dark-800 border border-gaming flex-shrink-0">
                                        @if($product->thumbnail_url)
                                            <img src="{{ $product->thumbnail_url }}" class="w-full h-full object-cover"/>
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <x-platform-icon :product="$product" size="sm" />
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-white font-medium line-clamp-1">{{ $product->title ?? 'Product' }}</div>
                                        @if($product->metadata['platform'] ?? false)
                                        <div class="flex items-center gap-1 text-xs text-muted-400">
                                            <x-platform-icon :product="$product" size="xs" />
                                            <span>{{ $product->metadata['platform'] }}</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 font-semibold text-white">${{ number_format($order->total_amount ?? 0, 2) }}</td>
                            <td class="px-4 py-4">
                                @if($order->payment_status === 'completed')
                                    <x-ui.badge color="green" size="sm">Completed</x-ui.badge>
                                @elseif($order->payment_status === 'pending')
                                    <x-ui.badge color="yellow" size="sm">Pending</x-ui.badge>
                                @else
                                    <x-ui.badge color="gray" size="sm">{{ ucfirst($order->payment_status ?? 'Unknown') }}</x-ui.badge>
                                @endif
                            </td>
                            <td class="px-4 py-4 text-muted-300">{{ optional($order->created_at)->format('M d, Y') }}</td>
                            <td class="px-4 py-4 text-right">
                                <div class="flex items-center gap-2 justify-end">
                                    <a href="{{ route('products.show', $product?->slug ?? '') }}" class="px-3 py-2 rounded-xl border border-gaming text-muted-300 hover:text-white hover:bg-dark-700/50" title="View Product">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    @if($canReview)
                                        <button onclick="openReviewModal('{{ $product->id }}', '{{ $product->title }}')" class="px-3 py-2 rounded-xl bg-primary-500 text-white hover:bg-primary-600 transition-colors" title="Write Review">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                            </svg>
                                        </button>
                                    @elseif($hasReview)
                                        <span class="px-3 py-2 rounded-xl bg-green-500/20 text-green-400 border border-green-500/30" title="Already Reviewed">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-10 text-center text-muted-400">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ method_exists($orders,'links') ? $orders->links() : '' }}</div>
    </x-ui.card>
</div>

<!-- Review Modal -->
<div id="reviewModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-dark-800 border border-gaming rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-white">Write a Review</h2>
                <button onclick="closeReviewModal()" class="text-muted-400 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <div id="reviewModalContent">
                <!-- Review form will be loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
function openReviewModal(productId, productTitle) {
    const modal = document.getElementById('reviewModal');
    const content = document.getElementById('reviewModalContent');
    
    // Show loading state
    content.innerHTML = `
        <div class="flex items-center justify-center py-8">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary-500"></div>
            <span class="ml-3 text-muted-400">Loading review form...</span>
        </div>
    `;
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    
    // Load the review form via AJAX
    fetch(`/products/${productId}/review-form`)
        .then(response => response.text())
        .then(html => {
            content.innerHTML = html;
            // Re-initialize star rating functionality
            initializeStarRating();
        })
        .catch(error => {
            console.error('Error loading review form:', error);
            content.innerHTML = `
                <div class="text-center py-8">
                    <p class="text-red-400">Error loading review form. Please try again.</p>
                </div>
            `;
        });
}

function closeReviewModal() {
    const modal = document.getElementById('reviewModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function initializeStarRating() {
    const starLabels = document.querySelectorAll('.star-label');
    const starIcons = document.querySelectorAll('.star-icon');
    
    function updateStars(rating) {
        starIcons.forEach((icon, index) => {
            if (index < rating) {
                icon.classList.remove('text-gray-600');
                icon.classList.add('text-yellow-400');
            } else {
                icon.classList.remove('text-yellow-400');
                icon.classList.add('text-gray-600');
            }
        });
    }
    
    starLabels.forEach((label, index) => {
        label.addEventListener('click', function() {
            const rating = parseInt(this.getAttribute('data-rating'));
            const radio = this.querySelector('input[type="radio"]');
            radio.checked = true;
            updateStars(rating);
        });
        
        label.addEventListener('mouseenter', function() {
            const rating = parseInt(this.getAttribute('data-rating'));
            updateStars(rating);
        });
    });
    
    document.getElementById('star-rating').addEventListener('mouseleave', function() {
        const checkedRadio = document.querySelector('input[name="rating"]:checked');
        if (checkedRadio) {
            updateStars(parseInt(checkedRadio.value));
        } else {
            updateStars(0);
        }
    });
}

// Close modal when clicking outside
document.getElementById('reviewModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeReviewModal();
    }
});
</script>
@endsection


