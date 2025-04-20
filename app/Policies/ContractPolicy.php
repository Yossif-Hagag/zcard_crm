<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Contract;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContractPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the contract can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list contracts');
    }

    /**
     * Determine whether the contract can view the model.
     */
    public function view(User $user, Contract $model): bool
    {
        return $user->hasPermissionTo('view contracts');
    }

    /**
     * Determine whether the contract can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create contracts');
    }

    /**
     * Determine whether the contract can update the model.
     */
    public function update(User $user, Contract $model): bool
    {
        return $user->hasPermissionTo('update contracts');
    }

    /**
     * Determine whether the contract can delete the model.
     */
    public function delete(User $user, Contract $model): bool
    {
        return $user->hasPermissionTo('delete contracts');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete contracts');
    }

    /**
     * Determine whether the contract can restore the model.
     */
    public function restore(User $user, Contract $model): bool
    {
        return false;
    }

    /**
     * Determine whether the contract can permanently delete the model.
     */
    public function forceDelete(User $user, Contract $model): bool
    {
        return false;
    }
}
