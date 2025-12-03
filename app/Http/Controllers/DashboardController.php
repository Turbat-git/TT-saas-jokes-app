<?php

namespace App\Http\Controllers;

use App\Models\Joke;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function dashboard(): View
    {
        $user = auth()->user();

        $jokesCount = Joke::where('user_id', $user->id)->count();

        return view('static.dashboard', [
            'user' => $user,
            'jokesCount' => $jokesCount
        ]);
    }
}
