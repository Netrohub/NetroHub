<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SocialController extends Controller
{
    /**
     * Display social account products
     */
    public function index(Request $request): View
    {
        // Get social account products (products with 'social' in title or tags)
        $products = Product::with(['seller.user', 'category', 'reviews'])
            ->where(function ($query) {
                $query->where('title', 'like', '%social%')
                      ->orWhere('title', 'like', '%account%')
                      ->orWhere('description', 'like', '%social%')
                      ->orWhereJsonContains('tags', 'social');
            })
            ->where('status', 'active')
            ->orderBy('sales_count', 'desc')
            ->orderBy('rating', 'desc')
            ->paginate(12);

        return view('pages.social', compact('products'));
    }
}