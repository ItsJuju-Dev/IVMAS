<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>@yield('title', 'Owner')</title>

<!-- ===== LIBRARIES ===== -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

<style>
:root {
    --nav-gradient: linear-gradient(180deg, #0f172a, #020617);
    --nav-border: rgba(255,255,255,0.08);
    --nav-height: 64px;
}

/* ===== RESET ===== */
* {
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

html, body {
    margin: 0;
    padding: 0;
    background: #f4f6f8;
}

/* ===== LAYOUT ===== */
.wrapper {
    display: flex;
    min-height: 100vh;
}

/* ===== SIDEBAR ===== */
.sidebar {
    width: 240px;
    min-height: 100vh;
    background: var(--nav-gradient);
    color: #e5e7eb;
}

.sidebar-brand {
    height: var(--nav-height);
    display: flex;
    align-items: center;
    padding: 0 20px;
    border-bottom: 1px solid var(--nav-border);
}

.brand-logo {
    font-size: 20px;
    font-weight: 700;
}

/* ===== MENU ===== */
.sidebar-menu {
    display: flex;
    flex-direction: column;
}

.menu-item {
    padding: 12px 20px;
    color: #cbd5e1;
    text-decoration: none;
    font-size: 14px;
}

.menu-item:hover {
    background: rgba(255,255,255,0.06);
    color: #fff;
}

.menu-item.active {
    background: #1e40af;
    color: #fff;
}

/* ===== MAIN ===== */
.main {
    flex: 1;
    display: flex;
    flex-direction: column;
}

/* ===== TOPBAR ===== */
.topbar {
    height: var(--nav-height);
    display: flex;
    justify-content: flex-end;
    align-items: center;
    padding: 0 24px;
    background: var(--nav-gradient);
    border-bottom: 1px solid var(--nav-border);
}

.user-info {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #fff;
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
    background: #020617;
    color: #fff;
    border: none;
    padding: 6px 12px;
    border-radius: 6px;
    cursor: pointer;
}

.logout-btn:hover {
    background: #1e40af;
}

/* ===== CONTENT ===== */
.content {
    padding: 24px;
}

/* ===== COMMON UI ===== */
.page-title {
    font-size: 22px;
    margin-bottom: 20px;
}

/* ===== CARD ===== */
.card {
    background: #fff;
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 16px;
}

/* ===== GRID ===== */
.grid {
    display: grid;
    grid-template-columns: 68% 32%;
    gap: 14px;
}

.kpi {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}

.top-actions {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}

/* ===== CHART ===== */
.chart-card {
    height: 320px;
    display: flex;
    flex-direction: column;
}

.chart-body {
    position: relative;
    flex: 1;
}

.chart-body canvas {
    position: absolute;
    inset: 0;
    width: 100% !important;
    height: 100% !important;
}

/* ===== INDICATOR ===== */
.indicator-card {
    height: 200px;
}

.indicator-value {
    font-size: 26px;
    font-weight: bold;
}

.indicator-delta.up { color: #16a34a; }
.indicator-delta.down { color: #dc2626; }

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">

.fc-daygrid-event {
    z-index: 10;
    position: relative;
    pointer-events: auto;
}

.fc-daygrid-day-frame {
    cursor: pointer;
}

/* Your custom colors */
.fc-event {
    border: none;
    padding: 2px 4px;
    font-size: 12px;
    border-radius: 4px;
}

.fc-event-title {
    font-weight: 500;
}

/* Modal styling */
.calendar-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;

    background: rgba(0,0,0,0.5);

    display: flex;
    justify-content: center;
    align-items: center;

    z-index: 9999; 
}

.calendar-modal-box {
    background: white;
    padding: 20px;
    border-radius: 10px;
    width: 400px;

    position: relative;
    z-index: 10000; 
}

.calendar-hidden {
    display: none;
}
</style>
</style>
</head>

<body>

<div class="wrapper">

    <!-- ===== SIDEBAR ===== -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <span class="brand-logo">IVMAS</span>
        </div>

        <nav class="sidebar-menu">

            <a href="{{ route('owner.dashboard') }}"
               class="menu-item {{ request()->is('owner/dashboard') ? 'active' : '' }}">
                Dashboard
            </a>

            <a href="{{ route('owner.calendar') }}"
               class="menu-item {{ request()->is('owner/calendar') ? 'active' : '' }}">
                Calendar
            </a>

        </nav>
    </aside>

    <!-- ===== MAIN ===== -->
    <div class="main">

        <!-- ===== TOPBAR ===== -->
        <header class="topbar">
            <div class="user-info">
                <div class="avatar">O</div>
                <span>{{ auth()->user()->name ?? 'Owner User' }}</span>
            </div>

            <form method="POST" action="{{ route('logout') }}" style="margin-left:10px;">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </header>

        <!-- ===== CONTENT ===== -->
        <main class="content">
            @yield('content')
        </main>

    </div>
</div>

<!-- ===== PAGE SCRIPTS ===== -->
@yield('scripts')

</body>
</html>