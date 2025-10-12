<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    /**
     * Determine if the user can view the order.
     */
    public function view(User $user, Order $order): bool
    {
        return $user->id === $order->user_id;
    }

    /**
     * Determine if the user can view the order's delivery page.
     */
    public function viewDelivery(User $user, Order $order): bool
    {
        // Must be the order owner
        if ($user->id !== $order->user_id) {
            return false;
        }

        // Order must be paid
        return $order->payment_status === 'completed';
    }
}
