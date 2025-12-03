<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryManagementController;
use App\Http\Controllers\Admin\PermissionManagementController;
use App\Http\Controllers\Admin\RoleManagementController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\JokeController;
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


Route::middleware(['auth', 'verified', 'role:client|staff|admin|super-user'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])
        ->name('dashboard');
    Route::get('/about', [StaticPageController::class, 'about'])
        ->name('about');

    Route::get('jokes/{joke}/delete', [JokeController::class, 'delete'])
        ->name('jokes.delete');

    Route::resource('jokes', JokeController::class);
});


/* Staff and Admin Routes */
Route::middleware(['auth', 'verified', 'role:staff|admin|super-user'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', [AdminController::class, 'index'])
            ->name('index');

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


        Route::get('users/{user}/delete', [UserManagementController::class, 'delete'])
            ->name('users.delete');
        Route::resource('users', UserManagementController::class);

        Route::middleware(['auth', 'verified', 'role:admin|super-user'])
            ->group(function () {

                Route::resource('roles', RoleManagementController::class);

                Route::resource('permissions', PermissionManagementController::class)
                    ->only(['index','show']);

                Route::post('/roles/{role}/permissions',
                    [RoleManagementController::class, 'givePermission'])
                    ->name('roles.permissions');

                Route::delete('/roles/{role}/permissions/{permission}',
                    [RoleManagementController::class, 'revokePermission'])
                    ->name('roles.permissions.revoke');

                Route::get('roles/{role}/delete', [RoleManagementController::class, 'delete'])
                    ->name('roles.delete');
            });

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
