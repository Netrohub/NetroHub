<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Setting;
use App\Models\WalletTransaction;
use App\Services\EntitlementsService;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

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
        $commissionRate = Setting::get('platform_commission_percent', 10);
        $platformFee = $subtotal * ($commissionRate / 100);
        $total = $subtotal;

        return view('checkout.index', compact('cartItems', 'subtotal', 'platformFee', 'total'));
    }

    public function process(Request $request, PaymentService $paymentService, EntitlementsService $entitlementsService)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Your cart is empty.');
        }

        $products = Product::with('seller.user')->whereIn('id', array_keys($cart))->get();

        $subtotal = $products->sum(fn ($p) => $p->price * ($cart[$p->id] ?? 1));

        // Calculate total platform fee across all sellers
        $totalPlatformFee = 0;
        foreach ($products as $product) {
            $quantity = $cart[$product->id] ?? 1;
            $itemPrice = $product->price * $quantity;

            // Get seller's platform fee based on their subscription
            $sellerUser = $product->seller->user;
            $platformFeePercent = $entitlementsService->getPlatformFee($sellerUser);
            $itemCommission = $itemPrice * ($platformFeePercent / 100);

            $totalPlatformFee += $itemCommission;
        }

        $total = $subtotal;

        DB::beginTransaction();

        try {
            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'subtotal' => $subtotal,
                'platform_fee' => $totalPlatformFee,
                'total' => $total,
                'buyer_email' => auth()->user()->email,
                'buyer_name' => auth()->user()->name,
                'payment_method' => 'paddle',
                'payment_status' => 'pending',
                'status' => 'pending',
            ]);

            // Create order items with per-seller commission rates
            foreach ($products as $product) {
                $quantity = $cart[$product->id] ?? 1;
                $itemPrice = $product->price * $quantity;

                // Get seller's platform fee based on their subscription
                $sellerUser = $product->seller->user;
                $platformFeePercent = $entitlementsService->getPlatformFee($sellerUser);
                $itemCommission = $itemPrice * ($platformFeePercent / 100);
                $sellerAmount = $itemPrice - $itemCommission;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'seller_id' => $product->seller_id,
                    'product_title' => $product->title,
                    'price' => $product->price,
                    'seller_amount' => $sellerAmount,
                    'platform_commission' => $itemCommission,
                    'quantity' => $quantity,
                    'delivery_type' => $product->delivery_type,
                ]);
            }

            // Create Paddle checkout session
            $transaction = $paymentService->createCheckoutSession($order);

            DB::commit();

            // Redirect to Paddle Checkout
            return view('checkout.payment', [
                'order' => $order,
                'paddleTransactionId' => $transaction->id,
                'paddleVendorId' => config('services.paddle.vendor_id'),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Payment processing failed: '.$e->getMessage());
        }
    }

    public function success(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->payment_status !== 'completed') {
            return redirect()->route('checkout.index')
                ->with('error', 'Payment not completed yet.');
        }

        // Clear cart
        session()->forget('cart');

        return view('checkout.success', compact('order'));
    }

    public function webhook(Request $request)
    {
        // Handle Paddle webhook with idempotency
        $payload = $request->getContent();
        $signature = $request->header('Paddle-Signature');
        $eventId = $request->header('Paddle-Event-Id');

        try {
            // Log webhook for debugging
            \Log::info('Paddle webhook received', [
                'event_id' => $eventId,
                'signature_present' => ! empty($signature),
                'payload_length' => strlen($payload),
            ]);

            // Check for idempotency - prevent duplicate processing
            if ($eventId) {
                $existingWebhook = \App\Models\WebhookLog::where('event_id', $eventId)->first();
                if ($existingWebhook && $existingWebhook->status === 'processed') {
                    return response()->json(['status' => 'already_processed'], 200);
                }
            }

            // Verify webhook signature
            $paymentService = app(PaymentService::class);

            if (! $paymentService->verifyWebhook($signature, $payload)) {
                \Log::warning('Invalid webhook signature', ['event_id' => $eventId]);

                return response()->json(['error' => 'Invalid signature'], 401);
            }

            $event = json_decode($payload, true);

            // Log webhook event
            $webhookLog = \App\Models\WebhookLog::create([
                'event_id' => $eventId,
                'event_type' => $event['event_type'] ?? 'unknown',
                'payload' => $payload,
                'status' => 'received',
            ]);

            // Handle different webhook events
            switch ($event['event_type']) {
                case 'transaction.completed':
                    $this->handleSuccessfulPayment($event['data'], $webhookLog);
                    break;
                case 'transaction.payment_failed':
                    $this->handleFailedPayment($event['data'], $webhookLog);
                    break;
                case 'transaction.refunded':
                    $this->handleRefund($event['data'], $webhookLog);
                    break;
                default:
                    \Log::info('Unhandled webhook event', ['event_type' => $event['event_type']]);
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            \Log::error('Webhook processing failed', [
                'error' => $e->getMessage(),
                'event_id' => $eventId,
            ]);

            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    private function handleSuccessfulPayment($transactionData, $webhookLog = null)
    {
        // Extract order ID from custom data
        $orderId = $transactionData['custom_data']['order_id'] ?? null;

        if (! $orderId) {
            \Log::warning('No order ID in transaction data', ['transaction' => $transactionData]);

            return;
        }

        $order = Order::find($orderId);

        if (! $order) {
            \Log::warning('Order not found for webhook', ['order_id' => $orderId]);

            return;
        }

        if ($order->payment_status === 'completed') {
            \Log::info('Order already completed, skipping', ['order_id' => $orderId]);

            return;
        }

        DB::transaction(function () use ($order, $transactionData, $webhookLog) {
            $order->markAsPaid($transactionData['id']);

            // Deliver digital goods and credit sellers
            foreach ($order->items as $item) {
                $this->deliverItem($item);
                $this->creditSeller($item);
            }

            $order->markAsCompleted();

            // Track analytics
            app(\App\Services\AnalyticsService::class)->trackPurchase($order);

            // Send email notifications
            $this->sendPaymentNotifications($order);

            // Update webhook log
            if ($webhookLog) {
                $webhookLog->update(['status' => 'processed']);
            }
        });
    }

    private function handleFailedPayment($transactionData, $webhookLog = null)
    {
        $orderId = $transactionData['custom_data']['order_id'] ?? null;

        if ($orderId) {
            $order = Order::find($orderId);
            if ($order) {
                $order->update(['payment_status' => 'failed']);
                \Log::info('Order payment failed', ['order_id' => $orderId]);
            }
        }

        if ($webhookLog) {
            $webhookLog->update(['status' => 'processed']);
        }
    }

    private function handleRefund($transactionData, $webhookLog = null)
    {
        $orderId = $transactionData['custom_data']['order_id'] ?? null;

        if ($orderId) {
            $order = Order::find($orderId);
            if ($order) {
                // Handle refund logic
                $this->processRefund($order, $transactionData);
                \Log::info('Order refunded', ['order_id' => $orderId]);
            }
        }

        if ($webhookLog) {
            $webhookLog->update(['status' => 'processed']);
        }
    }

    private function sendPaymentNotifications(Order $order)
    {
        // Send order confirmation to buyer
        try {
            $order->user->notify(new \App\Notifications\OrderCompletedNotification($order));
        } catch (\Exception $e) {
            \Log::error('Failed to send order notification', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);
        }

        // Send sale notification to sellers
        foreach ($order->items as $item) {
            try {
                $seller = $item->product->seller;
                if ($seller && $seller->user) {
                    $seller->user->notify(new \App\Notifications\NewSaleNotification($item));
                }
            } catch (\Exception $e) {
                \Log::error('Failed to send sale notification', [
                    'item_id' => $item->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    private function processRefund(Order $order, $transactionData)
    {
        // Implement refund processing logic
        // This would typically involve:
        // 1. Creating a refund record
        // 2. Reversing wallet transactions
        // 3. Sending refund notifications
        // 4. Updating order status
    }

    private function deliverItem(OrderItem $item)
    {
        $payload = [];
        $product = $item->product;

        // Handle credential-based delivery
        if ($product->hasCredentials()) {
            // Atomically claim credentials for unique products
            if ($product->is_unique_credential) {
                $claimed = $item->claimCredentials();

                if (! $claimed) {
                    \Log::error('Failed to claim unique credentials', [
                        'order_item_id' => $item->id,
                        'product_id' => $product->id,
                    ]);
                    throw new \Exception('This product has already been sold to another buyer.');
                }
            }

            // Don't include credentials in delivery_payload - they're accessed via secure page
            $payload['credential_delivery'] = true;
            $payload['view_url'] = route('orders.delivery', $item->order);
        }

        // Handle file-based delivery
        if (in_array($item->delivery_type, ['file', 'hybrid'])) {
            $files = $product->files;
            $payload['files'] = $files->map(fn ($file) => $file->getTemporaryUrl())->toArray();
        }

        // Handle code-based delivery
        if (in_array($item->delivery_type, ['code', 'hybrid'])) {
            $code = $product->codes()->available()->first();
            if ($code) {
                $code->claim($item->order->user, $item);
                $payload['codes'] = [$code->code];
            }
        }

        $item->markAsDelivered($payload);
        $product->incrementSales();
    }

    private function creditSeller(OrderItem $item)
    {
        $seller = $item->seller;
        $currentBalance = $seller->getWalletBalance();

        WalletTransaction::create([
            'seller_id' => $seller->id,
            'type' => 'sale',
            'amount' => $item->seller_amount,
            'balance_after' => $currentBalance + $item->seller_amount,
            'reference_type' => OrderItem::class,
            'reference_id' => $item->id,
            'description' => "Sale: {$item->product_title}",
        ]);
    }
}
