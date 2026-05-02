<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Staff\BookingController;
use App\Http\Controllers\Staff\CalendarController;
use App\Http\Controllers\Staff\DashboardController as StaffDashboardController;
use App\Http\Controllers\Owner\CalendarController as OwnerCalendarController;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboardController;

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
            'owner' => redirect()->route('owner.dashboard'),
            'staff' => redirect()->route('staff.dashboard'),
            default => abort(403),
        };
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Owner Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('owner')
    ->name('owner.')
    ->middleware(['auth','role:owner'])
    ->group(function () {

        Route::get('/', [OwnerDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/export', [OwnerDashboardController::class, 'export'])
            ->name('export');

        Route::get('/export-pdf', [OwnerDashboardController::class, 'exportPdf'])
            ->name('export.pdf');
        
        Route::get('/calendar', [OwnerCalendarController::class, 'index'])
            ->name('calendar');
            
        Route::get('/report', [OwnerDashboardController::class, 'generateReport'])
            ->name('report');

        Route::post('/import-ical', [OwnerDashboardController::class, 'importIcal'])
            ->name('import.ical');

        Route::post('/import-availability', [OwnerDashboardController::class, 'importAvailability'])
            ->name('import.availability');
    });

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

        Route::get('/', [AdminDashboardController::class, 'index'])
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

    /*
    |--------------------------------------------------------------------------
    | Staff Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('staff')
    ->name('staff.')
    ->middleware(['auth','role:staff'])
    ->group(function () {

        Route::get('/', [StaffDashboardController::class, 'index'])
            ->name('dashboard');

        // Bookings
        Route::resource('bookings', BookingController::class);

        // Calendar
        Route::get('/calendar', [CalendarController::class, 'index'])
            ->name('calendar');

    });
});

/*
|--------------------------------------------------------------------------
| Auth Routes (Laravel Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
