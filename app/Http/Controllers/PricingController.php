<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PricingController extends Controller
{
    /**
     * Display the pricing page
     */
    public function index(Request $request): View
    {
        $plans = Plan::active()->with('features')->get();
        
        $user = auth()->user();
        $currentPlan = null;
        $currentSubscription = null;

        if ($user) {
            $currentSubscription = $user->activeSubscription;
            if ($currentSubscription) {
                $currentPlan = $currentSubscription->plan;
            }
        }

        return view('pricing.index', compact('plans', 'currentPlan', 'currentSubscription'));
    }
}
