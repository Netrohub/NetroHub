<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Get key metrics
        $totalUsers = User::count();
        $newUsersThisMonth = User::whereMonth('created_at', Carbon::now()->month)->count();
        
        $totalProducts = Product::count();
        $activeProducts = Product::where('status', 'approved')->count();
        
        $totalOrders = Order::count();
        $ordersThisMonth = Order::whereMonth('created_at', Carbon::now()->month)->count();
        
        $totalRevenue = Order::where('payment_status', 'completed')->sum('total');
        $revenueThisMonth = Order::where('payment_status', 'completed')
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('total');
        
        // Get chart data - Revenue over last 12 months
        $revenueByMonth = Order::where('payment_status', 'completed')
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(total) as revenue')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Revenue last 30 days (daily)
        $dailyRevenue = Order::where('payment_status', 'completed')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->selectRaw('DATE(created_at) as day, SUM(total) as revenue')
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        // Orders last 30 days (daily)
        $dailyOrders = Order::where('created_at', '>=', Carbon::now()->subDays(30))
            ->selectRaw('DATE(created_at) as day, COUNT(*) as cnt')
            ->groupBy('day')
            ->orderBy('day')
            ->get();
        
        // Get recent orders
        $recentOrders = Order::with(['user', 'items.product'])
            ->latest()
            ->take(10)
            ->get();
        
        // Get top products
        $topProducts = Product::withCount('orderItems')
            ->having('order_items_count', '>', 0)
            ->orderBy('order_items_count', 'desc')
            ->take(5)
            ->get();
        
        // Get recent users
        $recentUsers = User::latest()->take(5)->get();

        // Aggregate channels and countries (with sensible fallbacks)
        $channels = Order::selectRaw("COALESCE(NULLIF(source,''), 'Direct') as src, COUNT(*) as orders, SUM(total) as revenue")
            ->groupBy('src')
            ->orderByDesc('revenue')
            ->get();

        $countries = Order::selectRaw("COALESCE(NULLIF(billing_country,''), 'XX') as country, COUNT(*) as orders, SUM(total) as revenue")
            ->groupBy('country')
            ->orderByDesc('revenue')
            ->take(6)
            ->get();
        
        return view('admin.dashboard', compact(
            'totalUsers',
            'newUsersThisMonth',
            'totalProducts',
            'activeProducts',
            'totalOrders',
            'ordersThisMonth',
            'totalRevenue',
            'revenueThisMonth',
            'revenueByMonth',
            'dailyRevenue',
            'dailyOrders',
            'recentOrders',
            'topProducts',
            'recentUsers',
            'channels',
            'countries'
        ));
    }
}

