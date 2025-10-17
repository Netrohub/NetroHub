<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dispute;
use App\Models\DisputeMessage;
use App\Notifications\DisputeResolvedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DisputeController extends Controller
{
    /**
     * Display a listing of all disputes for moderators
     */
    public function index(Request $request)
    {
        $status = $request->query('status', 'escalated');
        
        $query = Dispute::with(['order', 'orderItem.product', 'buyer', 'seller', 'resolvedBy']);

        // Default view shows only escalated disputes requiring attention
        if ($status === 'escalated') {
            $query->whereIn('status', ['escalated', 'in_review']);
        } elseif ($status !== 'all') {
            $query->where('status', $status);
        }

        $disputes = $query->latest()->paginate(20);

        $stats = [
            'total' => Dispute::count(),
            'between_parties' => Dispute::whereIn('status', ['open', 'resolved'])->count(),
            'escalated' => Dispute::whereIn('status', ['escalated', 'in_review'])->count(),
            'resolved' => Dispute::whereIn('status', ['resolved', 'resolved_refund', 'resolved_upheld'])->count(),
        ];

        return view('admin.disputes.index', compact('disputes', 'stats', 'status'));
    }

    /**
     * Display the specified dispute for moderator review
     */
    public function show(Dispute $dispute)
    {
        $dispute->load([
            'order', 
            'orderItem.product', 
            'buyer', 
            'seller.user', 
            'messages.user', 
            'resolvedBy'
        ]);

        return view('admin.disputes.show', compact('dispute'));
    }

    /**
     * Update the dispute status to in_review
     */
    public function takeAction(Request $request, Dispute $dispute)
    {
        if (!in_array($dispute->status, ['escalated', 'open'])) {
            return redirect()->back()->with('error', 'Dispute is not available for review.');
        }

        $dispute->update(['status' => 'in_review']);

        // Add internal note
        $dispute->messages()->create([
            'user_id' => Auth::id(),
            'message' => 'Dispute has been taken into review by moderator ' . Auth::user()->name,
            'is_internal' => true,
        ]);

        return redirect()->back()->with('success', 'Dispute marked as under review.');
    }

    /**
     * Add a message to the dispute (visible to all parties)
     */
    public function addMessage(Request $request, Dispute $dispute)
    {
        $validated = $request->validate([
            'message' => 'required|string|min:3',
            'is_internal' => 'boolean',
        ]);

        $message = $dispute->messages()->create([
            'user_id' => Auth::id(),
            'message' => $validated['message'],
            'is_internal' => $request->boolean('is_internal', false),
        ]);

        return redirect()->back()->with('success', 'Message added successfully.');
    }

    /**
     * Resolve the dispute
     */
    public function resolve(Request $request, Dispute $dispute)
    {
        $validated = $request->validate([
            'resolution' => 'required|in:refund,upheld',
            'admin_notes' => 'required|string|min:10',
        ]);

        $status = $validated['resolution'] === 'refund' ? 'resolved_refund' : 'resolved_upheld';

        $dispute->resolve(Auth::user(), $status, $validated['admin_notes']);

        // Add resolution message
        $dispute->messages()->create([
            'user_id' => Auth::id(),
            'message' => 'Dispute resolved: ' . ucfirst($validated['resolution']) . "\n\n" . $validated['admin_notes'],
            'is_internal' => false,
        ]);

        // Notify both parties
        $dispute->buyer->notify(new DisputeResolvedNotification($dispute));
        if ($dispute->seller->user) {
            $dispute->seller->user->notify(new DisputeResolvedNotification($dispute));
        }

        return redirect()->route('admin.disputes.index')
            ->with('success', 'Dispute has been resolved successfully.');
    }

    /**
     * Add internal note (only visible to moderators)
     */
    public function addInternalNote(Request $request, Dispute $dispute)
    {
        $validated = $request->validate([
            'note' => 'required|string|min:3',
        ]);

        $dispute->messages()->create([
            'user_id' => Auth::id(),
            'message' => $validated['note'],
            'is_internal' => true,
        ]);

        return redirect()->back()->with('success', 'Internal note added successfully.');
    }
}

