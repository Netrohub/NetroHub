<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Gate;

class OrderDeliveryController extends Controller
{
    /**
     * Show the secure delivery page for an order
     */
    public function show(Order $order)
    {
        // Authorize access
        Gate::authorize('viewDelivery', $order);

        // Load order items with products
        $order->load(['items.product', 'items.credentialViews' => function ($query) {
            $query->orderBy('viewed_at', 'desc')->limit(10);
        }]);

        // Calculate dispute deadline (12 hours from order completion)
        $disputeDeadline = $order->paid_at?->addHours(12);
        $canDispute = $disputeDeadline && now()->lt($disputeDeadline);

        return view('orders.delivery', compact('order', 'disputeDeadline', 'canDispute'));
    }

    /**
     * Reveal credentials for a specific order item (AJAX endpoint)
     */
    public function reveal(Order $order, OrderItem $orderItem)
    {
        try {
            // Authorize access
            Gate::authorize('viewDelivery', $order);

            // Verify order item belongs to this order
            if ($orderItem->order_id !== $order->id) {
                return response()->json([
                    'error' => 'Order item does not belong to this order.',
                ], 403);
            }

            // Eager load product to avoid N+1
            $orderItem->load('product');

            // Check if credentials can be viewed
            if (! $orderItem->canViewCredentials()) {
                return response()->json([
                    'error' => 'Credentials cannot be viewed. You may have reached your view limit or the order is not paid.',
                ], 403);
            }

            // Get the product and credentials
            $product = $orderItem->product;

            if (! $product || ! $product->hasCredentials()) {
                return response()->json([
                    'error' => 'No credentials available for this product.',
                ], 404);
            }

            // Record the view
            $orderItem->recordCredentialView(
                auth()->user(),
                request()->ip(),
                request()->userAgent()
            );

            // Return the credentials (decrypted automatically by cast)
            $credentials = $product->delivery_credentials;

            return response()->json([
                'success' => true,
                'credentials' => [
                    'username' => $credentials['username'] ?? '',
                    'password' => $credentials['password'] ?? '',
                    'extras' => $credentials['extras'] ?? [],
                    'instructions' => $credentials['instructions'] ?? '',
                ],
                'remaining_views' => $orderItem->fresh()->getRemainingViews(),
            ]);

        } catch (\Exception $e) {
            \Log::error('Credential reveal failed', [
                'order_id' => $order->id,
                'order_item_id' => $orderItem->id,
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'error' => 'Failed to retrieve credentials. Please try again or contact support.',
            ], 500);
        }
    }
}
