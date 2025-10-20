<?php

namespace App\Services;

use App\Models\Dispute;
use App\Models\DisputeMessage;
use App\Models\OrderItem;
use App\Models\WalletTransaction;
use App\Notifications\DisputeCreatedNotification;
use App\Notifications\DisputeResolvedNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class DisputeService
{
    /**
     * Create a new dispute
     */
    public function createDispute(OrderItem $orderItem, array $data): Dispute
    {
        return DB::transaction(function () use ($orderItem, $data) {
            // Validate order item can be disputed
            $this->validateDisputeEligibility($orderItem);

            // Create dispute
            $dispute = Dispute::create([
                'order_id' => $orderItem->order_id,
                'order_item_id' => $orderItem->id,
                'buyer_id' => $orderItem->order->user_id,
                'seller_id' => $orderItem->product->seller_id,
                'reason' => $data['reason'],
                'description' => $data['description'],
                'status' => 'open',
                'evidence_deadline' => now()->addDays(7), // 7 days for evidence collection
                'resolution_deadline' => now()->addDays(14) // 14 days for resolution
            ]);

            // Create initial message
            DisputeMessage::create([
                'dispute_id' => $dispute->id,
                'user_id' => $orderItem->order->user_id,
                'message' => $data['description'],
                'type' => 'evidence'
            ]);

            // Hold funds in escrow
            $this->holdFundsInEscrow($orderItem);

            // Send notifications
            $this->sendDisputeNotifications($dispute);

            Log::info('Dispute created', [
                'dispute_id' => $dispute->id,
                'order_item_id' => $orderItem->id,
                'buyer_id' => $orderItem->order->user_id,
                'seller_id' => $orderItem->product->seller_id
            ]);

            return $dispute;
        });
    }

    /**
     * Add evidence to dispute
     */
    public function addEvidence(Dispute $dispute, array $data): DisputeMessage
    {
        // Validate evidence deadline
        if (now()->gt($dispute->evidence_deadline)) {
            throw new \InvalidArgumentException('Evidence deadline has passed');
        }

        $message = DisputeMessage::create([
            'dispute_id' => $dispute->id,
            'user_id' => auth()->id(),
            'message' => $data['message'],
            'type' => 'evidence',
            'attachments' => $data['attachments'] ?? []
        ]);

        // Update dispute status if needed
        if ($dispute->status === 'open') {
            $dispute->update(['status' => 'evidence']);
        }

        Log::info('Evidence added to dispute', [
            'dispute_id' => $dispute->id,
            'message_id' => $message->id,
            'user_id' => auth()->id()
        ]);

        return $message;
    }

    /**
     * Escalate dispute to admin
     */
    public function escalateDispute(Dispute $dispute, string $reason): void
    {
        $dispute->update([
            'status' => 'escalated',
            'escalation_reason' => $reason,
            'escalated_at' => now()
        ]);

        // Notify admins
        $this->notifyAdmins($dispute, 'escalated');

        Log::info('Dispute escalated', [
            'dispute_id' => $dispute->id,
            'reason' => $reason
        ]);
    }

    /**
     * Resolve dispute
     */
    public function resolveDispute(Dispute $dispute, string $resolution, string $decision, ?int $resolvedBy = null): void
    {
        DB::transaction(function () use ($dispute, $resolution, $decision, $resolvedBy) {
            $dispute->update([
                'status' => 'resolved',
                'resolution' => $resolution,
                'decision' => $decision,
                'resolved_by' => $resolvedBy ?? auth()->id(),
                'resolved_at' => now()
            ]);

            // Process resolution based on decision
            switch ($decision) {
                case 'refund_buyer':
                    $this->processRefundResolution($dispute);
                    break;
                case 'release_funds':
                    $this->processReleaseResolution($dispute);
                    break;
                case 'partial_refund':
                    $this->processPartialRefundResolution($dispute, $resolution);
                    break;
            }

            // Send resolution notifications
            $this->sendResolutionNotifications($dispute);

            Log::info('Dispute resolved', [
                'dispute_id' => $dispute->id,
                'decision' => $decision,
                'resolved_by' => $resolvedBy ?? auth()->id()
            ]);
        });
    }

    /**
     * Auto-resolve disputes that exceed deadline
     */
    public function autoResolveExpiredDisputes(): int
    {
        $expiredDisputes = Dispute::where('status', 'evidence')
            ->where('resolution_deadline', '<', now())
            ->get();

        $resolved = 0;
        foreach ($expiredDisputes as $dispute) {
            // Auto-resolve in favor of buyer if no seller response
            $this->resolveDispute(
                $dispute,
                'Auto-resolved due to deadline expiration',
                'refund_buyer',
                null // System resolution
            );
            $resolved++;
        }

        Log::info('Auto-resolved expired disputes', ['count' => $resolved]);
        return $resolved;
    }

    /**
     * Validate dispute eligibility
     */
    private function validateDisputeEligibility(OrderItem $orderItem): void
    {
        // Check if order item is delivered
        if ($orderItem->status !== 'delivered') {
            throw new \InvalidArgumentException('Order item must be delivered before disputing');
        }

        // Check if already disputed
        if ($orderItem->disputes()->exists()) {
            throw new \InvalidArgumentException('Order item is already under dispute');
        }

        // Check dispute time limit (30 days from delivery)
        if ($orderItem->delivered_at && $orderItem->delivered_at->lt(now()->subDays(30))) {
            throw new \InvalidArgumentException('Dispute time limit has expired');
        }
    }

    /**
     * Hold funds in escrow
     */
    private function holdFundsInEscrow(OrderItem $orderItem): void
    {
        $seller = $orderItem->product->seller;
        
        WalletTransaction::create([
            'seller_id' => $seller->id,
            'type' => 'hold',
            'amount' => $orderItem->seller_amount,
            'description' => "Funds held due to dispute for order item #{$orderItem->id}",
            'reference_type' => OrderItem::class,
            'reference_id' => $orderItem->id,
            'status' => 'pending'
        ]);
    }

    /**
     * Process refund resolution
     */
    private function processRefundResolution(Dispute $dispute): void
    {
        $orderItem = $dispute->orderItem;
        
        // Create refund transaction
        WalletTransaction::create([
            'seller_id' => $orderItem->product->seller_id,
            'type' => 'debit',
            'amount' => $orderItem->seller_amount,
            'description' => "Refund due to dispute resolution for order item #{$orderItem->id}",
            'reference_type' => Dispute::class,
            'reference_id' => $dispute->id,
            'status' => 'completed'
        ]);

        // Update order item status
        $orderItem->update(['status' => 'refunded']);
    }

    /**
     * Process release resolution
     */
    private function processReleaseResolution(Dispute $dispute): void
    {
        $orderItem = $dispute->orderItem;
        
        // Release held funds
        WalletTransaction::create([
            'seller_id' => $orderItem->product->seller_id,
            'type' => 'credit',
            'amount' => $orderItem->seller_amount,
            'description' => "Funds released after dispute resolution for order item #{$orderItem->id}",
            'reference_type' => Dispute::class,
            'reference_id' => $dispute->id,
            'status' => 'completed'
        ]);
    }

    /**
     * Process partial refund resolution
     */
    private function processPartialRefundResolution(Dispute $dispute, string $resolution): void
    {
        // Extract refund amount from resolution text
        preg_match('/refund.*?(\d+(?:\.\d{2})?)/i', $resolution, $matches);
        $refundAmount = $matches[1] ?? 0;
        
        if ($refundAmount > 0) {
            $orderItem = $dispute->orderItem;
            
            WalletTransaction::create([
                'seller_id' => $orderItem->product->seller_id,
                'type' => 'debit',
                'amount' => $refundAmount,
                'description' => "Partial refund due to dispute resolution for order item #{$orderItem->id}",
                'reference_type' => Dispute::class,
                'reference_id' => $dispute->id,
                'status' => 'completed'
            ]);
        }
    }

    /**
     * Send dispute notifications
     */
    private function sendDisputeNotifications(Dispute $dispute): void
    {
        // Notify seller
        $seller = $dispute->orderItem->product->seller->user;
        $seller->notify(new DisputeCreatedNotification($dispute));

        // Notify admins
        $this->notifyAdmins($dispute, 'created');
    }

    /**
     * Send resolution notifications
     */
    private function sendResolutionNotifications(Dispute $dispute): void
    {
        // Notify buyer and seller
        $buyer = $dispute->order->user;
        $seller = $dispute->orderItem->product->seller->user;
        
        $buyer->notify(new DisputeResolvedNotification($dispute));
        $seller->notify(new DisputeResolvedNotification($dispute));
    }

    /**
     * Notify admins about dispute
     */
    private function notifyAdmins(Dispute $dispute, string $action): void
    {
        // Get admin users
        $admins = \App\Models\User::role('admin')->get();
        
        // Send notification to admins
        Notification::send($admins, new \App\Notifications\DisputeAdminNotification($dispute, $action));
    }
}
