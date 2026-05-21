@extends('layouts.owner')

@section('title', 'Owner Dashboard')

@section('content')

<div class="content">
    <h2 class="page-title">Owner Dashboard</h2>

    <!-- ===== KPI CARDS ===== -->
    <div class="kpi-grid">
        <div class="kpi-card">

            <div class="kpi-header">

                <h4>Total Bookings</h4>

                <div class="kpi-icon">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>

            </div>

            <p class="kpi-value">
                {{ $totalBookings ?? 0 }}
            </p>

        </div>

        <div class="kpi-card">

            <div class="kpi-header">

                <h4>Occupancy Rate</h4>

                <div class="kpi-icon">
                    <i class="fa-solid fa-bed"></i>
                </div>

            </div>

            <p class="kpi-value">
                {{ $occupancyRate ?? 0 }}%
            </p>

        </div>

        <div class="kpi-card">

            <div class="kpi-header">

                <h4>Total Revenue</h4>

                <div class="kpi-icon">
                    <i class="fa-solid fa-wallet"></i>
                </div>

            </div>

            <p class="kpi-value">
                Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}
            </p>

        </div>

        <div class="kpi-card">

            <div class="kpi-header">

                <h4>Avg Stay</h4>

                <div class="kpi-icon">
                    <i class="fa-solid fa-clock"></i>
                </div>

            </div>

            <p class="kpi-value">
                {{ $avgStay ?? 0 }} days
            </p>

        </div>

        <div class="kpi-card">

            <div class="kpi-header">

                <h4>Bookings Forecast</h4>

                <div class="kpi-icon">
                    <i class="fa-solid fa-chart-line"></i>
                </div>

            </div>

            <p class="kpi-value">
                {{ round($nextBookingForecast ?? 0) }}
            </p>

        </div>

        <div class="kpi-card">

            <div class="kpi-header">

                <h4>Revenue Forecast</h4>

                <div class="kpi-icon">
                    <i class="fa-solid fa-sack-dollar"></i>
                </div>

            </div>

            <p class="kpi-value">
                Rp {{ number_format($nextRevenueForecast ?? 0, 0, ',', '.') }}
            </p>

        </div>
    </div>

    <!-- ===== MAIN GRID ===== -->
    <div class="dashboard-grid">

        <!-- Booking Trend -->
        <div class="card chart-card">
            <h4>Booking Trend & Forecast</h4>
            <div class="chart-container">
            <canvas id="bookingChart"></canvas>
            </div>
        </div>

        <!-- Insights -->
        <div class="card">
            <h4>Insights</h4>
            <ul class="insights-list">
                @forelse($insights as $insight)
                    <li>{{ $insight }}</li>
                @empty
                    <li>No insights available</li>
                @endforelse
            </ul>
        </div>

        <!-- Revenue Trend -->
        <div class="card chart-card">
            <h4>Revenue Trend & Forecast</h4>
            <div class="chart-container">
            <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Room Performance -->
        <div class="card">

            <h4>Room Performance</h4>

            <div class="room-performance">

                <div class="room-stat">

                    <span class="room-label">
                        Highest Revenue Room
                    </span>

                    <span class="room-value">
                        {{ $topRevenueRoom->room->name ?? 'N/A' }}
                    </span>

                </div>

                <div class="room-stat">

                    <span class="room-label">
                        Most Booked Room
                    </span>

                    <span class="room-value">
                        {{ $mostBookedRoom->room->name ?? 'N/A' }}
                    </span>

                </div>

                <div class="room-stat">

                    <span class="room-label">
                        Lowest Performing Room
                    </span>

                    <span class="room-value">
                        {{ $lowestRoom->room->name ?? 'N/A' }}
                    </span>

                </div>

            </div>

        </div>

        <!-- Recommendations -->
        <div class="card">

            <h4>Recommendations</h4>

            <ul class="insights-list">

                @forelse($recommendations as $recommendation)
                    <li>{{ $recommendation }}</li>
                @empty
                    <li>No recommendations available</li>
                @endforelse

            </ul>

        </div>

        <!-- Actions -->
        <div class="card actions-card">

            <h4>Actions</h4>

            <div class="action-buttons">

                <button type="button"
                        onclick="openRoomReportModal()">
                    Generate Report by Room
                </button>

                <button type="button"
                        onclick="openReportModal()">
                    Generate Report by Date
                </button>

                <a href="{{ route('owner.export') }}">
                    <button type="button">
                        Export Booking CSV
                    </button>
                </a>

                <a href="{{ route('owner.export.pdf') }}">
                    <button type="button">
                        Export Booking PDF
                    </button>
                </a>

                <button type="button"
                        onclick="openImportBookingModal()">
                    Import Booking
                </button>

                <button type="button"
                        onclick="openImportAvailabilityModal()">
                    Import Availability
                </button>

            </div>

        </div>

    </div>
