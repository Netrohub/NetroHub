<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LeaderboardController extends Controller
{
    /**
     * Display seller leaderboard and popular products
     */
    public function index(Request $request): View
    {
        // Get top sellers ranked by reviews and sales
        $topSellers = Seller::with(['user'])
            ->where('is_active', true)
            ->orderBy('rating', 'desc')
            ->orderBy('total_sales', 'desc')
            ->limit(10)
            ->get();

        // Get popular products
        $popularProducts = Product::with(['seller.user', 'category'])
            ->where('status', 'active')
            ->orderBy('sales_count', 'desc')
            ->orderBy('rating', 'desc')
            ->limit(8)
            ->get();

        // Get stats
        $stats = [
            'active_sellers' => Seller::where('is_active', true)->count(),
            'total_products' => Product::where('status', 'active')->count(),
            'avg_rating' => Seller::where('is_active', true)->avg('rating') ?? 0,
        ];

        return view('pages.leaderboard', compact('topSellers', 'popularProducts', 'stats'));
    }
}