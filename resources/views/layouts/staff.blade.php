<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>@yield('title', 'Staff')</title>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
<script src="https://unpkg.com/lucide@latest"></script>

<style>
:root {
    --nav-gradient: linear-gradient(180deg, #6B4F3A, #4A3728);
    --nav-border: rgba(255,255,255,0.08);
    --nav-height: 72px;

    --bg-main: #F5EEDD;
    --card-bg: #F9F5EC;

    --text-primary: #4A3728;
    --text-secondary: #7A6855;

    --olive: #556B2F;
}

* {
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

html, body {
    margin: 0;
    padding: 0;
    background: var(--bg-main);
    color: var(--text-primary);
}

.wrapper {
    display: flex;
    min-height: 100vh;
}

.sidebar {
    width: 260px;
    min-height: 100vh;
    background: rgba(74,55,40,0.92);
    backdrop-filter: blur(14px);
    border-right: 1px solid rgba(255,255,255,0.06);
    color: #e5e7eb;
}

.sidebar-brand {
    height: var(--nav-height);

    display: flex;

    align-items: center;

    justify-content: center;

    padding: 10px 0;

    border-bottom: 1px solid rgba(255,255,255,0.06);
}

.sidebar-menu {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.menu-item {
    display: flex;

    align-items: center;

    gap: 12px;

    margin: 8px 14px;

    padding: 14px 18px;

    border-radius: 18px;

    color: #F5EEDD;

    text-decoration: none;

    font-size: 15px;

    font-weight: 500;

    transition: all 0.25s ease;
}

.menu-item:hover {
    background: rgba(245,238,221,0.08);

    color: #ffffff;

    transition: 0.2s ease;
}

.menu-item.active {
    background: #F5EEDD;

    color: #4A3728;

    font-weight: 600;

    box-shadow: 0 8px 24px rgba(0,0,0,0.12);

    transform: translateX(6px);
}

.main {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.topbar {
    height: var(--nav-height);

    display: flex;

    justify-content: flex-end;

    align-items: center;

    padding: 0 28px;

    background: rgba(74,55,40,0.92);

    backdrop-filter: blur(14px);

    border-bottom: 1px solid rgba(255,255,255,0.06);
}

.user-info {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #ffffff;
}

.avatar {
    width: 40px;

    height: 40px;

    border-radius: 50%;

    background: rgba(255,255,255,0.12);

    color: #FFF9F0;

    display: flex;

    align-items: center;

    justify-content: center;

    font-weight: 600;

    border: 1px solid rgba(255,255,255,0.12);
}

.logout-btn {
    background: rgba(245,238,221,0.12);

    color: #fff;

    border: 1px solid rgba(255,255,255,0.08);

    padding: 8px 16px;

    border-radius: 14px;

    cursor: pointer;

    transition: 0.2s ease;
}

.logout-btn:hover {
    background: rgba(245,238,221,0.22);
}


.content {
    padding: 32px;
}

/* ===== BOOKINGS PAGE ===== */

.add-btn {
    display: inline-block;
    margin-bottom: 16px;
    padding: 10px 18px;
    background: #8b5e3c;
    color: white;
    text-decoration: none;
    border-radius: 14px;
    font-size: 14px;
    font-weight: 600;
    transition: 0.2s ease;
}

.add-btn:hover {
    background: #6f472c;
}

.booking-table {
    width: 100%;
    border-collapse: collapse;
    background: var(--card-bg);
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
    padding: 8px 16px;
    background: #8b5e3c;
    color: white;
    text-decoration: none;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 600;
}

.delete-btn {
    padding: 8px 16px;
    background: #a06b43;
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
}

.delete-btn:hover {
    background: #70492e;
}

/* ===== FORM ===== */

.form-card {
    background: var(--card-bg);
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
    padding: 10px 18px;
    background: #8b5e3c;
    color: white;
    border: none;
    border-radius: 14px;
    cursor: pointer;
    font-weight: 600;
    transition: 0.2s ease;
}

.save-btn:hover {
    background: #6f472c;
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
</style>
</head>

<body>

<div class="wrapper">

<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="sidebar-brand">
        <img src="{{ asset('images/INNerpeaceLogoLogin.png') }}"
        alt="IVMAS Logo"
        style="height: 42px;">
    </div>

    <nav class="sidebar-menu">

        <a href="{{ route('staff.dashboard') }}"
            class="menu-item {{ request()->is('staff') ? 'active' : '' }}">
            <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
            Dashboard
        </a>

        <a href="{{ route('staff.bookings.index') }}"
            class="menu-item {{ request()->is('staff/bookings*') ? 'active' : '' }}">
            <i data-lucide="clipboard-list" class="w-5 h-5"></i>
            Manage Bookings
        </a>

        <a href="{{ route('staff.calendar') }}"
            class="menu-item {{ request()->is('staff/calendar') ? 'active' : '' }}">
            <i data-lucide="calendar-days" class="w-5 h-5"></i>
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

    <form method="POST" action="{{ route('logout') }}" style="margin-left:10px;">
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

<script>
    lucide.createIcons();
</script>

</body>
</html>