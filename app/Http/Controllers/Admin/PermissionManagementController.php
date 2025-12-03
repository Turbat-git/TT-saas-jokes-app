<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return View
     */

    public function index():View
    {
        $permissions = Permission::paginate(10);

        return view('admin.permissions.index')
            ->with('permissions', $permissions);
    }

    /**
     * Display the specified resource.
     * @param Permission $permission
     * @return View
     */
    public function show(Permission $permission):View
    {
        $roles = Role::all();
        return \view('admin.permissions.show')
            ->with('permission', $permission)
            ->with('roles', $roles);
    }
}
