<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(10);

        return view('admin.users.index')
            ->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'min:3',
                'max:64'
            ],
            'email' => [
                'required',
                'email',
            ],
            'password' => [
                'required',
                'min:8',
                'max:16',
                'confirmed'
            ]
        ]);

        User::create($validated);

        return to_route('admin.users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user):View
    {
        return view('admin.users.show')
            ->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit')
            ->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $oldUser = $user;

        $validated = $request->validate([
            'name' => [
                'required',
                'max:64',
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users','email')->ignore($user)
            ]
        ]);

        $user->update($validated);
        return to_route('admin.users.index');
    }

    public function delete(User $user):View
    {
        return view('admin.users.delete')
            ->with('user', $user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $oldUser = $user;

        $user->delete();

        return to_route('admin.users.index');
    }
}
