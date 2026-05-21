@extends('layouts.staff')

@section('content')

@if(session('error'))
<div style="background:#fee2e2;color:#b91c1c;padding:10px;border-radius:6px;margin-bottom:15px;">
    {{ session('error') }}
</div>
@endif

<style>
.secondary-btn
{
    display:inline-flex;

    align-items:center;
    justify-content:center;

    padding:12px 20px;

    border-radius:14px;

    background:#D8CCBC;

    color:#4A3728;

    text-decoration:none;

    font-weight:600;

    transition:0.2s ease;
}

.secondary-btn:hover
{
    background:#C9B9A5;
}

</style>
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

    <div style="display:flex; gap:12px; margin-top:20px;">

    <button type="submit" class="save-btn">
        Update Booking
    </button>

    <a href="{{ route('staff.bookings.index') }}" class="secondary-btn">
        Cancel
    </a>

    </div>
</form>

@endsection