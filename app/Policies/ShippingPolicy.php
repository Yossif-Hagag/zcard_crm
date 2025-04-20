<?php

namespace App\Policies;

use App\Models\Shipping;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ShippingPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Check if the user has both permissions
        return $user->hasPermissionTo('list shipping') && $user->hasPermissionTo('update shipping status');
    }



    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Shipping $Shipping): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Shipping $Shipping): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Shipping $Shipping): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Shipping $Shipping): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Shipping $Shipping): bool
    {
        //
    }
}
