<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Joke;
use App\Http\Requests\StoreJokeRequest;
use App\Http\Requests\UpdateJokeRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class JokeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jokes = Joke::with('userVotes')
            ->withCount([
                'votes as likesCount'
                => fn (Builder $query)
                => $query->where('vote', '>', 0)], 'vote')
            ->withCount([
                'votes as dislikesCount'
                => fn (Builder $query)
                => $query->where('vote', '<', 0)], 'vote')
            ->latest()
            ->paginate();

        $query = Joke::query();

        // Search
        if (request()->has('search')) {
            $search = request('search');
            $query->where('title', 'like', "%$search%")
                ->orWhere('content', 'like', "%$search%");
        }

        $jokes = $query->with('categories')->paginate(10);

        return view('jokes.index')
            ->with('jokes', $jokes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('jokes.create')
            ->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required','min:3','max:64'],
            'content' => ['required','min:3','max:255'],
            'categories' => ['required', 'array'],
            'categories.*' => ['exists:categories,id'],
        ]);

        $categories = $validated['categories'];
        unset($validated['categories']);

        $validated['user_id'] = Auth::id();

        $joke = Joke::create($validated);

        $joke->categories()->sync($categories);

        return to_route('jokes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Joke $joke)
    {
        return view('jokes.show')
            ->with('joke', $joke);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Joke $joke)
    {
        $categories = Category::all();

        return view('jokes.edit')
            ->with('joke', $joke)
            ->with('categories', $categories);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Joke $joke)
    {
        $oldJoke = $joke;

        $validated = $request->validate([
            'title' => [
                'required',
                'min:3',
                'max:64',
                Rule::unique('jokes','title')->ignore($joke)
            ],
            'content' => [
                'required',
                'max:255',
            ]
        ]);

        $joke->update($validated);
        $joke->categories()->sync($validated['categories']);

        return to_route('jokes.index');
    }

    public function delete(Joke $joke)
    {
        return view('jokes.delete')
            ->with('joke', $joke);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Joke $joke)
    {
        $oldJoke = $joke;

        $joke->delete();

        return to_route('jokes.index');
    }
}
