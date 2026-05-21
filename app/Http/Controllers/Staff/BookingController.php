<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = \App\Models\Booking::with(['room', 'staff'])
        ->latest()
        ->paginate(10);

        return view('staff.bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rooms = Room::all();

        return view('staff.bookings.create', compact('rooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $request->validate([
        'guest_name' => 'required|string|max:255',
        'room_id' => 'required|exists:rooms,id',
        'check_in_date' => 'required|date',
        'check_out_date' => 'required|date|after_or_equal:check_in_date',
        'status' => 'required|string',
    ]);

    // Check for overlapping bookings
    $conflict = \App\Models\Booking::where('room_id', $request->room_id)
        ->where('status', '!=', 'cancelled')
        ->where(function ($query) use ($request) {
            $query->where('check_in_date', '<', $request->check_out_date)
                  ->where('check_out_date', '>', $request->check_in_date);
        })
        ->exists();

    if ($conflict) {
        return back()
            ->withInput()
            ->with('error', 'This room is already booked for the selected dates.');
    }

    // Get the room
    $room = Room::findOrFail($request->room_id);

    $checkIn = Carbon::parse($request->check_in_date);
    $checkOut = Carbon::parse($request->check_out_date);

    if ($request->status === 'blocked') {
        $totalPrice = 0;
        $guestName = 'Unavailable';
    } else {
        $nights = $checkIn->diffInDays($checkOut);
        $totalPrice = max($nights, 1) * $room->base_price;
        $guestName = $request->guest_name;
    }

    \App\Models\Booking::create([
        'guest_name' => $guestName,
        'room_id' => $request->room_id,
        'check_in_date' => $request->check_in_date,
        'check_out_date' => $request->check_out_date,
        'total_price' => $totalPrice,
        'status' => $request->status,
        'source' => 'manual',
        'handled_by' => auth()->id()
    ]);

    return redirect()
        ->route('staff.bookings.index')
        ->with('success', 'Booking created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
    $rooms = Room::all();

    return view('staff.bookings.edit', compact('booking', 'rooms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        // VALIDATION (ADD THIS)
        $request->validate([
            'guest_name' => 'required|string|max:255',
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after_or_equal:check_in_date',
            'status' => 'required|in:pending,confirmed,checked_in,checked_out,blocked,cancelled'
        ]);

        $room = Room::findOrFail($request->room_id);

        $checkIn = Carbon::parse($request->check_in_date);
        $checkOut = Carbon::parse($request->check_out_date);

        // PRICE + NAME LOGIC
        if ($request->status === 'blocked') {
            $totalPrice = 0;
            $guestName = 'Unavailable';
        } else {
            $nights = $checkIn->diffInDays($checkOut);
            $totalPrice = max($nights, 1) * $room->base_price;
            $guestName = $request->guest_name;
        }

        // UPDATE
        $booking->update([
            'guest_name' => $guestName,
            'room_id' => $request->room_id,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'total_price' => $totalPrice,
            'status' => $request->status
        ]);

        return redirect()
            ->route('staff.bookings.index')
            ->with('success', 'Booking updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
    $booking->delete();

    return redirect()->route('staff.bookings.index');
    }
}
