<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\UserSubscription;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdvancedStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        // Revenue calculations
        $totalRevenue = Order::where('status', 'completed')->sum('total');
        $monthlyRevenue = Order::where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');
        $lastMonthRevenue = Order::where('status', 'completed')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->sum('total');
        
        $revenueChange = $lastMonthRevenue > 0 
            ? (($monthlyRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100 
            : 0;

        // User calculations
        $totalUsers = User::count();
        $newUsersThisMonth = User::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $newUsersLastMonth = User::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
        
        $userGrowth = $newUsersLastMonth > 0 
            ? (($newUsersThisMonth - $newUsersLastMonth) / $newUsersLastMonth) * 100 
            : 0;

        // Product calculations
        $totalProducts = Product::count();
        $activeProducts = Product::where('status', 'active')->count();

        // Subscription calculations
        $activeSubscriptions = UserSubscription::where('status', 'active')->count();
        $subscriptionRevenue = UserSubscription::whereHas('plan', function($q) {
            $q->where('slug', '!=', 'free');
        })->where('status', 'active')->count();

        return [
            Stat::make('Total Revenue', '$' . number_format($totalRevenue, 2))
                ->description(($revenueChange >= 0 ? '+' : '') . number_format($revenueChange, 1) . '% from last month')
                ->descriptionIcon($revenueChange >= 0 ? 'heroicon-o-arrow-trending-up' : 'heroicon-o-arrow-trending-down')
                ->color($revenueChange >= 0 ? 'success' : 'danger')
                ->chart([
                    $lastMonthRevenue - 5000,
                    $lastMonthRevenue - 3000,
                    $lastMonthRevenue,
                    $monthlyRevenue - 2000,
                    $monthlyRevenue,
                ]),
            
            Stat::make('Total Users', number_format($totalUsers))
                ->description('+' . $newUsersThisMonth . ' this month (' . ($userGrowth >= 0 ? '+' : '') . number_format($userGrowth, 1) . '%)')
                ->descriptionIcon('heroicon-o-users')
                ->color('info')
                ->chart([
                    $totalUsers - $newUsersThisMonth - $newUsersLastMonth,
                    $totalUsers - $newUsersThisMonth,
                    $totalUsers,
                ]),
            
            Stat::make('Active Products', number_format($activeProducts))
                ->description(number_format($totalProducts) . ' total listings')
                ->descriptionIcon('heroicon-o-shopping-bag')
                ->color('warning')
                ->chart([
                    $activeProducts - 20,
                    $activeProducts - 10,
                    $activeProducts,
                ]),
            
            Stat::make('Active Subscriptions', number_format($activeSubscriptions))
                ->description($subscriptionRevenue . ' paying customers')
                ->descriptionIcon('heroicon-o-credit-card')
                ->color('success')
                ->chart([
                    $activeSubscriptions - 10,
                    $activeSubscriptions - 5,
                    $activeSubscriptions,
                ]),
        ];
    }
}


