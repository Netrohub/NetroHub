<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GamesController extends Controller
{
    /**
     * Display game account products
     */
    public function index(Request $request): View
    {
        // Get game account products (products with 'game' in title or tags)
        $products = Product::with(['seller.user', 'category', 'reviews'])
            ->where(function ($query) {
                $query->where('title', 'like', '%game%')
                      ->orWhere('title', 'like', '%account%')
                      ->orWhere('description', 'like', '%game%')
                      ->orWhereJsonContains('tags', 'game');
            })
            ->where('status', 'active')
            ->orderBy('sales_count', 'desc')
            ->orderBy('rating', 'desc')
            ->paginate(12);

        return view('pages.games', compact('products'));
    }
}