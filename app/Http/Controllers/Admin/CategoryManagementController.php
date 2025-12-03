<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CategoryManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():View
    {
        $categories = Category::paginate();

        return view('admin.categories.index')
            ->with('categories', $categories);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():View
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $validated = $request->validate([
                'title' => [
                    'required',
                    'min:3',
                    'max:64',
                    Rule::unique('categories', 'title')
                ],
                'description' => [
                    'nullable',
                    'max:255',
                ]
            ]);

            $category = Category::create($validated);

        } catch (ValidationException $e) {
            flash()->error('Please fix the errors in the form.',
                [
                    'position' => 'top-center',
                    'timeout' => 5000,
                ],
                'Category Creation Failed');

            return back()->withErrors($e->validator)->withInput();
        }

        $categoryName = $category->title;

        flash()
            ->option('position', 'top-center')
            ->option('timeout', 5000)
            ->success("Category $categoryName created successfully!");
        return to_route('admin.categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category):View
    {
        return view('admin.categories.show')
            ->with('category', $category);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category): View
    {
        return view('admin.categories.edit')
            ->with('category', $category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        try{
            $oldCategory = $category;

            $validated = $request->validate([
                'title' => [
                    'required',
                    'min:3',
                    'max:64',
                    Rule::unique('categories','title')->ignore($category)
                ],
                'description' => [
                    'nullable',
                    'max:255',
                ]
            ]);

            $category->update($validated);

        } catch (ValidationException $e) {
            flash()->error('Please fix the errors in the form.',
                [
                    'position' => 'top-center',
                    'timeout' => 5000,
                ],
                'Category Update Failed');

            return back()->withErrors($e->validator)->withInput();
        }

        $categoryName = $category->title;

        flash()
            ->option('position', 'top-center')
            ->option('timeout', 5000)
            ->success("Category $categoryName updated successfully!");

        return to_route('admin.categories.index');
    }

    /**
     * Confirm the deletion of a category resource from storage.
     */
    public function delete(Category $category):View
    {
        return view('admin.categories.delete')
            ->with('category', $category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        try{
            $oldCategory = $category;

            $category->delete();
        } catch (QueryException $e) {
            flash()->error('Could not delete category.',
                [
                    'position' => 'top-center',
                    'timeout' => 5000,
                ],
                'Category Deletion Failed');

            return back();
        }

        $categoryName = $oldCategory->title;

        flash()
            ->option('position', 'top-center')
            ->option('timeout', 5000)
            ->success("Category $categoryName updated successfully!");

        return to_route('admin.categories.index');
    }
}
