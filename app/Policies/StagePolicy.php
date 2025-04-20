<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Stage;
use Illuminate\Auth\Access\HandlesAuthorization;

class StagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the stage can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list stages');
    }

    /**
     * Determine whether the stage can view the model.
     */
    public function view(User $user, Stage $model): bool
    {
        return $user->hasPermissionTo('view stages');
    }

    /**
     * Determine whether the stage can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create stages');
    }

    /**
     * Determine whether the stage can update the model.
     */
    public function update(User $user, Stage $model): bool
    {
        return $user->hasPermissionTo('update stages');
    }

    /**
     * Determine whether the stage can delete the model.
     */
    public function delete(User $user, Stage $model): bool
    {
        return $user->hasPermissionTo('delete stages');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete stages');
    }

    /**
     * Determine whether the stage can restore the model.
     */
    public function restore(User $user, Stage $model): bool
    {
        return false;
    }

    /**
     * Determine whether the stage can permanently delete the model.
     */
    public function forceDelete(User $user, Stage $model): bool
    {
        return false;
    }
}