</div>

<!-- ===== REPORT MODAL ===== -->
<div id="reportModal" class="modal-overlay" style="display:none;">

    <div class="modal-box">

        <h3>Generate Report</h3>

        <form method="GET" action="{{ route('owner.report') }}">

            <div class="form-group">
                <label>Start Date</label>
                <input type="date" name="start_date" required>
            </div>

            <div class="form-group">
                <label>End Date</label>
                <input type="date" name="end_date" required>
            </div>

            <div class="modal-actions">

                <button type="submit">
                    Generate
                </button>

                <button type="button"
                        class="btn-cancel"
                        onclick="closeReportModal()">
                    Cancel
                </button>

            </div>

        </form>

    </div>

</div>

<!-- ===== IMPORT BOOKING MODAL ===== -->
<div id="importBookingModal" class="modal-overlay" style="display:none;">

    <div class="modal-box">

        <h3>Import Airbnb / External Booking</h3>

        <form method="POST" action="{{ route('owner.import.ical') }}">
            @csrf

            <div class="form-group">

                <label>Select Room</label>

                <select name="room_id" required>

                    @foreach($rooms as $room)

                        <option value="{{ $room->id }}">
                            {{ $room->name }}
                        </option>

                    @endforeach

                </select>

            </div>

            <div class="form-group">

                <label>iCal URL</label>

                <input type="text"
                       name="ical_url"
                       placeholder="Paste iCal URL"
                       required>

            </div>

            <div class="modal-actions">

                <button type="submit">
                    Import
                </button>

                <button type="button"
                        class="btn-cancel"
                        onclick="closeImportBookingModal()">
                    Cancel
                </button>

            </div>

        </form>

    </div>

</div>

<!-- ===== IMPORT AVAILABILITY MODAL ===== -->
<div id="importAvailabilityModal" class="modal-overlay" style="display:none;">

    <div class="modal-box">

        <h3>Import Availability</h3>

        <form method="POST"
              action="{{ route('owner.import.availability') }}">

            @csrf

            <div class="form-group">

                <label>iCal URL</label>

                <input type="text"
                       name="ical_url"
                       placeholder="Paste iCal URL"
                       required>

            </div>

            <div class="modal-actions">

                <button type="submit">
                    Import Availability
                </button>

                <button type="button"
                        class="btn-cancel"
                        onclick="closeImportAvailabilityModal()">
                    Cancel
                </button>

            </div>

        </form>

    </div>

</div>

<!-- ===== ROOM REPORT MODAL ===== -->
<div id="roomReportModal" class="modal-overlay" style="display:none;">

    <div class="modal-box">

        <h3>Generate Report by Room</h3>

        <form method="GET" action="{{ route('owner.report.room') }}">

            <div class="form-group">

                <label>Select Room</label>

                <select name="room_id" required>

                    @foreach($rooms as $room)

                        <option value="{{ $room->id }}">
                            {{ $room->name }}
                        </option>

                    @endforeach

                </select>

            </div>

            <div class="modal-actions">

                <button type="submit">
                    Generate
                </button>

                <button type="button"
                        class="btn-cancel"
                        onclick="closeRoomReportModal()">
                    Cancel
                </button>

            </div>

        </form>

    </div>

