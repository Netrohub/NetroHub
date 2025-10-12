<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Product $product): bool
    {
        return $product->status === 'active' ||
               $product->seller->user_id === $user->id ||
               $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->seller && $user->seller->is_active;
    }

    public function update(User $user, Product $product): bool
    {
        return $product->seller->user_id === $user->id || $user->isAdmin();
    }

    public function delete(User $user, Product $product): bool
    {
        return $product->seller->user_id === $user->id || $user->isAdmin();
    }
}
