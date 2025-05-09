<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('list roles', Role::class);

        $search = $request->get('search', '');
        $roles = Role::where('name', 'like', "%{$search}%")->paginate(10);

        return view('app.roles.index')
            ->with('roles', $roles)
            ->with('search', $search);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create', Role::class);

        $permissions = Permission::all();
        $roles = Role::all();


        return view('app.roles.create')->with('permissions', $permissions)->with('roles', $roles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        $this->authorize('create', Role::class);

        $data = $this->validate($request, [
            'name' => 'required|unique:roles|max:32',
            'permissions' => 'array',
            'parent_id' => 'nullable|integer|' . Rule::exists('roles', 'id'),
        ]);

        $role = Role::create($data);

        $permissions = Permission::find($request->permissions);
        $role->syncPermissions($permissions);

        return redirect()
            ->route('roles.index', $role->id)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role): View
    {
        $this->authorize('view', Role::class);

        return view('app.roles.show')->with('role', $role);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role): View
    {
        $this->authorize('update', $role);

        $permissions = Permission::all();
        $roles = Role::whereNot('id', $role->id)->get();
        return view('app.roles.edit')
            ->with('role', $role)
            ->with('roles', $roles)
            ->with('permissions', $permissions);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role): RedirectResponse
    {
        $this->authorize('update', $role);

        $data = $this->validate($request, [
            'name' => 'required|max:32|unique:roles,name,' . $role->id,
            'permissions' => 'array',
            'parent_id' => 'nullable|integer|' . Rule::exists('roles', 'id'),
        ]);


        $role->update($data);

        $permissions = Permission::find($request->permissions);
        $role->syncPermissions($permissions);

        return redirect()
            ->route('roles.index', $role->id)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role): RedirectResponse
    {
        $this->authorize('delete', $role);

        $role->delete();

        return redirect()
            ->route('roles.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
