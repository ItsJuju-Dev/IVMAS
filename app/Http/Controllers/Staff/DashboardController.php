<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

            return view('staff.dashboard', [

                'totalBookings' => Booking::count(),

                // ✅ FIXED
                'todayCheckIns' => Booking::whereDate('check_in_date', $today)->count(),

                // ✅ FIXED
                'todayCheckOuts' => Booking::whereDate('check_out_date', $today)->count(),

                // ✅ FIXED
                'occupiedRooms' => Booking::where('check_in_date', '<=', $today)
                    ->where('check_out_date', '>=', $today)
                    ->count(),

                'totalRooms' => Room::count(),

            ]);
    }
}