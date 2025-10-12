<?php

namespace App\Services;

use App\Models\Order;
use Paddle\SDK\Client;
use Paddle\SDK\Resources\Prices\Operations\CreatePrice;
use Paddle\SDK\Resources\Transactions\Operations\CreateTransaction;

class PaymentService
{
    private Client $paddle;

    public function __construct()
    {
        $this->paddle = new Client(
            apiKey: config('services.paddle.api_key'),
            options: [
                'environment' => config('services.paddle.environment', 'sandbox'),
            ]
        );
    }

    public function createCheckoutSession(Order $order)
    {
        // Create transaction for Paddle Checkout
        $transaction = $this->paddle->transactions->create(
            new CreateTransaction(
                items: $this->prepareOrderItems($order),
                customData: [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                ],
                customerId: $order->user->paddle_customer_id ?? null,
                currencyCode: 'USD',
            )
        );

        $order->update([
            'payment_intent_id' => $transaction->id,
        ]);

        return $transaction;
    }

    private function prepareOrderItems(Order $order): array
    {
        $items = [];

        foreach ($order->items as $item) {
            $items[] = [
                'priceId' => $this->getOrCreatePriceId($item->product_id, $item->price),
                'quantity' => $item->quantity,
            ];
        }

        return $items;
    }

    private function getOrCreatePriceId(int $productId, float $price): string
    {
        // For simplicity, create a price on-the-fly
        // In production, you might want to cache these or pre-create them
        $priceResponse = $this->paddle->prices->create(
            new CreatePrice(
                description: "Product #{$productId}",
                productId: config('services.paddle.product_id'), // Your Paddle product ID
                unitPrice: [
                    'amount' => (string) ($price * 100), // Convert to cents
                    'currencyCode' => 'USD',
                ],
                billingCycle: null, // One-time payment
            )
        );

        return $priceResponse->id;
    }

    public function refundTransaction(Order $order, ?float $amount = null)
    {
        if (! $order->payment_intent_id) {
            throw new \Exception('No transaction found for this order.');
        }

        // Paddle handles refunds differently - you'd typically do this via API
        // or through the Paddle dashboard
        throw new \Exception('Refunds should be processed through Paddle dashboard or API');
    }

    public function verifyWebhook(string $signature, string $payload): bool
    {
        $webhookSecret = config('services.paddle.webhook_secret');

        // Paddle uses p_signature in the header, not HMAC
        // The signature is a base64 encoded string containing the webhook data
        if (empty($webhookSecret) || empty($signature)) {
            return false;
        }

        // For Paddle, we need to verify the signature differently
        // This is a simplified version - in production, you'd use Paddle's SDK verification
        $expectedSignature = base64_encode(hash_hmac('sha256', $payload, $webhookSecret, true));

        return hash_equals($expectedSignature, $signature);
    }

    public function isProductionMode(): bool
    {
        return config('services.paddle.environment') === 'production';
    }

    public function getWebhookEndpoint(): string
    {
        return config('app.url').'/webhook/paddle';
    }

    /**
     * Create subscription checkout session
     */
    public function createSubscriptionCheckout(array $data): string
    {
        // Create subscription transaction
        $transaction = $this->paddle->transactions->create(
            new CreateTransaction(
                items: $data['items'],
                customData: $data['custom_data'] ?? [],
                customerId: $data['customer_id'] ?? null,
                currencyCode: 'USD',
            )
        );

        // Return checkout URL (Paddle provides this in the transaction response)
        return $transaction->checkoutUrl ?? route('pricing');
    }

    /**
     * Cancel a subscription
     */
    public function cancelSubscription(string $subscriptionId): void
    {
        $this->paddle->subscriptions->cancel($subscriptionId, [
            'effectiveFrom' => 'next_billing_period',
        ]);
    }

    /**
     * Resume a cancelled subscription
     */
    public function resumeSubscription(string $subscriptionId): void
    {
        $this->paddle->subscriptions->resume($subscriptionId, [
            'effectiveFrom' => 'immediately',
        ]);
    }

    /**
     * Update subscription
     */
    public function updateSubscription(string $subscriptionId, array $data): void
    {
        $this->paddle->subscriptions->update($subscriptionId, $data);
    }

    /**
     * Get subscription details
     */
    public function getSubscription(string $subscriptionId)
    {
        return $this->paddle->subscriptions->get($subscriptionId);
    }
}
