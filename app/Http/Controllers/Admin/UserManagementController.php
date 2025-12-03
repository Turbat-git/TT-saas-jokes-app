<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
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
        try{
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

            $user = User::create($validated);
        } catch (ValidationException $e) {
            flash()->error('Please fix the errors in the form.',
                [
                    'position' => 'top-center',
                    'timeout' => 5000,
                ],
                'User Creation Failed');

            return back()->withErrors($e->validator)->withInput();
        }


        $userName = $user->name;

        flash()
            ->option('position', 'top-center')
            ->option('timeout', 5000)
            ->success("User $userName created successfully!");

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
        try{
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

        } catch (ValidationException $e) {
            flash()->error('Please fix the errors in the form.',
                [
                    'position' => 'top-center',
                    'timeout' => 5000,
                ],
                'User Edit Failed');

            return back()->withErrors($e->validator)->withInput();
        }

        flash()
            ->option('position', 'top-center')
            ->option('timeout', 5000)
            ->success("User edited successfully!");

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
        try{
            $oldUser = $user;

            $user->delete();

        } catch (QueryException $e){
            flash()->error('Could not delete user.',
                [
                    'position' => 'top-center',
                    'timeout' => 5000,
                ],
                'User Deletion Failed');

            return back();
        }

        flash()
            ->option('position', 'top-center')
            ->option('timeout', 5000)
            ->success("User deleted successfully!");

        return to_route('admin.users.index');
    }
}
