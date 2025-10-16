<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SearchController extends Controller
{
    /**
     * Handle admin search requests
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([
                'results' => [],
                'recent_searches' => $this->getRecentSearches($request)
            ]);
        }

        $results = $this->performSearch($query);
        
        // Save search to recent searches
        $this->saveRecentSearch($request, $query);
        
        return response()->json([
            'results' => $results,
            'recent_searches' => $this->getRecentSearches($request)
        ]);
    }

    /**
     * Perform the actual search across different resources
     */
    private function performSearch(string $query): array
    {
        $results = [];

        // Search Users
        $users = \App\Models\User::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->limit(3)
            ->get();

        foreach ($users as $user) {
            $results[] = [
                'title' => $user->name,
                'description' => "User: {$user->email}",
                'url' => route('filament.admin.resources.users.view', $user),
                'icon' => 'M12 6v6m0 0v6m0-6h6m-6 0H6',
                'type' => 'user'
            ];
        }

        // Search Products
        $products = \App\Models\Product::where('title', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->limit(3)
            ->get();

        foreach ($products as $product) {
            $results[] = [
                'title' => $product->title,
                'description' => "Product: " . substr($product->description, 0, 50) . '...',
                'url' => route('filament.admin.resources.products.view', $product),
                'icon' => 'M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
                'type' => 'product'
            ];
        }

        // Search Orders
        $orders = \App\Models\Order::where('id', 'like', "%{$query}%")
            ->orWhereHas('user', function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->limit(3)
            ->get();

        foreach ($orders as $order) {
            $results[] = [
                'title' => "Order #{$order->id}",
                'description' => "Order by {$order->user->name} - $" . number_format($order->total, 2),
                'url' => route('filament.admin.resources.orders.view', $order),
                'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                'type' => 'order'
            ];
        }

        // Add navigation items
        $navigationItems = [
            [
                'title' => 'Dashboard',
                'description' => 'View dashboard and analytics',
                'url' => route('filament.admin.pages.dashboard'),
                'icon' => 'M5.936.278A7.983 7.983 0 0 1 8 0a8 8 0 1 1-8 8c0-.722.104-1.413.278-2.064a1 1 0 1 1 1.932.516A5.99 5.99 0 0 0 2 8a6 6 0 1 0 6-6c-.53 0-1.045.076-1.548.21A1 1 0 1 1 5.936.278Z',
                'type' => 'navigation'
            ],
            [
                'title' => 'Settings',
                'description' => 'Manage application settings',
                'url' => route('filament.admin.pages.general-settings'),
                'icon' => 'M10.5 1a3.502 3.502 0 0 1 3.355 2.5H15a1 1 0 1 1 0 2h-1.145a3.502 3.502 0 0 1-6.71 0H1a1 1 0 0 1 0-2h6.145A3.502 3.502 0 0 1 10.5 1Z',
                'type' => 'navigation'
            ]
        ];

        foreach ($navigationItems as $item) {
            if (stripos($item['title'], $query) !== false || stripos($item['description'], $query) !== false) {
                $results[] = $item;
            }
        }

        return array_slice($results, 0, 8); // Limit to 8 results
    }

    /**
     * Get recent searches from session
     */
    private function getRecentSearches(Request $request): array
    {
        return $request->session()->get('recent_searches', []);
    }

    /**
     * Save search to recent searches
     */
    private function saveRecentSearch(Request $request, string $query): void
    {
        $recentSearches = $request->session()->get('recent_searches', []);
        
        // Remove if already exists
        $recentSearches = array_filter($recentSearches, fn($search) => $search !== $query);
        
        // Add to beginning
        array_unshift($recentSearches, $query);
        
        // Keep only last 5
        $recentSearches = array_slice($recentSearches, 0, 5);
        
        $request->session()->put('recent_searches', $recentSearches);
    }
}
