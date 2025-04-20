<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class LeadersAndRolesSelector extends Component
{
    public ?User $user = null;
    public bool $editing = false;
    public $selectedRoles = [];

    public function mount()
    {
        $this->selectedRoles = $this->user?->roles?->pluck('id')?->toArray() ?? [];
    }
    public function render()
    {

        $rolePrantsIds = Role::query()
            ->whereIn('id', $this->selectedRoles)
            ->get()
            ->pluck('parent_id')
            ->toArray();


        $roles = Role::get();
        $users = User::query()
            ->whereHas(
                'roles',
                fn(Builder $b) => $b->whereIn('id', $rolePrantsIds)
            )
            ->get();

        $parentsIds = $this->user?->parents?->pluck('id')?->toArray();

        return view('livewire.users.leaders-and-roles-selector', [
            'roles' => $roles,
            'users' => $users,
            'parentsIds' => $parentsIds,
        ]);
    }
}
