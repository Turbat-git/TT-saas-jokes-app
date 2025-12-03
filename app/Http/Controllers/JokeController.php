<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Joke;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class JokeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index(): View
    {

        $query = Joke::query();


        $jokes = Joke::with('userVotes')
            ->withCount([
                'votes as likesCount'
                => fn (Builder $query)
                => $query->where('vote', '>', 0)], 'vote')
            ->withCount([
                'votes as dislikesCount'
                => fn (Builder $query)
                => $query->where('vote', '<', 0)], 'vote')
            ->with('categories')
            ->latest()
            ->paginate();

        // Search
        if (request()->has('search')) {
            $search = request('search');
            $query->where('title', 'like', "%$search%")
                ->orWhere('content', 'like', "%$search%");
        }

        return view('jokes.index')
            ->with('jokes', $jokes);
    }

    /**
     * Show the form for creating a new resource.
     * @return View
     */
    public function create():View
    {
        $categories = Category::all();

        return view('jokes.create')
            ->with('categories', $categories);
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

        } catch (ValidationException $e){
            flash()->error('Please fix the errors in the form.',
                [
                    'position' => 'top-center',
                    'timeout' => 5000,
                ],
                'Joke Creation Failed');

            return back()->withErrors($e->validator)->withInput();
        }

        $jokeName = $joke->title;

        flash()
            ->option('position', 'top-center')
            ->option('timeout', 5000)
            ->success("$jokeName created successfully!");

        return to_route('jokes.index');
    }

    /**
     * Display the specified resource.
     * @param Joke $joke
     * @return View
     */
    public function show(Joke $joke): View
    {
        return view('jokes.show')
            ->with('joke', $joke);
    }

    /**
     * Show the form for editing the specified resource.
     * @param Joke $joke
     * @return View
     */
    public function edit(Joke $joke): View
    {
        $categories = Category::all();

        return view('jokes.edit')
            ->with('joke', $joke)
            ->with('categories', $categories);
    }

    /**
     * Update the specified resource in storage.
     *
     *
     * @param Request $request
     * @param Joke $joke
     * @return RedirectResponse
     */
    public function update(Request $request, Joke $joke): RedirectResponse
    {
        try{
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
                ],
                'categories' => [
                    'required',
                    'array'
                ],
                'categories.*' => [
                    'integer',
                    'exists:categories,id'
                ],
            ]);

            $joke->update($validated);
            $joke->categories()->sync($validated['categories']);
        } catch (ValidationException $e) {
            flash()->error('Please fix the errors in the form.',
                [
                    'position' => 'top-center',
                    'timeout' => 5000,
                ],
                'Joke Update Failed');

            return back()->withErrors($e->validator)->withInput();
        }

        $jokeName = $joke->title;

        flash()
            ->option('position', 'top-center')
            ->option('timeout', 5000)
            ->success("$jokeName updated successfully!");

        return to_route('jokes.index');
    }

    /**
     * @param Joke $joke
     * @return View
     */
    public function delete(Joke $joke):View
    {
        return view('jokes.delete')
            ->with('joke', $joke);
    }

    /**
     * Remove the specified resource from storage.
     * @param Joke $joke
     * @return RedirectResponse
     */
    public function destroy(Joke $joke): RedirectResponse
    {
        try {
            $oldJoke = $joke;

            $joke->delete();
        } catch (QueryException $e) {
            flash()->error('Could not delete joke.',
                [
                    'position' => 'top-center',
                    'timeout' => 5000,
                ],
                'Joke Deletion Failed. ');
        }

        $jokeName = $oldJoke->title;

        flash()
            ->option('position', 'top-center')
            ->option('timeout', 5000)
            ->success("$jokeName deleted successfully!");

        return to_route('jokes.index');
    }
}
