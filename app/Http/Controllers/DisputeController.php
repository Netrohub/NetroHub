<?php

namespace App\Http\Controllers;

use App\Models\Dispute;
use App\Models\DisputeMessage;
use App\Models\Order;
use App\Models\OrderItem;
use App\Notifications\DisputeCreatedNotification;
use App\Notifications\DisputeMessageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DisputeController extends Controller
{
    /**
     * Display a listing of disputes for the authenticated user
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get disputes where user is buyer or seller
        $disputes = Dispute::query()
            ->where(function($query) use ($user) {
                $query->where('buyer_id', $user->id);
                
                // If user is a seller, include their seller disputes
                if ($user->seller) {
                    $query->orWhere('seller_id', $user->seller->id);
                }
            })
            ->with(['order', 'orderItem', 'buyer', 'seller', 'messages'])
            ->latest()
            ->paginate(15);

        return view('disputes.index', compact('disputes'));
    }

    /**
     * Show the form for creating a new dispute
     */
    public function create(Request $request)
    {
        $orderId = $request->query('order_id');
        $orderItemId = $request->query('order_item_id');
        
        $order = null;
        $orderItem = null;
        
        if ($orderId) {
            $order = Order::where('user_id', Auth::id())->findOrFail($orderId);
            
            if ($orderItemId) {
                $orderItem = $order->items()->findOrFail($orderItemId);
            }
        }

        return view('disputes.create', compact('order', 'orderItem'));
    }

    /**
     * Store a newly created dispute
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'order_item_id' => 'nullable|exists:order_items,id',
            'reason' => 'required|string|max:255',
            'description' => 'required|string|min:20',
            'evidence.*' => 'nullable|file|max:5120|mimes:jpg,jpeg,png,pdf',
        ]);

        // Verify the order belongs to the user
        $order = Order::where('user_id', Auth::id())->findOrFail($validated['order_id']);
        
        // Check if dispute already exists for this order/item
        $existingDispute = Dispute::where('order_id', $order->id)
            ->when($request->order_item_id, function($query) use ($request) {
                $query->where('order_item_id', $request->order_item_id);
            })
            ->whereIn('status', ['open', 'in_review'])
            ->first();

        if ($existingDispute) {
            return redirect()->back()->with('error', 'A dispute already exists for this order/item.');
        }

        // Get seller from order item or first item in order
        $orderItem = $request->order_item_id 
            ? OrderItem::findOrFail($request->order_item_id)
            : $order->items()->first();
        
        if (!$orderItem) {
            return redirect()->back()->with('error', 'No items found in this order.');
        }

        // Upload evidence files
        $evidencePaths = [];
        if ($request->hasFile('evidence')) {
            foreach ($request->file('evidence') as $file) {
                $path = $file->store('disputes/evidence', 'public');
                $evidencePaths[] = [
                    'path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                    'type' => $file->getMimeType(),
                ];
            }
        }

        // Create the dispute
        $dispute = Dispute::create([
            'order_id' => $order->id,
            'order_item_id' => $request->order_item_id,
            'buyer_id' => Auth::id(),
            'seller_id' => $orderItem->seller_id,
            'reason' => $validated['reason'],
            'description' => $validated['description'],
            'status' => 'open',
            'evidence' => $evidencePaths,
        ]);

        // Create initial message
        $dispute->messages()->create([
            'user_id' => Auth::id(),
            'message' => $validated['description'],
            'attachments' => $evidencePaths,
        ]);

        // Notify seller
        $seller = $orderItem->seller;
        if ($seller->user) {
            $seller->user->notify(new DisputeCreatedNotification($dispute));
        }

        return redirect()->route('disputes.show', $dispute)
            ->with('success', 'Your dispute has been created successfully. Our team will review it shortly.');
    }

    /**
     * Display the specified dispute
     */
    public function show(Dispute $dispute)
    {
        // Authorize access
        $user = Auth::user();
        $canView = $dispute->buyer_id === $user->id 
            || ($user->seller && $dispute->seller_id === $user->seller->id)
            || $user->isAdmin();

        if (!$canView) {
            abort(403, 'Unauthorized access to this dispute.');
        }

        $dispute->load(['order', 'orderItem.product', 'buyer', 'seller', 'messages.user', 'resolvedBy']);

        return view('disputes.show', compact('dispute'));
    }

    /**
     * Escalate dispute to moderators
     */
    public function escalate(Dispute $dispute)
    {
        // Authorize access - only buyer or seller can escalate
        $user = Auth::user();
        $canEscalate = $dispute->buyer_id === $user->id 
            || ($user->seller && $dispute->seller_id === $user->seller->id);

        if (!$canEscalate) {
            abort(403, 'Unauthorized access to this dispute.');
        }

        if (!$dispute->canEscalate()) {
            return redirect()->back()->with('error', 'This dispute cannot be escalated.');
        }

        $dispute->escalate();

        // Add system message
        $dispute->messages()->create([
            'user_id' => $user->id,
            'message' => 'Dispute has been escalated to moderators for review.',
            'is_internal' => false,
        ]);

        // Notify moderators (you can create a notification for this)
        // Moderators with appropriate roles will see this in admin panel

        return redirect()->back()->with('success', 'Dispute has been escalated to moderators for review.');
    }

    /**
     * Mark dispute as resolved by buyer
     */
    public function markResolved(Dispute $dispute)
    {
        // Only buyer can mark as resolved
        $user = Auth::user();
        if ($dispute->buyer_id !== $user->id) {
            abort(403, 'Only the buyer can mark this dispute as resolved.');
        }

        if (!in_array($dispute->status, ['open'])) {
            return redirect()->back()->with('error', 'This dispute cannot be marked as resolved.');
        }

        $dispute->markResolvedByBuyer();

        // Add system message
        $dispute->messages()->create([
            'user_id' => $user->id,
            'message' => 'Buyer has marked this dispute as resolved.',
            'is_internal' => false,
        ]);

        // Notify seller
        if ($dispute->seller->user) {
            $dispute->seller->user->notify(new DisputeMessageNotification($dispute, $dispute->messages()->latest()->first()));
        }

        return redirect()->back()->with('success', 'Dispute marked as resolved. Thank you!');
    }

    /**
     * Add a message to the dispute
     */
    public function addMessage(Request $request, Dispute $dispute)
    {
        // Authorize access
        $user = Auth::user();
        $canMessage = $dispute->buyer_id === $user->id 
            || ($user->seller && $dispute->seller_id === $user->seller->id);

        if (!$canMessage) {
            abort(403, 'Unauthorized access to this dispute.');
        }

        // Cannot add messages to fully resolved disputes
        if (in_array($dispute->status, ['resolved_refund', 'resolved_upheld'])) {
            return redirect()->back()->with('error', 'Cannot add messages to a resolved dispute.');
        }

        $validated = $request->validate([
            'message' => 'required|string|min:3',
            'attachments.*' => 'nullable|file|max:5120|mimes:jpg,jpeg,png,pdf',
        ]);

        // Upload attachments
        $attachmentPaths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('disputes/attachments', 'public');
                $attachmentPaths[] = [
                    'path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                    'type' => $file->getMimeType(),
                ];
            }
        }

        // Create message
        $message = $dispute->messages()->create([
            'user_id' => $user->id,
            'message' => $validated['message'],
            'attachments' => $attachmentPaths,
        ]);

        // Notify the other party
        if ($dispute->buyer_id === $user->id && $dispute->seller->user) {
            // Buyer sent message, notify seller
            $dispute->seller->user->notify(new DisputeMessageNotification($dispute, $message));
        } elseif ($dispute->seller->user_id === $user->id && $dispute->buyer) {
            // Seller sent message, notify buyer
            $dispute->buyer->notify(new DisputeMessageNotification($dispute, $message));
        }

        return redirect()->back()->with('success', 'Message sent successfully.');
    }
}

