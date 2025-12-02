<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryManagementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaticPageController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoryController as GuestCategoryController;

// alias

Route::get('/', [StaticPageController::class, 'home'])
    ->name('home');

/* Guest/Client Category Routes */
Route::get('categories', [GuestCategoryController::class, 'index'])
    ->name('categories.index');
Route::get('categories/{category}', [GuestCategoryController::class, 'show'])
    ->name('categories.show');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])
        ->name('dashboard');
});


/* Staff and Admin Routes */
Route::middleware(['auth', 'verified'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminController::class, 'index'])
            ->name('index');

        Route::get('users', [AdminController::class, 'users'])->name('users');

        Route::get('categories', [AdminController::class, 'categories'])->name('categories');

        Route::get('categories/{category}/delete', [CategoryManagementController::class, 'delete'])
            ->name('categories.delete');

        /**
         * Creates the routes:
         *      admin.categories.index
         *      admin.categories.show
         *      admin.categories.add
         *      admin.categories.create
         *      admin.categories.edit
         *      admin.categories.update
         *      admin.categories.destroy
         */
        Route::resource('categories', CategoryManagementController::class);

    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';