</div>

<!-- ===== CHART JS ===== -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    // ===== BOOKING CHART =====
    const bookingCtx = document.getElementById('bookingChart');

    new Chart(bookingCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($bookingLabels) !!},
            datasets: [
                {
                    label: 'Actual',
                    data: {!! json_encode($bookingData) !!},
                    borderColor: '#556B2F',
                    backgroundColor: 'rgba(85,107,47,0.15)',
                    borderWidth: 3,
                    pointRadius: 4,
                    pointBackgroundColor: '#556B2F',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Forecast',
                    data: {!! json_encode($bookingForecast) !!},
                    borderColor: '#A3B18A',
                    backgroundColor: 'rgba(163,177,138,0.12)',
                    borderWidth: 3,
                    pointRadius: 4,
                    pointBackgroundColor: '#A3B18A',
                    borderDash: [8,6],
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
        responsive: true,
        maintainAspectRatio: false,
    }
    });

    // ===== REVENUE CHART =====
    const revenueCtx = document.getElementById('revenueChart');

    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($revenueLabels) !!},
            datasets: [
                {
                    label: 'Actual',
                    data: {!! json_encode($revenueData) !!},
                    borderColor: '#556B2F',
                    backgroundColor: 'rgba(85,107,47,0.15)',
                    borderWidth: 3,
                    pointRadius: 4,
                    pointBackgroundColor: '#556B2F',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Forecast',
                    data: {!! json_encode($revenueForecast) !!},
                    borderColor: '#A3B18A',
                    backgroundColor: 'rgba(163,177,138,0.12)',
                    borderWidth: 3,
                    pointRadius: 4,
                    pointBackgroundColor: '#A3B18A',
                    borderDash: [8,6],
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
        responsive: true,
        maintainAspectRatio: false,
    }
    });



});

    function comingSoon() {
    alert(" Report generation is under development and will be available soon.");
}

// ===== REPORT MODAL =====
function openReportModal()
{
    document.getElementById('reportModal').style.display = 'flex';
}

function closeReportModal()
{
    document.getElementById('reportModal').style.display = 'none';
}

// ===== IMPORT BOOKING MODAL =====
function openImportBookingModal()
{
    document.getElementById('importBookingModal').style.display = 'flex';
}

function closeImportBookingModal()
{
    document.getElementById('importBookingModal').style.display = 'none';
}

// ===== IMPORT AVAILABILITY MODAL =====
function openImportAvailabilityModal()
{
    document.getElementById('importAvailabilityModal').style.display = 'flex';
}

function closeImportAvailabilityModal()
{
    document.getElementById('importAvailabilityModal').style.display = 'none';
}

// ===== ROOM REPORT MODAL =====
function openRoomReportModal()
{
    document.getElementById('roomReportModal').style.display = 'flex';
}

function closeRoomReportModal()
{
    document.getElementById('roomReportModal').style.display = 'none';
}
</script>

<!-- ===== STYLES ===== -->
<style>
.kpi-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 20px;
}

.kpi-card {
    background: rgba(255,255,255,0.55);

    backdrop-filter: blur(10px);

    padding: 26px;

    border-radius: 24px;

    border: 1px solid rgba(255,255,255,0.4);

    box-shadow: 0 8px 30px rgba(74,55,40,0.08);

    transition: all 0.25s ease;
}

.kpi-card:hover {
    transform: translateY(-4px);

    box-shadow: 0 16px 40px rgba(74,55,40,0.12);
}

.kpi-card h4 {
    color: #7A6857;

    font-size: 15px;

    font-weight: 500;

    margin-bottom: 16px;
}

