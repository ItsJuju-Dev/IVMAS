<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Iteration 1:
| - No authentication middleware
| - Admin pages are accessible directly
| - Focused on DB-connected CRUD
|
*/

/*
|-----------------------------------
| Public Routes
|-----------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|-----------------------------------
| Admin Dashboard
|-----------------------------------
*/
Route::get('/admin', function () {
    return view('admin-dashboard');
})->name('admin.dashboard');

/*
|-----------------------------------
| Admin - User Management (Iteration 1)
|-----------------------------------
*/
Route::prefix('admin')->group(function () {

    // Show users list
    Route::get('/users', [UserController::class, 'index'])
        ->name('admin.users.index');

    // Create user
    Route::post('/users', [UserController::class, 'store'])
        ->name('admin.users.store');

    // Edit user
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])
        ->name('admin.users.edit');

    // Update user    
    Route::put('/users/{user}', [UserController::class, 'update'])
        ->name('admin.users.update');

    // Delete user
    Route::delete('/users/{user}', [UserController::class, 'destroy'])
        ->name('admin.users.destroy');

});

/*
|-----------------------------------
| Placeholder / Future Routes
|-----------------------------------
*/
Route::get('/configure-system', function () {
    return view('welcome');
});
