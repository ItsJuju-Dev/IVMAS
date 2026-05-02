<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('room')->get();

        // Transform bookings into calendar events
        $events = $bookings->map(function ($booking) {

            $color = match ($booking->status) {
                'pending' => '#facc15',
                'confirmed' => '#3b82f6',
                'checked_in' => '#22c55e',
                'checked_out' => '#9ca3af',
                'cancelled' => '#ef4444',
                'blocked' => '#6b7280',
                default => '#3b82f6',
            };

            return [
                'title' => $booking->guest_name . ' - ' . ($booking->room->name ?? 'No Room'),
                'start' => $booking->check_in_date,
                'end' => Carbon::parse($booking->check_out_date)->addDay()->toDateString(),
                'color' => $color,
                'extendedProps' => [
                    'guest' => $booking->guest_name,
                    'room' => $booking->room->name ?? 'N/A',
                    'status' => $booking->status,
                    'check_in' => $booking->check_in_date,
                    'check_out' => $booking->check_out_date,
                ]
            ];
        });

        return view('staff.calendar', compact('events'));
    }
}