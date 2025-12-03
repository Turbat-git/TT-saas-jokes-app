<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use \Illuminate\Http\RedirectResponse;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index(): View
    {
        $users = User::paginate(10);

        return view('admin.users.index')
            ->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     * @return View
     */
    public function create(): View
    {
        return view('admin.users.create');
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
     * @param User $user
     * @return View
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit')
            ->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(Request $request, User $user): RedirectResponse
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
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
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
