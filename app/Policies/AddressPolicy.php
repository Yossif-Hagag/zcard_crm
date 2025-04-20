<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Address;
use Illuminate\Auth\Access\HandlesAuthorization;

class AddressPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the address can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list addresses');
    }

    /**
     * Determine whether the address can view the model.
     */
    public function view(User $user, Address $model): bool
    {
        return $user->hasPermissionTo('view addresses');
    }

    /**
     * Determine whether the address can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create addresses');
    }

    /**
     * Determine whether the address can update the model.
     */
    public function update(User $user, Address $model): bool
    {
        return $user->hasPermissionTo('update addresses');
    }

    /**
     * Determine whether the address can delete the model.
     */
    public function delete(User $user, Address $model): bool
    {
        return $user->hasPermissionTo('delete addresses');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete addresses');
    }

    /**
     * Determine whether the address can restore the model.
     */
    public function restore(User $user, Address $model): bool
    {
        return false;
    }

    /**
     * Determine whether the address can permanently delete the model.
     */
    public function forceDelete(User $user, Address $model): bool
    {
        return false;
    }
}
