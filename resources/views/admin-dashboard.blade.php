<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>

<style>
:root {
    --nav-gradient: linear-gradient(180deg, #0f172a, #020617);
    --nav-border: rgba(255,255,255,0.08);
    --nav-height: 64px
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

.sidebar-brand h1 {
    font-size: 18px;   /* keep strong */
    margin: 0;
    letter-spacing: 0.5px;
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
    gap: 12px;
    padding: 12px 20px;
    color: #cbd5f5;
    text-decoration: none;
    font-size: 14px;
}

.menu-item .icon {
    width: 20px;
    text-align: center;
    opacity: 0.9;
}

/* Hover */
.menu-item:hover {
    background: rgba(255,255,255,0.06);
    color: #ffffff;
}

/* Active */
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


/* LEFT USER INFO */
.user-info {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #ffffff;
    padding-right: 10px;
}

/* Avatar */
.avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #2563eb;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}

/* LOGOUT BUTTON */
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

/* ================= GRID ================= */
.grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
}

/* ================= ACTION CARD ================= */
.action-card {
    border-radius: 14px;
    padding: 40px;
    color: #fff;
    text-decoration: none;
    font-size: 22px;
    font-weight: bold;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 160px;
    transition: transform 0.2s, box-shadow 0.2s;
}

.action-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.15);
}

/* Card Colors */
.card-users {
    background: linear-gradient(135deg, #2563eb, #1e40af);
}

.card-rooms {
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
    margin-top: 32px;   /* space from action cards */
    padding: 24px;
    text-align: center;
    border: 2px dashed #e5e7eb;
    border-radius: 12px;
    color: #64748b;
    font-size: 14px;
}


</style>
</head>

<body>

<div class="wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <span class="brand-logo">IVMAS</span>
        </div>

        <nav class="sidebar-menu">
            <a href="/admin/dashboard" class="menu-item active">
                <span>Dashboard</span>
            </a>

            <a href="/admin/users" class="menu-item">
                <span>User Management</span>
            </a>

            <a href="/admin/rooms" class="menu-item">
                <span>Room Management</span>
            </a>

        </nav>
    </div>


    <!-- MAIN -->
    <div class="main">

        <!-- TOP BAR -->
        <div class="topbar">

            <!-- LEFT: USER -->
            <div class="user-info">
                <div class="avatar">A</div>
                <span>Admin User</span>
            </div>

            <!-- RIGHT: LOGOUT -->
            <button class="logout-btn"
                onclick="alert('Logout feature coming soon')">
                Logout
            </button>

        </div>

        <!-- CONTENT -->
        <div class="content">
            <div class="section-header">
                <h2>Primary Administration Actions</h2>
                <p>
                    Select a module to manage system configuration and access control.
                </p>
            </div>
            <div class="grid">

                <a href="{{ route('admin.users.index') }}" class="action-card card-users">
                    Manage Users
                </a>

                <a href="#" class="action-card card-rooms">
                    Manage Rooms
                </a>

            </div>
            <div class="card empty-state">
                <p>
                    Additional system modules will appear here as the system expands.
                </p>
            </div>

        </div>

    </div>
</div>

</body>
</html>