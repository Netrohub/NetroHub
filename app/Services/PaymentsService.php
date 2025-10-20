<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\WalletTransaction;
use App\Models\IdempotencyKey;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentsService
{
    /**
     * Process payment for an order
     */
    public function processPayment(Order $order, array $paymentData): array
    {
        return DB::transaction(function () use ($order, $paymentData) {
            try {
                // Check idempotency
                $idempotencyKey = $this->generateIdempotencyKey($order, $paymentData);
                if ($this->isDuplicatePayment($idempotencyKey)) {
                    return [
                        'success' => false,
                        'message' => 'Duplicate payment detected',
                        'idempotency_key' => $idempotencyKey
                    ];
                }

                // Validate payment data
                $this->validatePaymentData($paymentData);

                // Process payment based on provider
                $result = $this->processPaymentByProvider($order, $paymentData);

                if ($result['success']) {
                    // Update order status
                    $order->update([
                        'status' => 'paid',
                        'payment_method' => $paymentData['provider'],
                        'payment_id' => $result['payment_id'],
                        'paid_at' => now()
                    ]);

                    // Create wallet transactions for sellers
                    $this->createSellerTransactions($order);

                    // Mark idempotency key as processed
                    $this->markIdempotencyProcessed($idempotencyKey, $result);

                    Log::info('Payment processed successfully', [
                        'order_id' => $order->id,
                        'payment_id' => $result['payment_id'],
                        'amount' => $order->total_amount
                    ]);
                }

                return $result;

            } catch (\Exception $e) {
                Log::error('Payment processing failed', [
                    'order_id' => $order->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);

                return [
                    'success' => false,
                    'message' => 'Payment processing failed: ' . $e->getMessage()
                ];
            }
        });
    }

    /**
     * Process refund for an order item
     */
    public function processRefund(OrderItem $orderItem, float $amount, string $reason): array
    {
        return DB::transaction(function () use ($orderItem, $amount, $reason) {
            try {
                // Validate refund amount
                if ($amount > $orderItem->total_amount) {
                    throw new \InvalidArgumentException('Refund amount cannot exceed order item total');
                }

                // Create refund record
                $refund = $orderItem->refunds()->create([
                    'amount' => $amount,
                    'reason' => $reason,
                    'status' => 'pending',
                    'processed_by' => auth()->id()
                ]);

                // Process refund with payment provider
                $result = $this->processRefundByProvider($orderItem, $amount, $refund);

                if ($result['success']) {
                    $refund->update([
                        'status' => 'completed',
                        'provider_refund_id' => $result['refund_id'],
                        'processed_at' => now()
                    ]);

                    // Update seller wallet (deduct amount)
                    $this->deductFromSellerWallet($orderItem, $amount);

                    Log::info('Refund processed successfully', [
                        'order_item_id' => $orderItem->id,
                        'refund_id' => $result['refund_id'],
                        'amount' => $amount
                    ]);
                }

                return $result;

            } catch (\Exception $e) {
                Log::error('Refund processing failed', [
                    'order_item_id' => $orderItem->id,
                    'error' => $e->getMessage()
                ]);

                return [
                    'success' => false,
                    'message' => 'Refund processing failed: ' . $e->getMessage()
                ];
            }
        });
    }

    /**
     * Generate idempotency key for payment
     */
    private function generateIdempotencyKey(Order $order, array $paymentData): string
    {
        $data = [
            'order_id' => $order->id,
            'amount' => $order->total_amount,
            'provider' => $paymentData['provider'],
            'payment_method' => $paymentData['payment_method'] ?? null
        ];

        return hash('sha256', json_encode($data));
    }

    /**
     * Check if payment is duplicate
     */
    private function isDuplicatePayment(string $idempotencyKey): bool
    {
        return IdempotencyKey::where('key', $idempotencyKey)
            ->where('status', 'processed')
            ->exists();
    }

    /**
     * Mark idempotency key as processed
     */
    private function markIdempotencyProcessed(string $idempotencyKey, array $result): void
    {
        IdempotencyKey::create([
            'key' => $idempotencyKey,
            'provider' => 'payment',
            'type' => 'payment',
            'payload' => $result,
            'status' => 'processed',
            'processed_at' => now()
        ]);
    }

    /**
     * Validate payment data
     */
    private function validatePaymentData(array $paymentData): void
    {
        $required = ['provider', 'amount'];
        foreach ($required as $field) {
            if (!isset($paymentData[$field])) {
                throw new \InvalidArgumentException("Missing required field: {$field}");
            }
        }

        if (!in_array($paymentData['provider'], ['stripe', 'tap', 'mada', 'stc_pay'])) {
            throw new \InvalidArgumentException('Invalid payment provider');
        }
    }

    /**
     * Process payment by provider
     */
    private function processPaymentByProvider(Order $order, array $paymentData): array
    {
        switch ($paymentData['provider']) {
            case 'stripe':
                return $this->processStripePayment($order, $paymentData);
            case 'tap':
                return $this->processTapPayment($order, $paymentData);
            case 'mada':
                return $this->processMadaPayment($order, $paymentData);
            case 'stc_pay':
                return $this->processStcPayPayment($order, $paymentData);
            default:
                throw new \InvalidArgumentException('Unsupported payment provider');
        }
    }

    /**
     * Process Stripe payment
     */
    private function processStripePayment(Order $order, array $paymentData): array
    {
        // Implement Stripe payment logic
        // This would integrate with Stripe SDK
        return [
            'success' => true,
            'payment_id' => 'stripe_' . Str::random(20),
            'transaction_id' => Str::random(30)
        ];
    }

    /**
     * Process Tap payment
     */
    private function processTapPayment(Order $order, array $paymentData): array
    {
        // Implement Tap payment logic
        return [
            'success' => true,
            'payment_id' => 'tap_' . Str::random(20),
            'transaction_id' => Str::random(30)
        ];
    }

    /**
     * Process Mada payment
     */
    private function processMadaPayment(Order $order, array $paymentData): array
    {
        // Implement Mada payment logic
        return [
            'success' => true,
            'payment_id' => 'mada_' . Str::random(20),
            'transaction_id' => Str::random(30)
        ];
    }

    /**
     * Process STC Pay payment
     */
    private function processStcPayPayment(Order $order, array $paymentData): array
    {
        // Implement STC Pay payment logic
        return [
            'success' => true,
            'payment_id' => 'stc_' . Str::random(20),
            'transaction_id' => Str::random(30)
        ];
    }

    /**
     * Create wallet transactions for sellers
     */
    private function createSellerTransactions(Order $order): void
    {
        foreach ($order->items as $item) {
            $seller = $item->product->seller;
            
            WalletTransaction::create([
                'seller_id' => $seller->id,
                'type' => 'credit',
                'amount' => $item->seller_amount,
                'description' => "Payment for order #{$order->id}",
                'reference_type' => OrderItem::class,
                'reference_id' => $item->id,
                'status' => 'pending' // Will be released after delivery
            ]);
        }
    }

    /**
     * Process refund by provider
     */
    private function processRefundByProvider(OrderItem $orderItem, float $amount, $refund): array
    {
        // Implement refund logic based on original payment provider
        return [
            'success' => true,
            'refund_id' => 'refund_' . Str::random(20)
        ];
    }

    /**
     * Deduct amount from seller wallet
     */
    private function deductFromSellerWallet(OrderItem $orderItem, float $amount): void
    {
        $seller = $orderItem->product->seller;
        
        WalletTransaction::create([
            'seller_id' => $seller->id,
            'type' => 'debit',
            'amount' => $amount,
            'description' => "Refund for order item #{$orderItem->id}",
            'reference_type' => 'refund',
            'reference_id' => $orderItem->id,
            'status' => 'completed'
        ]);
    }
}