.kpi-value {
    font-size: 38px;

    font-weight: 700;

    color: #4A3728;

    line-height: 1.1;
}

.kpi-header
{
    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:18px;
}

.kpi-icon
{
    width:52px;
    height:52px;

    border-radius:16px;

    background:rgba(74,55,40,0.08);

    display:flex;

    align-items:center;
    justify-content:center;

    color:#4A3728;

    font-size:22px;
}

.dashboard-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 16px;
    align-items: stretch; /* ⭐ important */
}

.card {
    background: rgba(255,255,255,0.45);

    backdrop-filter: blur(8px);

    border-radius: 28px;

    padding: 24px;

    border: 1px solid rgba(255,255,255,0.35);

    box-shadow: 0 8px 30px rgba(74,55,40,0.08);

    transition: all 0.25s ease;
}

.card:hover {
    transform: translateY(-3px);

    box-shadow: 0 16px 40px rgba(74,55,40,0.12);
}

.card h4 {
    font-size: 22px;

    font-family: 'Playfair Display', serif;

    color: #4A3728;

    margin-bottom: 20px;

    padding-bottom:12px;

    border-bottom:1px solid #E6DCCF;
}

.chart-card {
    height: 350px;
    display: flex;
    flex-direction: column;
    overflow: hidden; /* ⭐ prevents overflow */
}

.chart-container canvas {
    width: 100% !important;
    height: 100% !important;
}

.chart-container {
    flex: 1;
    position: relative;
    min-height: 0; /* ⭐ CRITICAL FIX */
}

.insights-list
{
    padding-left:24px;

    margin-top:10px;
}

.insights-list li
{
    font-size:18px;

    line-height:1;

    margin-bottom:14px;

    color:#5A4434;

    font-weight:500;
}

button {
    background: #4A3728;

    color: #FFF9F0;

    border: none;

    padding: 12px 22px;

    border-radius: 14px;

    font-weight: 600;

    cursor: pointer;

    transition: all 0.25s ease;
}

button:hover {
    background: #5B4635;

    transform: translateY(-2px);
}

input,
select {
    width: 100%;

    padding: 12px 14px;

    border-radius: 14px;

    border: 1px solid #D8CDBD;

    background: rgba(255,255,255,0.7);

    margin-top: 8px;
}

.actions-card
{
    display:flex;
    flex-direction:column;
    gap:20px;
}

.action-group h5
{
    font-size:16px;
    color:#7A6857;
    margin-bottom:14px;
}

.action-buttons
{
    display:flex;
    flex-direction:column;
    gap:12px;
}

.action-buttons a
{
    width:100%;
}

.action-buttons button
{
    width:100%;
}

.modal-overlay
{
    position:fixed;

    top:0;
    left:0;

    width:100%;
    height:100%;

    background:rgba(0,0,0,0.45);

    display:flex;

    justify-content:center;
    align-items:center;

    z-index:9999;
}

.modal-box
{
    background:#F7F1E7;

    width:420px;

    padding:28px;

    border-radius:24px;

    box-shadow:0 10px 40px rgba(0,0,0,0.15);
}

.modal-box h3
{
    margin-bottom:20px;

    color:#4A3728;
}

.form-group
{
    margin-bottom:18px;
}

.modal-actions
{
    display:flex;
    gap:12px;

    margin-top:20px;
}

.btn-cancel
{
    background:#CBBBA5;
}

.btn-cancel:hover
{
    background:#B9A78F;
}

.room-performance
{
    display:flex;

    flex-direction:column;

    gap:20px;
}

.room-stat
{
    padding-bottom:18px;

    border-bottom:1px solid #E7DED1;
}

.room-stat:last-child
{
    border-bottom:none;

    padding-bottom:0;
}

.room-label
{
    display:block;

    font-size:14px;

    color:#8A7866;

    margin-bottom:8px;
}

.room-value
{
    font-size:28px;

    font-weight:700;

    color:#4A3728;
}
</style>

@endsection