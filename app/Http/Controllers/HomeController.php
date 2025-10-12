<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with(['seller.user', 'category'])
            ->active()
            ->featured()
            ->latest()
            ->take(8)
            ->get();

        $categories = Category::active()
            ->ordered()
            ->withCount(['products' => function ($query) {
                $query->active();
            }])
            ->take(8)
            ->get();

        $recentProducts = Product::with(['seller.user', 'category'])
            ->active()
            ->latest()
            ->take(12)
            ->get();

        return view('welcome', compact('featuredProducts', 'categories', 'recentProducts'));
    }
}
