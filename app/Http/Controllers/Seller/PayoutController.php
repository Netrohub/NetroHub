<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PayoutController extends Controller
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

        $payoutRequests = $seller->payoutRequests()
            ->latest()
            ->paginate(20);

        $balance = $seller->getWalletBalance();

        return view('seller.payouts.index', compact('seller', 'payoutRequests', 'balance'));
    }

    public function create()
    {
        $seller = auth()->user()->seller;

        if (! $seller) {
            return redirect()->route('sell.entry');
        }

        if (! $seller->canRequestPayout()) {
            return redirect()->route('seller.payouts.index')
                ->with('error', 'You cannot request a payout at this time. Please ensure your KYC is approved and you have a positive balance.');
        }

        $balance = $seller->getWalletBalance();

        return view('seller.payouts.create', compact('seller', 'balance'));
    }

    public function store(Request $request)
    {
        $seller = auth()->user()->seller;

        if (! $seller->canRequestPayout()) {
            return back()->with('error', 'You cannot request a payout at this time.');
        }

        $balance = $seller->getWalletBalance();

        $validated = $request->validate([
            'amount' => "required|numeric|min:10|max:{$balance}",
            'payout_method' => 'required|string',
            'payout_details' => 'required|array',
        ]);

        $payoutRequest = $seller->payoutRequests()->create([
            'amount' => $validated['amount'],
            'status' => 'pending',
            'payout_method' => $validated['payout_method'],
            'payout_details' => $validated['payout_details'],
        ]);

        \App\Models\ActivityLog::log(
            'payout_requested',
            $payoutRequest,
            "Payout request for {$validated['amount']} created"
        );

        return redirect()->route('seller.payouts.index')
            ->with('success', 'Payout request submitted successfully! We will process it within 3-5 business days.');
    }
}
