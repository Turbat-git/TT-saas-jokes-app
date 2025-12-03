<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;

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
     */
    public function show(string $id)
    {
        //
    }
}
