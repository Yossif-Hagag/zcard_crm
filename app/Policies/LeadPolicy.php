<?php

namespace App\Policies;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LeadPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the lead can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list leads');
    }

    /**
     * Determine whether the lead can view the model.
     */
    public function view(User $user, Lead $model): bool
    {
        return $user->hasPermissionTo('view leads');
    }

    /**
     * Determine whether the lead can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create leads');
    }

    /**
     * Determine whether the lead can update the model.
     */
    public function update(User $user, Lead $model): bool
    {
        return $user->hasPermissionTo('update leads');
    }

    /**
     * Determine whether the lead can delete the model.
     */
    public function delete(User $user, Lead $model): bool
    {
        return $user->hasPermissionTo('delete leads');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete leads');
    }

    /**
     * Determine whether the lead can restore the model.
     */
    public function restore(User $user, Lead $model): bool
    {
        return false;
    }

    /**
     * Determine whether the lead can permanently delete the model.
     */
    public function forceDelete(User $user, Lead $model): bool
    {
        return false;
    }
}
