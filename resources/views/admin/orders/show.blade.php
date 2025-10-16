@extends('admin.layout')

@section('title', 'Order Details')

@section('content')
<!-- Page header -->
<div class="mb-8">
    <a href="{{ route('admin.orders.index') }}" class="text-violet-500 hover:text-violet-600 mb-4 inline-flex items-center">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Orders
    </a>
    <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Order #{{ $order->order_number }}</h1>
</div>

<div class="grid grid-cols-12 gap-6">
    <!-- Order Items -->
    <div class="col-span-full xl:col-span-8">
        <div class="admin-card mb-6">
            <header class="px-6 py-4 border-b border-gray-200 dark:border-gray-700/60">
                <h3 class="font-semibold text-gray-800 dark:text-gray-100">Order Items</h3>
            </header>
            <div class="overflow-x-auto">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center shrink-0">
                                            <svg class="w-5 h-5 fill-current text-gray-400" viewBox="0 0 16 16">
                                                <path d="M14.29 2.614a1 1 0 0 0-.29-.614 1 1 0 0 0-.616-.293L.583 0 0 12.8l6.41 3.212A5.925 5.925 0 0 0 8 16c.996 0 1.995-.251 2.888-.733 2.762-1.489 3.87-4.896 2.48-7.668a5.93 5.93 0 0 0-1.064-1.419l1.986-3.566Z" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <a href="{{ route('admin.products.show', $item->product) }}" class="font-medium text-violet-500 hover:text-violet-600">
                                                {{ $item->product->title }}
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td class="font-semibold">${{ number_format($item->price, 2) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td class="font-semibold text-lg">${{ number_format($item->price * $item->quantity, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="font-semibold">
                            <td colspan="3" class="text-right">Total:</td>
                            <td class="text-lg text-violet-600 dark:text-violet-400">${{ number_format($order->total, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Refunds -->
        @if($order->refunds->count() > 0)
        <div class="admin-card">
            <header class="px-6 py-4 border-b border-gray-200 dark:border-gray-700/60">
                <h3 class="font-semibold text-gray-800 dark:text-gray-100">Refunds</h3>
            </header>
            <div class="p-6">
                @foreach($order->refunds as $refund)
                    <div class="mb-4 pb-4 border-b border-gray-200 dark:border-gray-700/60 last:border-0 last:mb-0 last:pb-0">
                        <div class="flex items-center justify-between mb-2">
                            <div class="font-medium text-gray-800 dark:text-gray-100">Refund #{{ $refund->id }}</div>
                            <div class="font-semibold text-red-600">${{ number_format($refund->amount, 2) }}</div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $refund->reason }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">{{ $refund->created_at->format('M d, Y H:i') }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <!-- Order Info Sidebar -->
    <div class="col-span-full xl:col-span-4">
        <!-- Customer Info -->
        <div class="admin-card p-6 mb-6">
            <h3 class="font-semibold text-gray-800 dark:text-gray-100 mb-4">Customer Information</h3>
            
            <div class="space-y-3">
                <div>
                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Name</div>
                    <a href="{{ route('admin.users.show', $order->user) }}" class="font-medium text-violet-500 hover:text-violet-600">
                        {{ $order->user->name }}
                    </a>
                </div>

                <div>
                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Email</div>
                    <div class="text-gray-800 dark:text-gray-100">{{ $order->user->email }}</div>
                </div>
            </div>
        </div>

        <!-- Order Status -->
        <div class="admin-card p-6 mb-6">
            <h3 class="font-semibold text-gray-800 dark:text-gray-100 mb-4">Order Status</h3>
            
            <div class="space-y-3">
                <div>
                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-2">Current Status</div>
                    @if($order->payment_status === 'completed')
                        <span class="badge badge-success">Completed</span>
                    @elseif($order->payment_status === 'pending')
                        <span class="badge badge-warning">Pending</span>
                    @elseif($order->payment_status === 'cancelled')
                        <span class="badge badge-danger">Cancelled</span>
                    @else
                        <span class="badge badge-info">{{ ucfirst($order->payment_status) }}</span>
                    @endif
                </div>

                <div>
                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Order Date</div>
                    <div class="text-gray-800 dark:text-gray-100">{{ $order->created_at->format('M d, Y H:i') }}</div>
                </div>

                <div>
                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Last Updated</div>
                    <div class="text-gray-800 dark:text-gray-100">{{ $order->updated_at->diffForHumans() }}</div>
                </div>
            </div>
        </div>

        <!-- Payment Info -->
        <div class="admin-card p-6">
            <h3 class="font-semibold text-gray-800 dark:text-gray-100 mb-4">Payment Information</h3>
            
            <div class="space-y-3">
                <div>
                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Payment Method</div>
                    <div class="text-gray-800 dark:text-gray-100">{{ ucfirst($order->payment_method ?? 'N/A') }}</div>
                </div>

                <div>
                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Transaction ID</div>
                    <div class="text-gray-800 dark:text-gray-100 font-mono text-xs">{{ $order->transaction_id ?? 'N/A' }}</div>
                </div>

                <div>
                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Total Amount</div>
                    <div class="text-2xl font-bold text-violet-600 dark:text-violet-400">${{ number_format($order->total, 2) }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

