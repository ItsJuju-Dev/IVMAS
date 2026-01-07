<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>@yield('title', 'Admin')</title>

<style>
:root {
    --nav-gradient: linear-gradient(180deg, #0f172a, #020617);
    --nav-border: rgba(255,255,255,0.08);
    --nav-height: 64px;
}

/* ================= RESET ================= */
* {
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

html, body {
    margin: 0;
    padding: 0;
    background: #f4f6f8;
}

/* ================= LAYOUT ================= */
.wrapper {
    display: flex;
    min-height: 100vh;
}

/* ===== SIDEBAR ===== */
.sidebar {
    width: 240px;
    min-height: 100vh;
    background: linear-gradient(180deg, #0f172a, #020617);
    color: #e5e7eb;
}

/* Brand */
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

/* Menu */
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

/* ================= MAIN ================= */
.main {
    flex: 1;
    display: flex;
    flex-direction: column;
}

/* ================= TOP BAR ================= */
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

/* ================= CONTENT ================= */
.content {
    padding: 32px;
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
            <a href="{{ route('admin.dashboard') }}"
               class="menu-item {{ request()->is('admin') ? 'active' : '' }}">
                Dashboard
            </a>

            <a href="{{ route('admin.users.index') }}"
               class="menu-item {{ request()->is('admin/users*') ? 'active' : '' }}">
                User Management
            </a>

            <a href="{{ route('admin.rooms.index') }}"
               class="menu-item {{ request()->is('admin/rooms*') ? 'active' : '' }}">
                Room Management
            </a>
        </nav>
    </aside>

    <!-- MAIN -->
    <div class="main">

        <!-- TOP BAR -->
        <header class="topbar">
            <div class="user-info">
                <div class="avatar">A</div>
                <span>Admin User</span>
            </div>

            <button class="logout-btn"
                onclick="alert('Logout feature coming soon')">
                Logout
            </button>
        </header>

        <!-- PAGE CONTENT -->
        <main class="content">
            @yield('content')
        </main>

    </div>
</div>

</body>
</html>
