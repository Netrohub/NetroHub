<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $products = Product::with('seller.user')
            ->whereIn('id', array_keys($cart))
            ->get();

        $cartItems = $products->map(function ($product) use ($cart) {
            return [
                'product' => $product,
                'quantity' => $cart[$product->id] ?? 1,
            ];
        });

        $subtotal = $cartItems->sum(fn ($item) => $item['product']->price * $item['quantity']);
        $commission = $subtotal * (config('app.commission_rate', 10) / 100);
        $total = $subtotal;

        return view('cart.index', compact('cartItems', 'subtotal', 'commission', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        if ($product->status !== 'active' || ! $product->isInStock()) {
            return back()->with('error', 'Product is not available.');
        }

        $cart = session()->get('cart', []);
        $quantity = ($cart[$product->id] ?? 0) + 1;
        $cart[$product->id] = $quantity;
        session()->put('cart', $cart);

        // Track analytics
        app(\App\Services\AnalyticsService::class)->trackAddToCart($product, $quantity);

        return back()->with('success', 'Product added to cart!');
    }

    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);
        unset($cart[$product->id]);
        session()->put('cart', $cart);

        return back()->with('success', 'Product removed from cart!');
    }

    public function clear()
    {
        session()->forget('cart');

        return back()->with('success', 'Cart cleared!');
    }
}
