@extends('admin.layout')

@section('title', 'Product Details')

@section('content')
<!-- Page header -->
<div class="mb-8">
    <a href="{{ route('admin.products.index') }}" class="text-violet-500 hover:text-violet-600 mb-4 inline-flex items-center">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Products
    </a>
    <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">{{ $product->title }}</h1>
</div>

<div class="grid grid-cols-12 gap-6">
    <!-- Product Info -->
    <div class="col-span-full xl:col-span-8">
        <div class="admin-card p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Product Information</h2>
            
            <div class="space-y-4">
                <div>
                    <label class="text-sm text-gray-600 dark:text-gray-400">Title</label>
                    <div class="text-gray-800 dark:text-gray-100 font-medium">{{ $product->title }}</div>
                </div>

                <div>
                    <label class="text-sm text-gray-600 dark:text-gray-400">Description</label>
                    <div class="text-gray-800 dark:text-gray-100">{{ $product->description }}</div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-gray-600 dark:text-gray-400">Category</label>
                        <div class="text-gray-800 dark:text-gray-100 font-medium">{{ $product->category->name ?? 'N/A' }}</div>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600 dark:text-gray-400">Price</label>
                        <div class="text-gray-800 dark:text-gray-100 font-medium text-xl">${{ number_format($product->price, 2) }}</div>
                    </div>
                </div>

                <div>
                    <label class="text-sm text-gray-600 dark:text-gray-400">Seller</label>
                    <div class="text-gray-800 dark:text-gray-100 font-medium">
                        <a href="{{ route('admin.users.show', $product->seller) }}" class="text-violet-500 hover:text-violet-600">
                            {{ $product->seller->name }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews -->
        <div class="admin-card">
            <header class="px-6 py-4 border-b border-gray-200 dark:border-gray-700/60">
                <h3 class="font-semibold text-gray-800 dark:text-gray-100">Reviews ({{ $product->reviews->count() }})</h3>
            </header>
            <div class="p-6">
                @forelse($product->reviews->take(5) as $review)
                    <div class="mb-4 pb-4 border-b border-gray-200 dark:border-gray-700/60 last:border-0 last:mb-0 last:pb-0">
                        <div class="flex items-center justify-between mb-2">
                            <div class="font-medium text-gray-800 dark:text-gray-100">{{ $review->user->name }}</div>
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-yellow-500' : 'fill-gray-300 dark:fill-gray-600' }}" viewBox="0 0 16 16">
                                        <path d="M15.402 7.352a1.007 1.007 0 0 0-.822-1.006l-3.741-.551L9.174 2.427a1.023 1.023 0 0 0-1.848 0L5.661 5.795l-3.741.551A1.007 1.007 0 0 0 1.357 8.18l2.706 2.635-.638 3.723a1.002 1.002 0 0 0 1.453 1.059L8 13.943l3.35 1.652a1.002 1.002 0 0 0 1.453-1.059l-.638-3.723 2.706-2.635a1.003 1.003 0 0 0 .531-.826Z" />
                                    </svg>
                                @endfor
                            </div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $review->comment }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400 text-sm">No reviews yet</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-span-full xl:col-span-4">
        <!-- Status -->
        <div class="admin-card p-6 mb-6">
            <h3 class="font-semibold text-gray-800 dark:text-gray-100 mb-4">Status Management</h3>
            
            <form action="{{ route('admin.products.update-status', $product) }}" method="POST">
                @csrf
                @method('PATCH')
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Current Status</label>
                    <select name="status" class="admin-select">
                        <option value="pending" {{ $product->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ $product->status === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ $product->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                
                <button type="submit" class="btn-primary w-full">Update Status</button>
            </form>
        </div>

        <!-- Stats -->
        <div class="admin-card p-6">
            <h3 class="font-semibold text-gray-800 dark:text-gray-100 mb-4">Statistics</h3>
            
            <div class="space-y-4">
                <div>
                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Total Sales</div>
                    <div class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $product->orderItems->count() }}</div>
                </div>

                <div>
                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Average Rating</div>
                    <div class="flex items-center">
                        <div class="text-2xl font-bold text-gray-800 dark:text-gray-100 mr-2">
                            {{ $product->reviews->count() > 0 ? number_format($product->reviews->avg('rating'), 1) : 'N/A' }}
                        </div>
                        @if($product->reviews->count() > 0)
                            <div class="flex">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= round($product->reviews->avg('rating')) ? 'fill-yellow-500' : 'fill-gray-300' }}" viewBox="0 0 16 16">
                                        <path d="M15.402 7.352a1.007 1.007 0 0 0-.822-1.006l-3.741-.551L9.174 2.427a1.023 1.023 0 0 0-1.848 0L5.661 5.795l-3.741.551A1.007 1.007 0 0 0 1.357 8.18l2.706 2.635-.638 3.723a1.002 1.002 0 0 0 1.453 1.059L8 13.943l3.35 1.652a1.002 1.002 0 0 0 1.453-1.059l-.638-3.723 2.706-2.635a1.003 1.003 0 0 0 .531-.826Z" />
                                    </svg>
                                @endfor
                            </div>
                        @endif
                    </div>
                </div>

                <div>
                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Created</div>
                    <div class="font-medium text-gray-800 dark:text-gray-100">{{ $product->created_at->format('M d, Y') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

