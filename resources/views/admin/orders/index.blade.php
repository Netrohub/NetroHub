@extends('admin.layout')

@section('title', 'Orders Management')

@section('content')
<!-- Page header -->
<div class="sm:flex sm:justify-between sm:items-center mb-8">
    <div class="mb-4 sm:mb-0">
        <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Orders Management</h1>
    </div>
    
    <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="flex gap-2">
            <input
                type="search"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search orders..."
                class="admin-input"
            />
            <button type="submit" class="btn-primary">Search</button>
        </form>
    </div>
</div>

<!-- Filters -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700/60 p-4 mb-6">
    <form action="{{ route('admin.orders.index') }}" method="GET" class="flex flex-wrap gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
            <select name="status" class="admin-select">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        <div class="flex items-end">
            <button type="submit" class="btn-secondary">Apply Filters</button>
        </div>
    </form>
</div>

<!-- Orders Table -->
<div class="admin-card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Items</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="font-medium text-violet-500 hover:text-violet-600">
                                #{{ $order->order_number }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('admin.users.show', $order->user) }}" class="text-gray-800 dark:text-gray-100 hover:text-violet-500">
                                {{ $order->user->name }}
                            </a>
                        </td>
                        <td>{{ $order->items->count() }} item(s)</td>
                        <td class="font-semibold text-lg">${{ number_format($order->total, 2) }}</td>
                        <td>
                            @if($order->payment_status === 'completed')
                                <span class="badge badge-success">Completed</span>
                            @elseif($order->payment_status === 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @elseif($order->payment_status === 'cancelled')
                                <span class="badge badge-danger">Cancelled</span>
                            @else
                                <span class="badge badge-info">{{ ucfirst($order->payment_status) }}</span>
                            @endif
                        </td>
                        <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-violet-500 hover:text-violet-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-gray-500 dark:text-gray-400">No orders found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $orders->links() }}
</div>
@endsection

