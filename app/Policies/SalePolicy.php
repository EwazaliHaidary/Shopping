<?php

namespace App\Policies;

use App\Models\Sale;
use App\Models\User;

class SalePolicy
{
    // Determine whether the user can view all sales
    public function viewAny(User $user): bool
    {
        return true;
    }

    // Determine whether the user can view a sale
    public function view(User $user, Sale $sale): bool
    {
        return $user->id === $sale->user_id;
    }

    // Determine whether the user can create a sale
    public function create(User $user): bool
    {
        return true;
    }

    // Determine whether the user can update a sale
    public function update(User $user, Sale $sale): bool
    {
        return $user->id === $sale->user_id;
    }

    // Determine whether the user can delete a sale
    public function delete(User $user, Sale $sale): bool
    {
        return $user->id === $sale->user_id;
    }

    // Determine whether the user can restore a sale
    public function restore(User $user, Sale $sale): bool
    {
        return false;
    }

    // Determine whether the user can permanently delete a sale
    public function forceDelete(User $user, Sale $sale): bool
    {
        return false;
    }
}
