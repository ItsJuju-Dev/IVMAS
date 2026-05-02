@extends('layouts.owner')

@section('title', 'Owner Dashboard')

@section('content')

<div class="content">
    <h2 class="page-title">Owner Dashboard</h2>

    <!-- ===== KPI CARDS ===== -->
    <div class="kpi-grid">
        <div class="kpi-card">
            <h4>Total Bookings</h4>
            <p class="kpi-value">{{ $totalBookings ?? 0 }}</p>
        </div>

        <div class="kpi-card">
            <h4>Occupancy Rate</h4>
            <p class="kpi-value">{{ $occupancyRate ?? 0 }}%</p>
        </div>

        <div class="kpi-card">
            <h4>Total Revenue</h4>
            <p class="kpi-value">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</p>
        </div>

        <div class="kpi-card">
            <h4>Avg Stay</h4>
            <p class="kpi-value">{{ $avgStay ?? 0 }} days</p>
        </div>

        <div class="kpi-card">
            <h4>Bookings Forecast</h4>
            <p class="kpi-value">
                {{ round($nextBookingForecast ?? 0) }}
            </p>
        </div>

        <div class="kpi-card">
            <h4>Revenue Forecast</h4>
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

        <!-- Actions -->
        <div class="card">
            <h4>Actions</h4>

            <form method="GET" action="{{ route('owner.report') }}">
                <label>Generate Report</label><br><br>

                <input type="date" name="start_date" required> to 
                <input type="date" name="end_date" required><br><br>

                <button type="submit">Generate</button>
            </form>

            <br>

            <div style="display:flex; flex-direction:column; gap:10px;">
    
                <a href="{{ route('owner.export') }}">
                    <button>Export Booking (CSV)</button>
                </a>

                <a href="{{ route('owner.export.pdf') }}">
                    <button>Export Booking (PDF)</button>
                </a>

            </div>

            <form method="POST" action="{{ route('owner.import.ical') }}">
                @csrf

                <label>Import Airbnb / External Booking (iCal)</label><br></br>

                <label>Select Room</label><br>
                <select name="room_id" required>
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}">
                            {{ $room->name }}
                        </option>
                    @endforeach
                </select>

                <br><br>

                <input type="text" name="ical_url" placeholder="Paste iCal URL" required>

                <br><br>

                <button type="submit">Import</button>
            </form>

            <form method="POST" action="{{ route('owner.import.availability') }}">
                @csrf

                <label>Import Availability (iCal)</label><br><br>

                <input type="text" name="ical_url" placeholder="Paste iCal URL" required>

                <br><br>

                <button type="submit">Import Availability</button>
            </form>
            
        </div>

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
                    tension: 0.3
                },
                {
                    label: 'Forecast',
                    data: {!! json_encode($bookingForecast) !!},
                    borderDash: [5,5],
                    tension: 0.3
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
                    tension: 0.3
                },
                {
                    label: 'Forecast',
                    data: {!! json_encode($revenueForecast) !!},
                    borderDash: [5,5],
                    tension: 0.3
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
    background: #fff;
    padding: 16px;
    border-radius: 10px;
}

.kpi-value {
    font-size: 24px;
    font-weight: bold;
}

.dashboard-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 16px;
    align-items: stretch; /* ⭐ important */
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

.insights-list {
    padding-left: 16px;
}
</style>

@endsection