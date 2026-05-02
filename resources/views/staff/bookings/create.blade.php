@extends('layouts.staff')

@section('content')

@if(session('error'))
<div style="background:#fee2e2;color:#b91c1c;padding:10px;border-radius:6px;margin-bottom:15px;">
    {{ session('error') }}
</div>
@endif

<h2 class="page-title">Add Booking</h2>

<form method="POST" action="{{ route('staff.bookings.store') }}" class="form-card">
    @csrf

    <div class="form-group">
        <label>Guest Name</label>
        <input type="text" name="guest_name" required>
    </div>

    <div class="form-group">
        <label>Room</label>
        <select name="room_id" required>
            @foreach($rooms as $room)
                <option value="{{ $room->id }}">
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
        <input type="date" name="check_in_date" required>
    </div>

    <div class="form-group">
        <label>Check-Out Date</label>
        <input type="date" name="check_out_date" required>
    </div>

    <button type="submit" class="save-btn">
        Save Booking
    </button>

</form>

@endsection