@extends('layouts.staff')

@section('title', 'Staff Dashboard')

@section('content')

<h2 class="page-title">Staff Dashboard</h2>

<div class="dashboard-grid">

    <!-- Total Bookings -->
    <div class="dashboard-card blue">
        <p>Total Bookings</p>
        <h2>{{ $totalBookings }}</h2>
    </div>

    <!-- Today Check-ins -->
    <div class="dashboard-card green">
        <p>Today's Check-ins</p>
        <h2>{{ $todayCheckIns }}</h2>
    </div>

    <!-- Today Check-outs -->
    <div class="dashboard-card orange">
        <p>Today's Check-outs</p>
        <h2>{{ $todayCheckOuts }}</h2>
    </div>

    <!-- Occupied Rooms -->
    <div class="dashboard-card purple">
        <p>Occupied Rooms</p>
        <h2>{{ $occupiedRooms }} / {{ $totalRooms }}</h2>
    </div>

</div>


<!-- Optional Section -->
<div class="dashboard-placeholder">
    <p>More analytics and insights can be added here (e.g., recent bookings, revenue, occupancy trends).</p>
</div>

@endsection