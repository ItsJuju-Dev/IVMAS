@extends('layouts.staff')

@section('title', 'Staff Dashboard')

@section('content')

<style>
/* ================= DASHBOARD ================= */

.stats-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 28px;
}

.stat-card {
    position: relative;

    background: #F9F5EC;

    border-radius: 28px;

    padding: 28px;

    min-height: 140px;

    overflow: hidden;

    border: 1px solid #E8DDCC;

    box-shadow:
        0 10px 30px rgba(74,55,40,0.08);

    transition:
        transform 0.25s ease,
        box-shadow 0.25s ease;
}

.stat-card:hover {
    transform: translateY(-4px);

    box-shadow:
        0 16px 40px rgba(74,55,40,0.12);
}

.stat-icon {
    position: absolute;

    top: 28px;
    right: 28px;

    color: #556B2F;

    opacity: 0.16;
}

.stat-label {
    font-size: 15px;

    color: #7A6855;

    margin-bottom: 14px;
}

.stat-value {
    font-size: 56px;

    font-weight: 700;

    color: #4A3728;
}

/* ================= HEADER ================= */

.section-header {
    margin-bottom: 36px;
}

.section-header h2 {
    margin: 0;

    font-size: 54px;

    color: #4A3728;
}

/* ================= EMPTY STATE ================= */

.empty-state {
    margin-top: 36px;

    background: #F9F5EC;

    border-radius: 28px;

    border: 2px dashed #DDD2BF;

    padding: 42px;

    text-align: center;

    color: #7A6855;

    box-shadow:
        0 10px 30px rgba(74,55,40,0.05);
}
</style>

<div class="section-header">
    <h2>Staff Dashboard</h2>
</div>

<div class="stats-grid">

    <!-- TOTAL BOOKINGS -->
    <div class="stat-card">

        <div class="stat-icon">
            <i data-lucide="clipboard-list"
               style="width:64px; height:64px;"></i>
        </div>

        <div class="stat-label">
            Total Bookings
        </div>

        <div class="stat-value">
            {{ $totalBookings }}
        </div>

    </div>

    <!-- TODAY CHECK-INS -->
    <div class="stat-card">

        <div class="stat-icon">
            <i data-lucide="log-in"
               style="width:64px; height:64px;"></i>
        </div>

        <div class="stat-label">
            Today's Check-ins
        </div>

        <div class="stat-value">
            {{ $todayCheckIns }}
        </div>

    </div>

    <!-- TODAY CHECK-OUTS -->
    <div class="stat-card">

        <div class="stat-icon">
            <i data-lucide="log-out"
               style="width:64px; height:64px;"></i>
        </div>

        <div class="stat-label">
            Today's Check-outs
        </div>

        <div class="stat-value">
            {{ $todayCheckOuts }}
        </div>

    </div>

    <!-- OCCUPIED ROOMS -->
    <div class="stat-card">

        <div class="stat-icon">
            <i data-lucide="bed-double"
               style="width:64px; height:64px;"></i>
        </div>

        <div class="stat-label">
            Occupied Rooms
        </div>

        <div class="stat-value">
            {{ $occupiedRooms }} / {{ $totalRooms }}
        </div>

    </div>

</div>

<div class="empty-state">

    <h3 style="margin-top:0;color:#4A3728;">
        Quick Actions
    </h3>

    <div style="
        display:flex;
        gap:16px;
        justify-content:center;
        flex-wrap:wrap;
        margin-top:24px;
    ">

        <a href="{{ route('staff.bookings.index') }}"
           style="
            background:#5B4332;
            color:white;
            padding:12px 22px;
            border-radius:14px;
            text-decoration:none;
            font-weight:600;
           ">
            Manage Bookings
        </a>

        <a href="{{ route('staff.calendar') }}"
           style="
            background:#5B4332;
            color:white;
            padding:12px 22px;
            border-radius:14px;
            text-decoration:none;
            font-weight:600;
           ">
            View Calendar
        </a>

    </div>

</div>

@endsection