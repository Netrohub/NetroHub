<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['seller', 'category']);
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        
        $products = $query->latest()->paginate(20);
        
        return view('admin.products.index', compact('products'));
    }
    
    public function show(Product $product)
    {
        $product->load(['seller', 'category', 'reviews', 'orderItems']);
        return view('admin.products.show', compact('product'));
    }
    
    public function updateStatus(Request $request, Product $product)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);
        
        $product->update(['status' => $request->status]);
        
        return redirect()->back()
            ->with('success', 'Product status updated successfully');
    }
    
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully');
    }
}

