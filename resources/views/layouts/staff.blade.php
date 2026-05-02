<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>@yield('title', 'Staff')</title>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

<style>
:root {
    --nav-gradient: linear-gradient(180deg, #0f172a, #020617);
    --nav-border: rgba(255,255,255,0.08);
    --nav-height: 64px;
}

* {
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

html, body {
    margin: 0;
    padding: 0;
    background: #f4f6f8;
}

.wrapper {
    display: flex;
    min-height: 100vh;
}

.sidebar {
    width: 240px;
    min-height: 100vh;
    background: linear-gradient(180deg, #0f172a, #020617);
    color: #e5e7eb;
}

.sidebar-brand {
    height: var(--nav-height);
    display: flex;
    align-items: center;
    padding: 0 20px;
    background: var(--nav-gradient);
    border-bottom: 1px solid var(--nav-border);
}

.brand-logo {
    font-size: 20px;
    font-weight: 700;
    letter-spacing: 1px;
}

.sidebar-menu {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.menu-item {
    display: flex;
    align-items: center;
    padding: 12px 20px;
    color: #cbd5f5;
    text-decoration: none;
    font-size: 14px;
}

.menu-item:hover {
    background: rgba(255,255,255,0.06);
    color: #ffffff;
}

.menu-item.active {
    background: #1e40af;
    color: #ffffff;
}

.main {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.topbar {
    height: var(--nav-height);
    display: flex;
    align-items: center;
    justify-content: right;
    padding: 0 24px;
    background: var(--nav-gradient);
    border-bottom: 1px solid var(--nav-border);
}

.user-info {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #ffffff;
}

.avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #2563eb;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}

.logout-btn {
    background: linear-gradient(180deg, #0f172a, #020617);
    color: #fff;
    border: none;
    padding: 6px 12px;
    border-radius: 6px;
    cursor: pointer;
}

.logout-btn:hover {
    background: #1e40af;
}

.content {
    padding: 32px;
}

/* ===== BOOKINGS PAGE ===== */

.add-btn {
    display: inline-block;
    margin-bottom: 16px;
    padding: 8px 14px;
    background: #2563eb;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-size: 14px;
}

.add-btn:hover {
    background: #1e40af;
}

.booking-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 8px;
    overflow: hidden;
}

.booking-table th {
    background: #f1f5f9;
    text-align: left;
    padding: 10px;
    font-size: 14px;
}

.booking-table td {
    padding: 10px;
    border-top: 1px solid #e5e7eb;
    font-size: 14px;
}

.booking-table tr:hover {
    background: #f9fafb;
}

.edit-btn {
    padding: 5px 10px;
    background: #f59e0b;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    font-size: 12px;
}

.delete-btn {
    padding: 5px 10px;
    background: #dc2626;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 12px;
    cursor: pointer;
}

.delete-btn:hover {
    background: #b91c1c;
}

/* ===== FORM ===== */

.form-card {
    background: white;
    padding: 24px;
    border-radius: 8px;
    max-width: 500px;
}

.form-group {
    margin-bottom: 16px;
    display: flex;
    flex-direction: column;
}

.form-group label {
    font-size: 14px;
    margin-bottom: 4px;
}

.form-group input,
.form-group select {
    padding: 8px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
}

.save-btn {
    padding: 10px 16px;
    background: #2563eb;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

.save-btn:hover {
    background: #1e40af;
}

.modal-overlay
{
    position: fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background: rgba(0,0,0,0.45);
    display:flex;
    align-items:center;
    justify-content:center;
}

.modal-box
{
    background:#fff;
    padding:30px;
    border-radius:12px;
    width:400px;
    text-align:center;
}

.modal-actions
{
    margin-top:20px;
    display:flex;
    justify-content:center;
    gap:12px;
}

.calendar-modal-overlay {
    position: fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background: rgba(0,0,0,0.45);
    display:flex;
    align-items:center;
    justify-content:center;
    z-index: 9999;
}

.calendar-modal-box {
    background:#fff;
    padding:30px;
    border-radius:12px;
    width:400px;
}

.calendar-modal-actions {
    margin-top:20px;
    display:flex;
    justify-content:center;
    gap:12px;
}

.calendar-hidden {
    display:none;
}

.btn-delete
{
    background:#dc2626;
    color:white;
    border:none;
    padding:8px 16px;
    border-radius:6px;
}

.btn-cancel
{
    background:#e5e7eb;
    border:none;
    padding:8px 16px;
    border-radius:6px;
}

/* Status Badge */
.status {
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    color: white;
}

/* Status Colors */

.status.pending {
    background: #facc15;   /* yellow */
    color: #000;
}

.status.confirmed {
    background: #3b82f6;   /* blue */
}

.status.checked_in {
    background: #22c55e;   /* green */
}

.status.checked_out {
    background: #6b7280;   /* gray */
}

.status.cancelled {
    background: #ef4444;   /* red */
}

.fc-daygrid-event {
    z-index: 10;
    position: relative;
    pointer-events: auto;
}

.fc-daygrid-day-frame {
    cursor: pointer;
    pointer-events: auto;
}

.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    margin-bottom: 30px;
}

.dashboard-card {
    padding: 25px;
    border-radius: 12px;
    color: #fff;
}

.dashboard-card h2 {
    font-size: 32px;
    margin-top: 10px;
}

/* Colors (match your system vibe) */
.dashboard-card.blue {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
}

.dashboard-card.green {
    background: linear-gradient(135deg, #10b981, #059669);
}

.dashboard-card.orange {
    background: linear-gradient(135deg, #f59e0b, #d97706);
}

.dashboard-card.purple {
    background: linear-gradient(135deg, #8b5cf6, #6d28d9);
}

.dashboard-placeholder {
    border: 2px dashed #ccc;
    padding: 30px;
    text-align: center;
    border-radius: 12px;
    color: #666;
}
</style>
</head>

<body>

<div class="wrapper">

<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="sidebar-brand">
        <span class="brand-logo">IVMAS</span>
    </div>

    <nav class="sidebar-menu">

        <a href="{{ route('staff.dashboard') }}"
           class="menu-item {{ request()->is('staff') ? 'active' : '' }}">
            Dashboard
        </a>

        <a href="{{ route('staff.bookings.index') }}"
           class="menu-item {{ request()->is('staff/bookings*') ? 'active' : '' }}">
            Manage Bookings
        </a>

        <a href="{{ route('staff.calendar') }}"
            class="menu-item {{ request()->is('staff/calendar') ? 'active' : '' }}">
            Calendar
        </a>

    </nav>
</aside>

<!-- MAIN -->
<div class="main">

<!-- TOP BAR -->
<header class="topbar">

    <div class="user-info">

        <div class="avatar">
            {{ strtoupper(substr(Auth::user()->name,0,1)) }}
        </div>

        <span>{{ Auth::user()->name }}</span>

    </div>

    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
        @csrf
        <button type="submit" class="logout-btn">
            Logout
        </button>
    </form>

</header>

<!-- PAGE CONTENT -->
<main class="content">
    @yield('content')
</main>

</div>
</div>

<!-- ===== PAGE SCRIPTS ===== -->
@yield('scripts')

</body>
</html>