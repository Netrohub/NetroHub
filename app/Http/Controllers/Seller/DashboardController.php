<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $seller = auth()->user()->seller;

        if (! $seller) {
            return redirect()->route('sell.entry');
        }

        $stats = [
            'total_products' => $seller->products()->count(),
            'active_products' => $seller->products()->where('status', 'active')->count(),
            'total_sales' => $seller->orderItems()->count(),
            'revenue' => $seller->orderItems()->sum('seller_amount'),
            'wallet_balance' => $seller->getWalletBalance(),
            'pending_payouts' => $seller->payoutRequests()->pending()->count(),
        ];

        $recentSales = $seller->orderItems()
            ->with(['product', 'order.user'])
            ->latest()
            ->take(10)
            ->get();

        $topProducts = $seller->products()
            ->orderBy('sales_count', 'desc')
            ->take(5)
            ->get();

        return view('seller.dashboard', compact('seller', 'stats', 'recentSales', 'topProducts'));
    }

    public function settings()
    {
        $seller = auth()->user()->seller;

        if (! $seller) {
            return redirect()->route('sell.entry');
        }

        return view('seller.settings', compact('seller'));
    }

    public function updateSettings(Request $request)
    {
        $seller = auth()->user()->seller;

        $validated = $request->validate([
            'display_name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'payout_method' => 'nullable|string',
            'payout_details' => 'nullable|array',
        ]);

        $seller->update($validated);

        return back()->with('success', 'Settings updated successfully!');
    }
}
