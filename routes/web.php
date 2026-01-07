<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\DashboardController;

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
Route::get('/admin', [DashboardController::class, 'index'])
    ->name('admin.dashboard');

Route::prefix('admin')->group(function () {

    /*
    |-------------------------
    | User Management
    |-------------------------
    */
    Route::get('/users', [UserController::class, 'index'])
        ->name('admin.users.index');

    Route::post('/users', [UserController::class, 'store'])
        ->name('admin.users.store');

    Route::get('/users/{user}/edit', [UserController::class, 'edit'])
        ->name('admin.users.edit');

    Route::put('/users/{user}', [UserController::class, 'update'])
        ->name('admin.users.update');

    Route::delete('/users/{user}', [UserController::class, 'destroy'])
        ->name('admin.users.destroy');

    /*
    |-------------------------
    | Room Management
    |-------------------------
    */
    Route::get('/rooms', [RoomController::class, 'index'])
        ->name('admin.rooms.index');

    Route::post('/rooms', [RoomController::class, 'store'])
        ->name('admin.rooms.store');

    Route::put('/rooms/{room}', [RoomController::class, 'update'])
        ->name('admin.rooms.update');

    Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])
        ->name('admin.rooms.destroy');
});


/*
|-----------------------------------
| Placeholder / Future Routes
|-----------------------------------
*/
Route::get('/configure-system', function () {
    return view('welcome');
});
