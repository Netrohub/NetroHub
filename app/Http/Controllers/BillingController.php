<?php

namespace App\Http\Controllers;

use App\Services\EntitlementsService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BillingController extends Controller
{
    public function __construct(
        protected EntitlementsService $entitlementsService
    ) {}

    /**
     * Display billing page
     */
    public function index(Request $request): View
    {
        $user = auth()->user();
        $subscription = $user->activeSubscription;
        $plan = $subscription?->plan;

        // Get entitlements
        $entitlements = $user->entitlements;

        return view('billing.index', compact('user', 'subscription', 'plan', 'entitlements'));
    }

    /**
     * Success page after successful subscription
     */
    public function success(Request $request): View
    {
        return view('billing.success');
    }

    /**
     * Cancel page if user cancelled the checkout
     */
    public function cancel(Request $request): View
    {
        return view('billing.cancel');
    }
}
