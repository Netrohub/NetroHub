<?php

namespace App\Policies;

use App\Models\Dispute;
use App\Models\User;

class DisputePolicy
{
    /**
     * Determine if the user can view any disputes
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine if the user can view the dispute
     */
    public function view(User $user, Dispute $dispute): bool
    {
        // Buyer can view their own disputes
        if ($dispute->buyer_id === $user->id) {
            return true;
        }

        // Seller can view disputes against them
        if ($user->seller && $dispute->seller_id === $user->seller->id) {
            return true;
        }

        // Admins can view all disputes
        if ($user->isAdmin()) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the user can create disputes
     */
    public function create(User $user): bool
    {
        return $user->email_verified_at !== null;
    }

    /**
     * Determine if the user can add messages to the dispute
     */
    public function addMessage(User $user, Dispute $dispute): bool
    {
        // Cannot add messages to resolved disputes
        if (in_array($dispute->status, ['resolved_refund', 'resolved_upheld'])) {
            return false;
        }

        // Buyer can message their own disputes
        if ($dispute->buyer_id === $user->id) {
            return true;
        }

        // Seller can message disputes against them
        if ($user->seller && $dispute->seller_id === $user->seller->id) {
            return true;
        }

        // Admins can always message
        if ($user->isAdmin()) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the user can resolve disputes
     */
    public function resolve(User $user, Dispute $dispute): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can delete the dispute
     */
    public function delete(User $user, Dispute $dispute): bool
    {
        return $user->isAdmin();
    }
}


