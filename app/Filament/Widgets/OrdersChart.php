<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class OrdersChart extends ChartWidget
{
    protected static ?string $heading = 'Orders & Revenue (Last 30 Days)';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = $this->getOrdersPerDay();

        return [
            'datasets' => [
                [
                    'label' => 'Orders',
                    'data' => $data['ordersPerDay'],
                    'borderColor' => 'rgb(59, 130, 246)',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                ],
                [
                    'label' => 'Revenue ($)',
                    'data' => $data['revenuePerDay'],
                    'borderColor' => 'rgb(34, 197, 94)',
                    'backgroundColor' => 'rgba(34, 197, 94, 0.1)',
                ],
            ],
            'labels' => $data['labels'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    private function getOrdersPerDay(): array
    {
        $days = collect();
        $ordersPerDay = [];
        $revenuePerDay = [];
        $labels = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels[] = $date->format('M d');

            $orders = Order::whereDate('created_at', $date)
                ->where('payment_status', 'completed');

            $ordersPerDay[] = $orders->count();
            $revenuePerDay[] = (float) $orders->sum('total');
        }

        return [
            'ordersPerDay' => $ordersPerDay,
            'revenuePerDay' => $revenuePerDay,
            'labels' => $labels,
        ];
    }
}
