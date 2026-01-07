@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')

<style>
/* ================= GRID ================= */
.grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
}

/* ================= DASHBOARD STATS ================= */

.stats-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
}

.stat-card {
    border-radius: 14px;
    padding: 32px;
    color: #ffffff;
    display: flex;
    flex-direction: column;
    justify-content: center;
    min-height: 160px;
    transition: transform 0.2s, box-shadow 0.2s;
}

.stat-label {
    font-size: 14px;
    opacity: 0.85;
    margin-bottom: 6px;
}

.stat-value {
    font-size: 36px;
    font-weight: 700;
}

/* Color variants */
.stat-users {
    background: linear-gradient(135deg, #2563eb, #1e40af);
}

.stat-rooms {
    background: linear-gradient(135deg, #059669, #047857);
}


/* ================= SECTION HEADER ================= */
.section-header {
    text-align: center;
    margin-bottom: 32px;
}

.section-header h2 {
    margin: 0;
    font-size: 22px;
}

.section-header p {
    margin-top: 6px;
    font-size: 14px;
    color: #64748b;
}

/* ================= EMPTY STATE ================= */
.empty-state {
    margin-top: 32px;
    padding: 24px;
    text-align: center;
    border: 2px dashed #e5e7eb;
    border-radius: 12px;
    color: #64748b;
    font-size: 14px;
}
</style>

<div class="section-header">
    <h2>IVMAS Admin Dashboard</h2>
    <p>
        System overview and key statistics
    </p>
</div>

<div class="stats-grid">

    <div class="stat-card stat-users">
        <div class="stat-label">Total Users</div>
        <div class="stat-value">{{ $userCount }}</div>
    </div>

    <div class="stat-card stat-rooms">
        <div class="stat-label">Total Rooms</div>
        <div class="stat-value">{{ $roomCount }}</div>
    </div>

</div>

<div class="empty-state">
    <p>
        Additional system modules will appear here as the system expands.
    </p>
</div>

@endsection
