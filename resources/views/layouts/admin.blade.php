<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>@yield('title', 'Admin')</title>

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

/* ================= RESET ================= */
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

/* ================= LAYOUT ================= */
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

/* Brand */
.sidebar-brand {
    height: var(--nav-height);

    display: flex;

    align-items: center;

    justify-content: center;

    padding: 10px 0;

    border-bottom: 1px solid rgba(255,255,255,0.06);
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
            <img src="{{ asset('images/INNerpeaceLogoLogin.png') }}"
            alt="IVMAS Logo"
            style="height: 42px;">
        </div>

        <nav class="sidebar-menu">
            <a href="{{ route('admin.dashboard') }}"
               class="menu-item {{ request()->is('admin') ? 'active' : '' }} flex items-center gap-3">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>

                    Dashboard
            </a>

            <a href="{{ route('admin.users.index') }}"
               class="menu-item {{ request()->is('admin/users*') ? 'active' : '' }} flex items-center gap-3">
                <i data-lucide="users" class="w-5 h-5"></i>

                    User Management
            </a>

            <a href="{{ route('admin.rooms.index') }}"
               class="menu-item {{ request()->is('admin/rooms*') ? 'active' : '' }} flex items-center gap-3">
                <i data-lucide="bed-double" class="w-5 h-5"></i>

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

<script>
    lucide.createIcons();
</script>

</body>
</html>
