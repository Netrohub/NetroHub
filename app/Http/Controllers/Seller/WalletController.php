<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;

class WalletController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $seller = auth()->user()->seller;

        if (! $seller) {
            return redirect()->route('sell.entry');
        }

        $balance = $seller->getWalletBalance();

        $stats = [
            'total_earnings' => $seller->walletTransactions()->where('type', 'sale')->sum('amount'),
            'total_payouts' => abs($seller->walletTransactions()->where('type', 'payout')->sum('amount')),
            'pending_balance' => $balance,
        ];

        $recentTransactions = $seller->walletTransactions()
            ->with('reference')
            ->latest()
            ->paginate(20);

        return view('seller.wallet.index', compact('seller', 'balance', 'stats', 'recentTransactions'));
    }

    public function transactions()
    {
        $seller = auth()->user()->seller;

        if (! $seller) {
            return redirect()->route('sell.entry');
        }

        $transactions = $seller->walletTransactions()
            ->with('reference')
            ->latest()
            ->paginate(50);

        return view('seller.wallet.transactions', compact('seller', 'transactions'));
    }
}
