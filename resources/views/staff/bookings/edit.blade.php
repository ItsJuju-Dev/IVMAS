@extends('layouts.staff')

@section('content')

<h2 class="page-title">Edit Booking</h2>

<form method="POST" action="{{ route('staff.bookings.update', $booking) }}" class="form-card">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>Guest Name</label>
        <input type="text" name="guest_name" value="{{ $booking->guest_name }}">
    </div>

    <div class="form-group">
        <label>Room</label>
        <select name="room_id">
            @foreach($rooms as $room)
                <option value="{{ $room->id }}"
                    {{ $booking->room_id == $room->id ? 'selected' : '' }}>
                    {{ $room->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
    <label>Status</label>
    <select name="status">
        <option value="pending">Pending</option>
        <option value="confirmed">Confirmed</option>
        <option value="checked_in">Checked In</option>
        <option value="checked_out">Checked Out</option>
        <option value="cancelled">Cancelled</option>
        <option value="blocked">Blocked (Unavailable)</option>
    </select>
    </div>

    <div class="form-group">
        <label>Check-In Date</label>
        <input type="date" name="check_in_date" value="{{ $booking->check_in_date }}">
    </div>

    <div class="form-group">
        <label>Check-Out Date</label>
        <input type="date" name="check_out_date" value="{{ $booking->check_out_date }}">
    </div>

    <div class="form-group">
        <label>Total Price</label>
        <input type="number" step="0.01" name="total_price" value="{{ $booking->total_price }}">
    </div>

    <button type="submit" class="save-btn">
        Update Booking
    </button>

</form>

@endsection