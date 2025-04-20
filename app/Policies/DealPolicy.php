<?php

namespace App\Policies;

use App\Models\Deal;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DealPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the deal can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list deals');
    }

    /**
     * Determine whether the deal can view the model.
     */
    public function view(User $user, Deal $model): bool
    {
        return $user->hasPermissionTo('view deals');
    }

    /**
     * Determine whether the deal can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create deals');
    }

    /**
     * Determine whether the deal can update the model.
     */
    public function update(User $user, Deal $model): bool
    {
        return $user->hasPermissionTo('update deals');
    }

    /**
     * Determine whether the deal can delete the model.
     */
    public function delete(User $user, Deal $model): bool
    {
        return $user->hasPermissionTo('delete deals');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete deals');
    }

    /**
     * Determine whether the deal can restore the model.
     */
    public function restore(User $user, Deal $model): bool
    {
        return false;
    }

    /**
     * Determine whether the deal can permanently delete the model.
     */
    public function forceDelete(User $user, Deal $model): bool
    {
        return false;
    }
}
