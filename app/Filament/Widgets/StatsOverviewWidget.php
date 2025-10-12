<?php

namespace App\Filament\Widgets;

use App\Models\Dispute;
use App\Models\Order;
use App\Models\User;
use App\Models\UserSubscription;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $today = now()->startOfDay();
        $weekAgo = now()->subWeek();
        $monthAgo = now()->subMonth();

        // GMV Calculations
        $gmvToday = Order::where('status', 'completed')
            ->where('created_at', '>=', $today)
            ->sum('total');
        
        $gmv7Days = Order::where('status', 'completed')
            ->where('created_at', '>=', $weekAgo)
            ->sum('total');
        
        $gmv30Days = Order::where('status', 'completed')
            ->where('created_at', '>=', $monthAgo)
            ->sum('total');

        // Order counts
        $ordersToday = Order::where('created_at', '>=', $today)->count();
        $orders7Days = Order::where('created_at', '>=', $weekAgo)->count();

        // New users
        $newUsersToday = User::where('created_at', '>=', $today)->count();
        $newUsers7Days = User::where('created_at', '>=', $weekAgo)->count();

        // Active subscriptions
        $activeSubscriptions = UserSubscription::where('status', 'active')->count();

        // Pending disputes
        $pendingDisputes = Dispute::whereIn('status', ['open', 'in_review'])->count();

        // Pending KYC
        $pendingKyc = DB::table('sellers')->where('kyc_status', 'pending')->count();

        return [
            Stat::make('GMV Today', '$' . number_format($gmvToday, 2))
                ->description("7d: $" . number_format($gmv7Days, 2) . " | 30d: $" . number_format($gmv30Days, 2))
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success')
                ->chart($this->getGmvChart()),
            
            Stat::make('Orders', $ordersToday . ' today')
                ->description($orders7Days . ' this week')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('primary'),
            
            Stat::make('New Users', $newUsersToday . ' today')
                ->description($newUsers7Days . ' this week')
                ->descriptionIcon('heroicon-m-user-plus')
                ->color('info'),
            
            Stat::make('Active Subscriptions', $activeSubscriptions)
                ->description('Platform subscribers')
                ->descriptionIcon('heroicon-m-star')
                ->color('warning'),
            
            Stat::make('Pending KYC', $pendingKyc)
                ->description('Awaiting review')
                ->descriptionIcon('heroicon-m-document-check')
                ->color($pendingKyc > 0 ? 'warning' : 'success')
                ->url(route('filament.admin.resources.sellers.index', ['tableFilters[kyc_status][value]' => 'pending'])),
            
            Stat::make('Open Disputes', $pendingDisputes)
                ->description('Require attention')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($pendingDisputes > 0 ? 'danger' : 'success')
                ->url(route('filament.admin.resources.disputes.index', ['tableFilters[status][value]' => 'open'])),
        ];
    }

    protected function getGmvChart(): array
    {
        // Get last 7 days GMV
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->startOfDay();
            $gmv = Order::where('status', 'completed')
                ->whereDate('created_at', $date)
                ->sum('total');
            $data[] = $gmv;
        }
        return $data;
    }

    public function getColumns(): int
    {
        return 3;
    }
}

