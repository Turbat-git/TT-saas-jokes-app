<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Joke;
use App\Models\User;
use Illuminate\Support\Number;
use Illuminate\View\View;

class AdminController extends Controller
{
    //
    public function index(): View
    {
        $userCount = User::count();
        $userSuspendedCount = User::where('suspended', 1)->count();
        $jokesCount = Joke::all()->count();
        $categoriesCount = Category::all()->count();

        return view('admin.index')
            ->with('userCount', Number::format($userCount))
            ->with('userSuspendedCount', Number::format($userSuspendedCount))
            ->with('jokesCount', $jokesCount)
            ->with('categoriesCount', $categoriesCount);
    }

    //
    public function users(): View
    {
        $users = User::paginate(10);

        return view('admin.users.index')
            ->with('users', $users);
    }

    public function categories(): View{
        $categories = Category::paginate(10);

        return view('admin.categories.index')
            ->with('categories', $categories);
    }
}
