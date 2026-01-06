<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>IVMAS Owner Dashboard</title>

<!-- ================= LIBRARIES ================= -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

<style>
/* =====================================================
   RESET & BASE
===================================================== */
* {
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

html, body {
    margin: 0;
    padding: 0;
    background: #f4f6f8;
}

/* =====================================================
   HEADER
===================================================== */
.top-header {
    height: 64px;
    background: #020617;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 24px;
    color: #fff;
}

.logo {
    font-size: 20px;
    font-weight: bold;
}

.header-right {
    display: flex;
    align-items: center;
    gap: 12px;
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

/* =====================================================
   LAYOUT
===================================================== */
.wrapper {
    display: flex;
    min-height: calc(100vh - 64px);
}

/* =====================================================
   SIDEBAR
===================================================== */
.sidebar {
    width: 220px;
    background: #020617;
    padding: 16px;
}

.sidebar a {
    display: block;
    color: #cbd5e1;
    text-decoration: none;
    padding: 10px 12px;
    border-radius: 6px;
    margin-bottom: 10px;
    cursor: pointer;
}

.sidebar a.active {
    background: #1e40af;
    color: #fff;
}

/* =====================================================
   MAIN
===================================================== */
.main {
    flex: 1;
    padding: 20px 24px;
    max-width: 1400px;
}

/* =====================================================
   CARD
===================================================== */
.card {
    background: #fff;
    border-radius: 12px;
    padding: 16px 18px;
    margin-bottom: 12px;
}

/* =====================================================
   DASHBOARD LAYOUT
===================================================== */
.top-actions {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}

.kpi {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}

.kpi .value {
    font-size: 32px;
    font-weight: bold;
}

.grid {
    display: grid;
    grid-template-columns: 68% 32%;
    gap: 14px;
}

.chart-card {
    height: 320px;
}

.indicator-card {
    height: 200px;
}

canvas {
    width: 100% !important;
    height: 100% !important;
}

/* =====================================================
   CALENDAR
===================================================== */
.calendar-page {
    display: none;
}

#calendar {
    max-width: 100%;
}
</style>
</head>

<body>

<!-- ================= HEADER ================= -->
<div class="top-header">
    <div class="logo">IVMAS</div>
    <div class="header-right">
        <div class="avatar">A</div>
        <span>Admin User</span>
        <span>Logout</span>
    </div>
</div>

<div class="wrapper">

<!-- ================= SIDEBAR ================= -->
<div class="sidebar">
    <a id="tabDashboard" class="active" onclick="showDashboard()">Dashboard</a>
    <a id="tabCalendar" onclick="showCalendar()">Calendar</a>
</div>

<!-- ================= MAIN ================= -->
<div class="main">

<!-- ================= DASHBOARD PAGE ================= -->
<div id="dashboardPage">

<div class="top-actions">
    <div class="card">
        <h3>Generate Report</h3>
        <p style="font-size:13px;color:#64748b">
            Select a date range to generate performance reports.
        </p>
        <div style="display:flex;gap:8px">
            <input type="date">
            <span>to</span>
            <input type="date">
        </div>
    </div>

    <div class="card">
        <h3>Import Booking Data</h3>
        <button>Import Data</button>
    </div>
</div>

<div class="kpi">
    <div class="card">
        <h3>Indicator 1</h3>
        <div class="value">950</div>
    </div>
    <div class="card">
        <h3>Goal</h3>
        <div class="value">1,000</div>
    </div>
</div>

<div class="grid">

<div>
    <div class="card chart-card">
        <h3>Sales vs Goal</h3>
        <canvas id="salesChart"></canvas>
    </div>

    <div class="card chart-card">
        <h3>% Goal</h3>
        <canvas id="goalChart"></canvas>
    </div>

    <div class="card chart-card">
        <h3>Month-over-Month (MoM)</h3>
        <canvas id="momChart"></canvas>
    </div>
</div>

<div>
    <div class="card indicator-card"><canvas id="i2"></canvas></div>
    <div class="card indicator-card"><canvas id="i3"></canvas></div>
    <div class="card indicator-card"><canvas id="i4"></canvas></div>
</div>

</div>
</div>

<!-- ================= CALENDAR PAGE ================= -->
<div id="calendarPage" class="calendar-page">
    <div class="card">
        <h2 style="margin-bottom:12px">Calendar Interface</h2>
        <div id="calendar"></div>
    </div>
</div>

</div>
</div>

<!-- ================= JAVASCRIPT ================= -->
<script>
/* ================= TAB CONTROL ================= */
function showDashboard(){
    dashboardPage.style.display = "block";
    calendarPage.style.display = "none";
    tabDashboard.classList.add("active");
    tabCalendar.classList.remove("active");
}

let calendarInitialized = false;

function showCalendar(){
    dashboardPage.style.display = "none";
    calendarPage.style.display = "block";
    tabCalendar.classList.add("active");
    tabDashboard.classList.remove("active");

    if(!calendarInitialized){
        initCalendar();
        calendarInitialized = true;
    }
}

/* ================= CHARTS ================= */
document.addEventListener("DOMContentLoaded", function(){

const base = { responsive:true, maintainAspectRatio:false, plugins:{legend:{display:false}} };

new Chart(salesChart,{
    type:"bar",
    data:{labels:["Jan","Feb","Mar","Apr","May","Jun"],
    datasets:[
        {data:[900,850,780,920,880,910],backgroundColor:"#2dd4bf"},
        {data:[1000,1000,1000,1000,1000,1000],backgroundColor:"#e5e7eb"}
    ]},
    options:base
});

new Chart(goalChart,{
    type:"doughnut",
    data:{datasets:[{data:[95,5],backgroundColor:["#2dd4bf","#e5e7eb"]}]},
    options:base
});

new Chart(momChart,{
    type:"bar",
    data:{labels:["Jan","Feb","Mar","Apr","May","Jun"],
    datasets:[{data:[2.5,1.2,-21,7.7,18.3,-2.1],
    backgroundColor:c=>c.raw<0?"#ef4444":"#2dd4bf"}]},
    options:base
});

function mini(id){
    new Chart(document.getElementById(id),{
        type:"line",
        data:{labels:[1,2,3,4,5,6],
        datasets:[{data:[10,12,9,14,11,13],borderColor:"#facc15",tension:.4}]},
        options:{responsive:true,maintainAspectRatio:false,
        plugins:{legend:{display:false}},
        scales:{x:{display:false},y:{display:false}}}
    });
}
mini("i2"); mini("i3"); mini("i4");

});

/* ================= FULLCALENDAR ================= */
function initCalendar(){
    const calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
        initialView: 'dayGridMonth',
        height: 'auto',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        selectable: true,
        select(info){
            const title = prompt("Event title:");
            if(title){
                calendar.addEvent({
                    title,
                    start: info.start,
                    end: info.end,
                    allDay: info.allDay
                });
            }
        },
        eventClick(info){
            if(confirm(`Delete "${info.event.title}"?`)){
                info.event.remove();
            }
        }
    });

    calendar.render();
}
</script>

</body>
</html>
