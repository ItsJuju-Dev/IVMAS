<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Role-Based Dashboard
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', function () {
        $user = auth()->user();

        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'owner' => view('owner-dashboard'),
            'staff' => view('staff-dashboard'),
            default => abort(403),
        };
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Owner / Staff Shared Features
    |--------------------------------------------------------------------------
    */
    Route::get('/calendar', function () {
        return view('calendar.index');
    })->name('calendar.index');

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')
    ->middleware('role:admin')
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])
            ->name('admin.dashboard');

        // User Management
        Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

        // Room Management
        Route::get('/rooms', [RoomController::class, 'index'])->name('admin.rooms.index');
        Route::post('/rooms', [RoomController::class, 'store'])->name('admin.rooms.store');
        Route::put('/rooms/{room}', [RoomController::class, 'update'])->name('admin.rooms.update');
        Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])->name('admin.rooms.destroy');
    });
});

/*
|--------------------------------------------------------------------------
| Auth Routes (Laravel Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
