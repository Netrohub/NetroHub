<?php

namespace App\Filament\Widgets;

use App\Models\Dispute;
use App\Models\Order;
use App\Models\PayoutRequest;
use App\Models\Product;
use App\Models\Refund;
use App\Models\Seller;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $last30Days = now()->subDays(30);
        $last7Days = now()->subDays(7);

        // GMV (Gross Merchandise Value)
        $gmv30 = (float) Order::where('payment_status', 'completed')
            ->where('created_at', '>=', $last30Days)
            ->sum('total') ?? 0;
        $gmv7 = (float) Order::where('payment_status', 'completed')
            ->where('created_at', '>=', $last7Days)
            ->sum('total') ?? 0;

        // Paid Orders
        $paidOrders30 = (int) Order::where('payment_status', 'completed')
            ->where('created_at', '>=', $last30Days)
            ->count() ?? 0;
        $paidOrders7 = (int) Order::where('payment_status', 'completed')
            ->where('created_at', '>=', $last7Days)
            ->count() ?? 0;

        // Refunds
        $refunds30 = (float) Refund::where('status', 'completed')
            ->where('created_at', '>=', $last30Days)
            ->sum('amount') ?? 0;
        $refunds7 = (float) Refund::where('status', 'completed')
            ->where('created_at', '>=', $last7Days)
            ->sum('amount') ?? 0;

        // Active Listings
        $activeListings = (int) Product::where('status', 'active')->count() ?? 0;
        $activeListings7 = (int) Product::where('status', 'active')
            ->where('created_at', '>=', $last7Days)
            ->count() ?? 0;

        // New Users
        $newUsers30 = (int) User::where('created_at', '>=', $last30Days)->count() ?? 0;
        $newUsers7 = (int) User::where('created_at', '>=', $last7Days)->count() ?? 0;

        // KYC Pending
        $kycPending = (int) Seller::where('kyc_status', 'pending')->count() ?? 0;

        // Open Disputes
        $openDisputes = (int) Dispute::where('status', 'open')->count() ?? 0;

        // Payouts Pending
        $payoutsPending = (int) PayoutRequest::where('status', 'pending')->count() ?? 0;
        $payoutsPendingAmount = (float) PayoutRequest::where('status', 'pending')->sum('amount') ?? 0;

        return [
            Stat::make('GMV (30 days)', '$'.number_format($gmv30, 2))
                ->description('Last 7 days: $'.number_format($gmv7, 2))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Paid Orders (30 days)', number_format($paidOrders30))
                ->description('Last 7 days: '.number_format($paidOrders7))
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('success'),

            Stat::make('Refunds (30 days)', '$'.number_format($refunds30, 2))
                ->description('Last 7 days: $'.number_format($refunds7, 2))
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),

            Stat::make('Active Listings', number_format($activeListings))
                ->description('New in 7 days: '.number_format($activeListings7))
                ->descriptionIcon('heroicon-m-squares-2x2')
                ->color('info'),

            Stat::make('New Users (30 days)', number_format($newUsers30))
                ->description('Last 7 days: '.number_format($newUsers7))
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),

            Stat::make('KYC Pending', number_format($kycPending))
                ->description('Awaiting review')
                ->descriptionIcon('heroicon-m-clock')
                ->color($kycPending > 0 ? 'warning' : 'success'),

            Stat::make('Open Disputes', number_format($openDisputes))
                ->description('Requires attention')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($openDisputes > 0 ? 'danger' : 'success'),

            Stat::make('Payouts Pending', number_format($payoutsPending))
                ->description('Total: $'.number_format($payoutsPendingAmount, 2))
                ->descriptionIcon('heroicon-m-banknotes')
                ->color($payoutsPending > 0 ? 'warning' : 'success'),
        ];
    }
}
