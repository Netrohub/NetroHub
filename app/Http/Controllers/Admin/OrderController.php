<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items']);
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('order_number', 'like', "%{$search}%");
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }
        
        $orders = $query->latest()->paginate(20);
        
        return view('admin.orders.index', compact('orders'));
    }
    
    public function show(Order $order)
    {
        $order->load(['user', 'items.product', 'refunds']);
        return view('admin.orders.show', compact('order'));
    }
}

