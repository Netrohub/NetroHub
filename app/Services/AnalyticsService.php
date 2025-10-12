<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AnalyticsService
{
    private ?string $measurementId;

    private ?string $apiSecret;

    private ?string $posthogKey;

    private ?string $posthogHost;

    public function __construct()
    {
        $this->measurementId = config('services.google_analytics.measurement_id');
        $this->apiSecret = config('services.google_analytics.api_secret');
        $this->posthogKey = config('services.posthog.api_key');
        $this->posthogHost = config('services.posthog.host', 'https://app.posthog.com');
    }

    /**
     * Track a custom event
     */
    public function track(string $eventName, array $parameters = [], ?string $userId = null): void
    {
        $userId = $userId ?? auth()->id();

        // Send to Google Analytics 4
        $this->sendToGoogleAnalytics($eventName, $parameters, $userId);

        // Send to PostHog
        $this->sendToPostHog($eventName, $parameters, $userId);

        // Log locally for debugging
        Log::info('Analytics event tracked', [
            'event' => $eventName,
            'parameters' => $parameters,
            'user_id' => $userId,
        ]);
    }

    /**
     * Track product view
     */
    public function trackProductView($product, ?string $userId = null): void
    {
        $this->track('product_view', [
            'product_id' => $product->id,
            'product_name' => $product->title,
            'product_category' => $product->category?->name,
            'product_price' => $product->price,
            'currency' => 'USD',
        ], $userId);
    }

    /**
     * Track add to cart
     */
    public function trackAddToCart($product, int $quantity = 1, ?string $userId = null): void
    {
        $this->track('add_to_cart', [
            'product_id' => $product->id,
            'product_name' => $product->title,
            'product_category' => $product->category?->name,
            'product_price' => $product->price,
            'quantity' => $quantity,
            'currency' => 'USD',
        ], $userId);
    }

    /**
     * Track purchase
     */
    public function trackPurchase($order, ?string $userId = null): void
    {
        $items = $order->items->map(function ($item) {
            return [
                'item_id' => $item->product_id,
                'item_name' => $item->product_title,
                'item_category' => $item->product?->category?->name,
                'price' => $item->price,
                'quantity' => $item->quantity,
            ];
        });

        $this->track('purchase', [
            'transaction_id' => $order->order_number,
            'value' => $order->total,
            'currency' => 'USD',
            'items' => $items,
        ], $userId);
    }

    /**
     * Track review creation
     */
    public function trackReviewCreated($review, ?string $userId = null): void
    {
        $this->track('review_created', [
            'product_id' => $review->reviewable_id,
            'product_name' => $review->reviewable->title ?? 'Unknown',
            'rating' => $review->rating,
            'review_length' => strlen($review->body ?? ''),
        ], $userId);
    }

    /**
     * Track user registration
     */
    public function trackUserRegistration($user): void
    {
        $this->track('sign_up', [
            'method' => 'email', // or 'google', 'discord', etc.
        ], $user->id);
    }

    /**
     * Track user login
     */
    public function trackUserLogin($user, string $method = 'email'): void
    {
        $this->track('login', [
            'method' => $method,
        ], $user->id);
    }

    /**
     * Send event to Google Analytics 4
     */
    private function sendToGoogleAnalytics(string $eventName, array $parameters, ?string $userId): void
    {
        if (! $this->measurementId || ! $this->apiSecret) {
            return;
        }

        try {
            $payload = [
                'client_id' => $userId ?: $this->generateClientId(),
                'events' => [
                    [
                        'name' => $eventName,
                        'params' => array_merge($parameters, [
                            'timestamp_micros' => now()->timestamp * 1000000,
                        ]),
                    ],
                ],
            ];

            Http::timeout(5)->post("https://www.google-analytics.com/mp/collect?measurement_id={$this->measurementId}&api_secret={$this->apiSecret}", $payload);
        } catch (\Exception $e) {
            Log::warning('Failed to send event to Google Analytics', [
                'event' => $eventName,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Send event to PostHog
     */
    private function sendToPostHog(string $eventName, array $parameters, ?string $userId): void
    {
        if (! $this->posthogKey) {
            return;
        }

        try {
            $payload = [
                'api_key' => $this->posthogKey,
                'event' => $eventName,
                'properties' => array_merge($parameters, [
                    'timestamp' => now()->toISOString(),
                    'distinct_id' => $userId ?: $this->generateClientId(),
                ]),
            ];

            Http::timeout(5)->post("{$this->posthogHost}/capture/", $payload);
        } catch (\Exception $e) {
            Log::warning('Failed to send event to PostHog', [
                'event' => $eventName,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Generate a unique client ID for anonymous users
     */
    private function generateClientId(): string
    {
        return 'anonymous_'.substr(md5(request()->ip().request()->userAgent()), 0, 16);
    }

    /**
     * Set user properties (for PostHog)
     */
    public function setUserProperties($user, array $properties): void
    {
        if (! $this->posthogKey) {
            return;
        }

        try {
            $payload = [
                'api_key' => $this->posthogKey,
                'event' => '$identify',
                'properties' => [
                    'distinct_id' => $user->id,
                    '$set' => $properties,
                    'timestamp' => now()->toISOString(),
                ],
            ];

            Http::timeout(5)->post("{$this->posthogHost}/capture/", $payload);
        } catch (\Exception $e) {
            Log::warning('Failed to set user properties in PostHog', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
