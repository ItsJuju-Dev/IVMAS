<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>@yield('title', 'Owner')</title>

<!-- ===== LIBRARIES ===== -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<script src="https://unpkg.com/lucide@latest"></script>
<style>
:root {
    --nav-gradient: linear-gradient(180deg, #4A3728, #2F241B);

    --nav-border: rgba(255,255,255,0.08);

    --bg-main: #F5EEDD;
    --bg-card: #FFF9F0;

    --text-primary: #4A3728;
    --text-secondary: #7A6757;

    --shadow-soft: 0 8px 30px rgba(74,55,40,0.10);

    --nav-height: 72px;
}

/* ===== RESET ===== */
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

/* ===== LAYOUT ===== */
.wrapper {
    display: flex;
    min-height: 100vh;
}

/* ===== SIDEBAR ===== */
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

.sidebar-logo {
    height: 52px;
    width: auto;

    object-fit: contain;

    transition: 0.25s ease;
}

.sidebar-logo:hover {
    transform: scale(1.03);
}

/* ===== MENU ===== */
.sidebar-menu {
    display: flex;
    flex-direction: column;
    padding-top: 18px;
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
    background: rgba(255,255,255,0.08);

    transform: translateX(4px);

    color: #fff;
}

.menu-item.active {
    background: #F5EEDD;

    color: #4A3728;

    font-weight: 600;

    box-shadow: 0 8px 24px rgba(0,0,0,0.12);

    transform: translateX(6px);
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

    padding: 0 28px;

    background: rgba(74,55,40,0.92);

    backdrop-filter: blur(14px);

    border-bottom: 1px solid rgba(255,255,255,0.06);
}

.user-info {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #fff;
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
    background: rgba(255,255,255,0.08);

    color: #FFF9F0;

    border: 1px solid rgba(255,255,255,0.08);

    padding: 10px 16px;

    border-radius: 14px;

    cursor: pointer;

    font-weight: 600;

    transition: all 0.25s ease;
}

.logout-btn:hover {
    background: rgba(255,255,255,0.16);

    transform: translateY(-2px);
}

/* ===== CONTENT ===== */
.content {
    padding: 32px;

    max-width: 1600px;
}

/* ===== COMMON UI ===== */
.page-title {
    font-size: 38px;

    font-family: 'Playfair Display', serif;

    font-weight: 600;

    color: var(--text-primary);

    margin-bottom: 28px;

    letter-spacing: 0.5px;
}

/* ===== CARD ===== */
.card {
    background: var(--bg-card);

    border-radius: 24px;

    padding: 22px;

    margin-bottom: 18px;

    border: 1px solid #E8DDCC;

    box-shadow: var(--shadow-soft);

    transition: 0.2s ease;

    transform: translateY(0);
}

.card:hover {
    transform: translateY(-3px);

    box-shadow: 0 14px 40px rgba(74,55,40,0.14);
}

.card h3,
.card h4 {
    margin-top: 0;

    color: var(--text-secondary);

    font-size: 15px;

    font-weight: 500;

    letter-spacing: 0.3px;
}

.indicator-value,
.kpi-value {
    font-size: 42px;

    font-weight: 600;

    color: var(--text-primary);

    margin-top: 10px;
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
    height: 300px;
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
</head>

<body>

<div class="wrapper">

    <!-- ===== SIDEBAR ===== -->
    <aside class="sidebar">
       <div class="sidebar-brand">
            <img src="{{ asset('images/INNerpeaceLogoLogin.png') }}"
                alt="IVMAS Logo"
                class="sidebar-logo">
        </div>

        <nav class="sidebar-menu">

            <a href="{{ route('owner.dashboard') }}"
            class="menu-item {{ request()->is('owner') ? 'active' : '' }} flex items-center gap-3">

                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>

                <span>Dashboard</span>
            </a>

            <a href="{{ route('owner.calendar') }}"
            class="menu-item {{ request()->is('owner/calendar') ? 'active' : '' }} flex items-center gap-3">

                <i data-lucide="calendar-days" class="w-5 h-5"></i>

                <span>Calendar</span>
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
<script>
    lucide.createIcons();
</script>
</body>
</html>