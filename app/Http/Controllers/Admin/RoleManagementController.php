<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rule;

class RoleManagementController extends Controller
{
    private const PROTECTED_ROLES = [
        'client',
        'staff',
        'admin',
        'super-user',
    ];

    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index(): View
    {
        $roles = Role::paginate(10);

        return view('admin.roles.index')
            ->with('roles', $roles);
    }

    /**
     * Show the form for creating a new resource.
     * @return View
     */
    public function create(): View
    {
        $permissions = Permission::all();

        return view('admin.roles.create')
            ->with('permissions', $permissions);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        try{
            $validated = $request->validate([
                'name'=>[
                    'required',
                    'min:5',
                    'max:64',
                    'unique:roles'
                ]
            ]);

            $validated['name'] = Str::of($validated['name'])
                ->kebab();

            Role::create($validated);
        } catch (ValidationException $e) {
            flash()->error('Please fix the errors in the form.',
                [
                    'position' => 'top-center',
                    'timeout' => 5000,
                ],
                'Role Creation Failed');
        }

        flash()
            ->option('position', 'top-center')
            ->option('timeout', 5000)
            ->success("Role created successfully!");

        return to_route('admin.roles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $permissions = Permission::all();
        $rolePermissions = $role->permissions()->get();

        return \view('admin.roles.show')
            ->with('role', $role)
            ->with('permissions', $permissions)
            ->with('rolePermissions', $rolePermissions);
    }

    /**
     * Show the form for editing the specified resource.
     * @param Role $role
     * @return View
     */
    public function edit(Role $role): View
    {
        $permissions = Permission::all();
        $rolePermissions = $role->permissions()->get();

        $isProtected = in_array($role->name, self::PROTECTED_ROLES);

        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions', 'isProtected'));
    }


    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Role $role
     * @return RedirectResponse
     */
    public function update(Request $request, Role $role): RedirectResponse
    {
        if (in_array($role->name, self::PROTECTED_ROLES)) {
            flash()->warning("You cannot rename a system role.");
            return back();
        }

        try{
            $request['name'] = Str::of($request['name'])
                ->kebab()??null;

            $validated = $request->validate([
                'name' => [
                    'required',
                    'min:5',
                    'max:64',
                    Rule::unique(Role::class)->ignore($role),
                ]
            ]);

            $validated['name'] = Str::of($validated['name'])
                ->kebab();

            $role->update($validated);
        } catch (ValidationException $e){
            flash()->error('Please fix the errors in the form.',
                [
                    'position' => 'top-center',
                    'timeout' => 5000,
                ],
                'Role Update Failed');
        }

        flash()
            ->option('position', 'top-center')
            ->option('timeout', 5000)
            ->success("Role updated successfully!");

        return to_route('admin.roles.index');
    }

    /**
     * @param Role $role
     * @return View
     */
    public function delete(Role $role): View
    {
        if (in_array($role->name, self::PROTECTED_ROLES)) {
            abort(403, "This role cannot be deleted.");
        }

        return \view('admin.roles.delete')
            ->with('role', $role);
    }

    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @param Role $role
     * @return RedirectResponse
     */
    public function destroy(Request $request, Role $role):RedirectResponse
    {
        if (in_array($role->name, self::PROTECTED_ROLES)) {
            flash()->error("You cannot delete system roles.");
            return back();
        }

        try {
            $roleName = $role->name;

            $validated = $request->validate([
                'name' => [
                    'required',
                    Rule::exists('roles', 'name')
                        ->where('name', $roleName),
                ]
            ]);

            $role->delete();
        } catch (QueryException $e) {
            flash()->error('Please fix the errors in the form.',
                [
                    'position' => 'top-center',
                    'timeout' => 5000,
                ],
                'Role Deletion Failed');
        }
        flash()
            ->option('position', 'top-center')
            ->option('timeout', 5000)
            ->success("Role deleted successfully!");

        return to_route('admin.roles.index');
    }

    /**
     * @param Request $request
     * @param Role $role
     * @return RedirectResponse
     */
    public function givePermission(Request $request, Role $role): RedirectResponse
    {
        if ($role->hasPermissionTo($request->permission)) {

            flash()->warning('Role already has this permission.',
                [
                    'position' => 'top-center',
                    'timeout' => 5000,
                ],
                'Permission Exists');

            return back();

        }

        $role->givePermissionTo($request->permission);

        flash()->success('Permission has been addd to the Role.',
            [
                'position' => 'top-center',
                'timeout' => 5000,
            ],
            'Permission Added');

        return back();
    }

    /**
     * @param Role $role
     * @param Permission $permission
     * @return RedirectResponse
     */
    public function revokePermission(
        Role $role,
        Permission $permission): RedirectResponse
    {
        if ($role->hasPermissionTo($permission)) {

            $role->revokePermissionTo($permission);

            flash()->success('Permission has been removed from the Role.',
                [
                    'position' => 'top-center',
                    'timeout' => 5000,
                ],
                'Permission Revoked');

            return back();
        }

        flash()->warning('Role did not have this permission.',
            [
                'position' => 'top-center',
                'timeout' => 5000,
            ],
            'Permission not present');

        return back();
    }
}
