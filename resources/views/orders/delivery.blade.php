@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('account.orders') }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 flex items-center text-sm mb-4">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Orders
            </a>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Secure Delivery</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Order #{{ $order->order_number }}</p>
        </div>

        @if($canDispute)
        <!-- Dispute Banner -->
        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4 mb-6">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                <div class="flex-1">
                    <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-400">Dispute Window Active</h3>
                    <p class="text-sm text-yellow-700 dark:text-yellow-500 mt-1">
                        You have until <strong>{{ $disputeDeadline->format('M d, Y g:i A') }}</strong> to open a dispute if there are any issues with your purchase.
                    </p>
                </div>
            </div>
        </div>
        @endif

        <!-- Security Notice -->
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-6">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                </svg>
                <div class="flex-1">
                    <h3 class="text-sm font-medium text-blue-800 dark:text-blue-400">🔒 Secure Access</h3>
                    <p class="text-sm text-blue-700 dark:text-blue-500 mt-1">
                        Your credentials are encrypted and stored securely. Each reveal is logged for your security.
                    </p>
                </div>
            </div>
        </div>

        <!-- Order Items with Credentials -->
        @foreach($order->items as $item)
            @if($item->hasCredentials())
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm mb-6" data-item-id="{{ $item->id }}">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $item->product_title }}</h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                Remaining views: <span class="font-medium remaining-views-{{ $item->id }}">{{ $item->getRemainingViews() }}</span> of {{ $item->credential_view_limit }}
                            </p>
                        </div>
                        @if($item->credential_claimed_at)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                            Claimed {{ $item->credential_claimed_at->diffForHumans() }}
                        </span>
                        @endif
                    </div>
                </div>

                <div class="p-6">
                    @if($item->canViewCredentials())
                    <!-- Credentials Section (Initially Hidden) -->
                    <div class="credentials-section-{{ $item->id }} hidden">
                        <!-- Username -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Username</label>
                            <div class="flex gap-2">
                                <input type="text" 
                                       class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white font-mono text-sm"
                                       readonly 
                                       data-credential="username-{{ $item->id }}">
                                <button onclick="copyToClipboard('username-{{ $item->id }}')" 
                                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition text-sm font-medium">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                    Copy
                                </button>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password</label>
                            <div class="flex gap-2">
                                <input type="text" 
                                       class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white font-mono text-sm"
                                       readonly 
                                       data-credential="password-{{ $item->id }}">
                                <button onclick="copyToClipboard('password-{{ $item->id }}')" 
                                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition text-sm font-medium">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                    Copy
                                </button>
                            </div>
                        </div>

                        <!-- Extras (if any) -->
                        <div class="extras-container-{{ $item->id }} hidden mb-4"></div>

                        <!-- Instructions (if any) -->
                        <div class="instructions-container-{{ $item->id }} hidden"></div>
                    </div>

                    <!-- Reveal Button -->
                    <button onclick="revealCredentials({{ $item->id }})" 
                            class="reveal-btn-{{ $item->id }} w-full px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition">
                        🔓 Reveal Credentials
                    </button>

                    <!-- Loading State -->
                    <div class="loading-{{ $item->id }} hidden text-center py-4">
                        <svg class="animate-spin h-6 w-6 text-blue-600 mx-auto" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Loading credentials...</p>
                    </div>

                    <!-- Error State -->
                    <div class="error-{{ $item->id }} hidden bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                        <p class="text-sm text-red-700 dark:text-red-400"></p>
                    </div>
                    @else
                    <!-- View Limit Reached -->
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            <div>
                                <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-400">View Limit Reached</h3>
                                <p class="text-sm text-yellow-700 dark:text-yellow-500 mt-1">
                                    You've reached the maximum number of views for these credentials. Please contact support if you need assistance.
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- View History -->
                    @if($item->credentialViews->count() > 0)
                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Recent Views</h3>
                        <div class="space-y-2">
                            @foreach($item->credentialViews as $view)
                            <div class="flex justify-between items-center text-xs text-gray-600 dark:text-gray-400">
                                <span>{{ $view->viewed_at->format('M d, Y g:i A') }}</span>
                                <span>{{ $view->ip_address }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        @endforeach

        <!-- No Credentials Message -->
        @if($order->items->filter(fn($item) => $item->hasCredentials())->isEmpty())
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-8 text-center">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No Credentials</h3>
            <p class="text-gray-600 dark:text-gray-400">This order doesn't contain any credential-based products.</p>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function revealCredentials(itemId) {
    const revealBtn = document.querySelector(`.reveal-btn-${itemId}`);
    const loading = document.querySelector(`.loading-${itemId}`);
    const credentials = document.querySelector(`.credentials-section-${itemId}`);
    const error = document.querySelector(`.error-${itemId}`);

    // Hide button, show loading
    revealBtn.classList.add('hidden');
    loading.classList.remove('hidden');
    error.classList.add('hidden');

    // Fetch credentials
    fetch(`{{ route('orders.delivery', $order) }}/reveal/${itemId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        loading.classList.add('hidden');
        
        if (data.error) {
            error.classList.remove('hidden');
            error.querySelector('p').textContent = data.error;
            return;
        }

        // Populate credential fields
        document.querySelector(`[data-credential="username-${itemId}"]`).value = data.credentials.username;
        document.querySelector(`[data-credential="password-${itemId}"]`).value = data.credentials.password;

        // Update remaining views
        document.querySelector(`.remaining-views-${itemId}`).textContent = data.remaining_views;

        // Show extras if present
        if (data.credentials.extras && data.credentials.extras.length > 0) {
            const extrasContainer = document.querySelector(`.extras-container-${itemId}`);
            let extrasHtml = '<div class="space-y-3">';
            data.credentials.extras.forEach(extra => {
                extrasHtml += `
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">${extra.k}</label>
                        <div class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white text-sm font-mono break-all">
                            ${extra.v}
                        </div>
                    </div>
                `;
            });
            extrasHtml += '</div>';
            extrasContainer.innerHTML = extrasHtml;
            extrasContainer.classList.remove('hidden');
        }

        // Show instructions if present
        if (data.credentials.instructions) {
            const instructionsContainer = document.querySelector(`.instructions-container-${itemId}`);
            instructionsContainer.innerHTML = `
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <h4 class="text-sm font-medium text-blue-800 dark:text-blue-400 mb-2">📋 Instructions</h4>
                    <p class="text-sm text-blue-700 dark:text-blue-500 whitespace-pre-wrap">${data.credentials.instructions}</p>
                </div>
            `;
            instructionsContainer.classList.remove('hidden');
        }

        // Show credentials
        credentials.classList.remove('hidden');
    })
    .catch(err => {
        loading.classList.add('hidden');
        error.classList.remove('hidden');
        error.querySelector('p').textContent = 'Failed to load credentials. Please try again.';
        console.error(err);
    });
}

function copyToClipboard(dataAttr) {
    const input = document.querySelector(`[data-credential="${dataAttr}"]`);
    input.select();
    document.execCommand('copy');
    
    // Show feedback
    const btn = event.target.closest('button');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg> Copied!';
    setTimeout(() => {
        btn.innerHTML = originalText;
    }, 2000);
}
</script>
@endpush
@endsection

