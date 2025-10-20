@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<!-- Page header -->
<div class="sm:flex sm:justify-between sm:items-center mb-8">
    <!-- Left: Title -->
    <div class="mb-4 sm:mb-0">
        <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Dashboard</h1>
    </div>
    
    <!-- Right: Actions -->
    <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
        <button class="btn-secondary">
            <svg class="fill-current w-4 h-4 mr-2" viewBox="0 0 16 16">
                <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
            </svg>
            <span>Export</span>
        </button>
    </div>

    <!-- Top Countries (donut) -->
    <div class="col-span-full lg:col-span-6">
        <div class="admin-card p-6">
            <header class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Top Countries</h2>
            </header>
            <div class="h-64"><canvas id="countriesDonut"></canvas></div>
        </div>
    </div>

    <!-- Top Channels table -->
    <div class="col-span-full lg:col-span-6">
        <div class="admin-card p-6">
            <header class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Top Channels</h2>
            </header>
            <div class="overflow-x-auto">
                <table class="admin-table w-full">
                    <thead>
                        <tr>
                            <th>Source</th>
                            <th>Orders</th>
                            <th>Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($channels as $row)
                            <tr>
                                <td>{{ $row->src }}</td>
                                <td>{{ number_format($row->orders) }}</td>
                                <td>${{ number_format($row->revenue,2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-gray-500 dark:text-gray-400">No data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- Stats Cards -->
<div class="grid grid-cols-12 gap-6 mb-8">
    <!-- Card 1: Total Users -->
    <div class="col-span-full sm:col-span-6 xl:col-span-3">
        <div class="stat-card">
            <div class="flex items-start justify-between">
                <div>
                    <div class="stat-label mb-2">Total Users</div>
                    <div class="stat-value">{{ number_format($totalUsers) }}</div>
                </div>
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-violet-100 dark:bg-violet-500/10">
                    <svg class="w-6 h-6 fill-current text-violet-500" viewBox="0 0 16 16">
                        <path d="M8 8a3 3 0 1 1 0-6 3 3 0 0 1 0 6Zm0-2a1 1 0 1 0 0-2 1 1 0 0 0 0 2ZM14 14v-1a3 3 0 0 0-3-3H5a3 3 0 0 0-3 3v1a1 1 0 1 0 2 0v-1a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v1a1 1 0 1 0 2 0Z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="stat-change positive flex items-center">
                    <svg class="w-4 h-4 mr-1" viewBox="0 0 16 16" fill="currentColor">
                        <path d="M8 3a.5.5 0 0 1 .5.5v7.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 1 1 .708-.708L7.5 11.293V3.5A.5.5 0 0 1 8 3Z"/>
                    </svg>
                    <span>+{{ $newUsersThisMonth }} this month</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Total Products -->
    <div class="col-span-full sm:col-span-6 xl:col-span-3">
        <div class="stat-card">
            <div class="flex items-start justify-between">
                <div>
                    <div class="stat-label mb-2">Total Products</div>
                    <div class="stat-value">{{ number_format($totalProducts) }}</div>
                </div>
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-green-100 dark:bg-green-500/10">
                    <svg class="w-6 h-6 fill-current text-green-500" viewBox="0 0 16 16">
                        <path d="M14.29 2.614a1 1 0 0 0-.29-.614 1 1 0 0 0-.616-.293L.583 0 0 12.8l6.41 3.212A5.925 5.925 0 0 0 8 16c.996 0 1.995-.251 2.888-.733 2.762-1.489 3.87-4.896 2.48-7.668a5.93 5.93 0 0 0-1.064-1.419l1.986-3.566ZM10 13.968A3.999 3.999 0 1 1 14 10c0 1.487-.81 2.784-2 3.48V8a1 1 0 0 0-2 0v5.968Z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    <span class="font-medium text-green-600 dark:text-green-400">{{ number_format($activeProducts) }}</span> active
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Total Orders -->
    <div class="col-span-full sm:col-span-6 xl:col-span-3">
        <div class="stat-card">
            <div class="flex items-start justify-between">
                <div>
                    <div class="stat-label mb-2">Total Orders</div>
                    <div class="stat-value">{{ number_format($totalOrders) }}</div>
                </div>
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-yellow-100 dark:bg-yellow-500/10">
                    <svg class="w-6 h-6 fill-current text-yellow-500" viewBox="0 0 16 16">
                        <path d="M15.402 7.352a1.007 1.007 0 0 0-.822-1.006l-3.741-.551L9.174 2.427a1.023 1.023 0 0 0-1.848 0L5.661 5.795l-3.741.551A1.007 1.007 0 0 0 1.357 8.18l2.706 2.635-.638 3.723a1.002 1.002 0 0 0 1.453 1.059L8 13.943l3.35 1.652a1.002 1.002 0 0 0 1.453-1.059l-.638-3.723 2.706-2.635a1.003 1.003 0 0 0 .531-.826Z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="stat-change positive flex items-center">
                    <svg class="w-4 h-4 mr-1" viewBox="0 0 16 16" fill="currentColor">
                        <path d="M8 3a.5.5 0 0 1 .5.5v7.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 1 1 .708-.708L7.5 11.293V3.5A.5.5 0 0 1 8 3Z"/>
                    </svg>
                    <span>+{{ $ordersThisMonth }} this month</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Total Revenue -->
    <div class="col-span-full sm:col-span-6 xl:col-span-3">
        <div class="stat-card">
            <div class="flex items-start justify-between">
                <div>
                    <div class="stat-label mb-2">Total Revenue</div>
                    <div class="stat-value">${{ number_format($totalRevenue, 2) }}</div>
                </div>
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-red-100 dark:bg-red-500/10">
                    <svg class="w-6 h-6 fill-current text-red-500" viewBox="0 0 16 16">
                        <path d="M15 8H9V2c0-.6-.4-1-1-1S7 1.4 7 2v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V10h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="stat-change positive flex items-center">
                    <svg class="w-4 h-4 mr-1" viewBox="0 0 16 16" fill="currentColor">
                        <path d="M8 3a.5.5 0 0 1 .5.5v7.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 1 1 .708-.708L7.5 11.293V3.5A.5.5 0 0 1 8 3Z"/>
                    </svg>
                    <span>${{ number_format($revenueThisMonth, 2) }} this month</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="grid grid-cols-12 gap-6 mb-8">
    <!-- Revenue Chart -->
    <div class="col-span-full xl:col-span-8">
        <div class="admin-card p-6">
            <header class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Revenue Overview</h2>
            </header>
            <div class="flex-grow">
                <canvas id="revenueChart" width="800" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- Real Time Value (sparkline) -->
    <div class="col-span-full xl:col-span-4">
        <div class="admin-card p-6">
            <header class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Real Time Value</h2>
            </header>
            <div class="h-48"><canvas id="sparklineChart"></canvas></div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="grid grid-cols-12 gap-6">
    <!-- Recent Orders -->
    <div class="col-span-full">
        <div class="admin-card">
            <header class="px-6 py-4 border-b border-gray-200 dark:border-gray-700/60">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Recent Orders</h2>
            </header>
            <div class="overflow-x-auto">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order) }}" class="font-medium text-violet-500 hover:text-violet-600">
                                        #{{ $order->order_number }}
                                    </a>
                                </td>
                                <td>{{ $order->user->name }}</td>
                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                <td class="font-semibold">${{ number_format($order->total, 2) }}</td>
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
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-gray-500 dark:text-gray-400">No orders yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('revenueChart');
    if (ctx) {
        const isDark = document.documentElement.classList.contains('dark');
        const textColor = isDark ? '#f3f4f6' : '#374151';
        const gridColor = isDark ? '#374151' : '#e5e7eb';
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($revenueByMonth->pluck('month')->map(function($month) { return date('M', mktime(0, 0, 0, $month, 1)); })) !!},
                datasets: [{
                    label: 'Revenue',
                    data: {!! json_encode($revenueByMonth->pluck('revenue')) !!},
                    borderColor: '#8470ff',
                    backgroundColor: 'rgba(132, 112, 255, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#8470ff',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: isDark ? '#1f2937' : '#111827',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: gridColor,
                        borderWidth: 1,
                        padding: 12,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return '$' + context.parsed.y.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: textColor
                        }
                    },
                    y: {
                        grid: {
                            color: gridColor,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            color: textColor,
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    }

    // sparkline (orders last 30 days)
    const spark = document.getElementById('sparklineChart');
    if (spark) {
        new Chart(spark, {
            type: 'line',
            data: {
                labels: {!! json_encode($dailyOrders->pluck('day')->map(fn($d)=>\Carbon\Carbon::parse($d)->format('d M'))) !!},
                datasets: [{
                    data: {!! json_encode($dailyOrders->pluck('cnt')) !!},
                    borderColor: '#8b5cf6',
                    backgroundColor: 'rgba(139,92,246,0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                    pointRadius: 0,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { x: { display: false }, y: { display: false } }
            }
        });
    }

    // countries donut
    const donut = document.getElementById('countriesDonut');
    if (donut) {
        new Chart(donut, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($countries->pluck('country')) !!},
                datasets: [{
                    data: {!! json_encode($countries->pluck('revenue')) !!},
                    backgroundColor: ['#8b5cf6','#06b6d4','#f59e0b','#10b981','#ef4444','#6366f1'],
                }]
            },
            options: { plugins: { legend: { position: 'bottom' } }, cutout: '65%' }
        });
    }
});
</script>
@endpush

