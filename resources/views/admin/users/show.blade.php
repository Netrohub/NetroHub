@extends('admin.layout')

@section('title', 'User Details')

@section('content')
<!-- Page header -->
<div class="mb-8">
    <a href="{{ route('admin.users.index') }}" class="text-violet-500 hover:text-violet-600 mb-4 inline-flex items-center">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Users
    </a>
    <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">User Details</h1>
</div>

<div class="grid grid-cols-12 gap-6">
    <!-- User Info -->
    <div class="col-span-full xl:col-span-4">
        <div class="admin-card p-6">
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-violet-100 dark:bg-violet-500/10 text-violet-600 dark:text-violet-400 font-bold text-2xl mb-4">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">{{ $user->name }}</h2>
                <p class="text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
            </div>

            <div class="space-y-4">
                <div>
                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Roles</div>
                    <div class="flex flex-wrap gap-2">
                        @foreach($user->roles as $role)
                            <span class="badge badge-info">{{ $role->name }}</span>
                        @endforeach
                        @if($user->roles->isEmpty())
                            <span class="text-gray-500 dark:text-gray-400 text-sm">No roles assigned</span>
                        @endif
                    </div>
                </div>

                <div>
                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Email Status</div>
                    @if($user->email_verified_at)
                        <span class="badge badge-success">Verified on {{ $user->email_verified_at->format('M d, Y') }}</span>
                    @else
                        <span class="badge badge-warning">Not Verified</span>
                    @endif
                </div>

                <div>
                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Member Since</div>
                    <div class="font-medium text-gray-800 dark:text-gray-100">{{ $user->created_at->format('F d, Y') }}</div>
                </div>

                <div>
                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Last Updated</div>
                    <div class="font-medium text-gray-800 dark:text-gray-100">{{ $user->updated_at->diffForHumans() }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity -->
    <div class="col-span-full xl:col-span-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Total Orders -->
            <div class="stat-card">
                <div class="stat-label mb-2">Total Orders</div>
                <div class="stat-value">{{ $user->orders->count() }}</div>
            </div>

            <!-- Total Products -->
            <div class="stat-card">
                <div class="stat-label mb-2">Total Products</div>
                <div class="stat-value">{{ $user->products->count() }}</div>
            </div>

            <!-- Total Reviews -->
            <div class="stat-card">
                <div class="stat-label mb-2">Total Reviews</div>
                <div class="stat-value">{{ $user->reviews->count() }}</div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="admin-card mb-6">
            <header class="px-6 py-4 border-b border-gray-200 dark:border-gray-700/60">
                <h3 class="font-semibold text-gray-800 dark:text-gray-100">Recent Orders</h3>
            </header>
            <div class="overflow-x-auto">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($user->orders->take(5) as $order)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order) }}" class="font-medium text-violet-500 hover:text-violet-600">
                                        #{{ $order->order_number }}
                                    </a>
                                </td>
                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                <td class="font-semibold">${{ number_format($order->total_amount, 2) }}</td>
                                <td>
                                    @if($order->status === 'completed')
                                        <span class="badge badge-success">Completed</span>
                                    @elseif($order->status === 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @else
                                        <span class="badge badge-info">{{ ucfirst($order->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-gray-500 dark:text-gray-400">No orders yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Products -->
        @if($user->products->count() > 0)
        <div class="admin-card">
            <header class="px-6 py-4 border-b border-gray-200 dark:border-gray-700/60">
                <h3 class="font-semibold text-gray-800 dark:text-gray-100">Recent Products</h3>
            </header>
            <div class="overflow-x-auto">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user->products->take(5) as $product)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.products.show', $product) }}" class="font-medium text-violet-500 hover:text-violet-600">
                                        {{ $product->title }}
                                    </a>
                                </td>
                                <td class="font-semibold">${{ number_format($product->price, 2) }}</td>
                                <td>{{ $product->category->name ?? 'N/A' }}</td>
                                <td>
                                    @if($product->status === 'approved')
                                        <span class="badge badge-success">Approved</span>
                                    @elseif($product->status === 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @else
                                        <span class="badge badge-danger">Rejected</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

