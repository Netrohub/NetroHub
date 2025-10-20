@extends('admin.layout')

@section('title', 'Products Management')

@section('content')
<!-- Page header -->
<div class="sm:flex sm:justify-between sm:items-center mb-8">
    <div class="mb-4 sm:mb-0">
        <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Products Management</h1>
    </div>
    
    <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
        <form action="{{ route('admin.products.index') }}" method="GET" class="flex gap-2">
            <input
                type="search"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search products..."
                class="admin-input"
            />
            <button type="submit" class="btn-primary">Search</button>
        </form>
    </div>
</div>

<!-- Filters -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700/60 p-4 mb-6">
    <form action="{{ route('admin.products.index') }}" method="GET" class="flex flex-wrap gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
            <select name="status" class="admin-select">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>
        <div class="flex items-end">
            <button type="submit" class="btn-secondary">Apply Filters</button>
        </div>
    </form>
</div>

<!-- Products Table -->
<div class="admin-card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Seller</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 fill-current text-gray-400" viewBox="0 0 16 16">
                                        <path d="M14.29 2.614a1 1 0 0 0-.29-.614 1 1 0 0 0-.616-.293L.583 0 0 12.8l6.41 3.212A5.925 5.925 0 0 0 8 16c.996 0 1.995-.251 2.888-.733 2.762-1.489 3.87-4.896 2.48-7.668a5.93 5.93 0 0 0-1.064-1.419l1.986-3.566Z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <div class="font-medium text-gray-800 dark:text-gray-100">{{ Str::limit($product->title, 40) }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $product->seller->name }}</td>
                        <td>{{ $product->category->name ?? 'N/A' }}</td>
                        <td class="font-semibold">${{ number_format($product->price, 2) }}</td>
                        <td>
                            @if($product->status === 'approved')
                                <span class="badge badge-success">Approved</span>
                            @elseif($product->status === 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @else
                                <span class="badge badge-danger">Rejected</span>
                            @endif
                        </td>
                        <td>{{ $product->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.products.show', $product) }}" class="text-violet-500 hover:text-violet-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-gray-500 dark:text-gray-400">No products found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $products->links() }}
</div>
@endsection

