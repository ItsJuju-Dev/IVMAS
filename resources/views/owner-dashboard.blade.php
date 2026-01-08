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
*{
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

html,body{
    margin:0;
    padding:0;
    background:#f4f6f8;
}

/* =====================================================
   HEADER
===================================================== */
.top-header{
    height:64px;
    background:#020617;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0 24px;
    color:#fff;
}

.logo{
    font-size:20px;
    font-weight:bold;
}

.header-right{
    display:flex;
    align-items:center;
    gap:12px;
}

.avatar{
    width:36px;
    height:36px;
    border-radius:50%;
    background:#2563eb;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:bold;
}

/* =====================================================
   LAYOUT
===================================================== */
.wrapper{
    display:flex;
    min-height:calc(100vh - 64px);
}

/* =====================================================
   SIDEBAR
===================================================== */
.sidebar{
    width:220px;
    background:#020617;
    padding:16px;
}

.sidebar a{
    display:block;
    color:#cbd5e1;
    text-decoration:none;
    padding:10px 12px;
    border-radius:6px;
    margin-bottom:10px;
    cursor:pointer;
}

.sidebar a.active{
    background:#1e40af;
    color:#fff;
}

/* =====================================================
   MAIN
===================================================== */
.main{
    flex:1;
    padding:20px 24px;
    max-width:1400px;
}

/* =====================================================
   CARD
===================================================== */
.card{
    background:#fff;
    border-radius:12px;
    padding:16px 18px;
    margin-bottom:12px;
}

/* =====================================================
   TOP ACTIONS
===================================================== */
.top-actions{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:12px;
}

/* =====================================================
   KPI
===================================================== */
.kpi{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:12px;
}

.kpi .value{
    font-size:32px;
    font-weight:bold;
}

/* =====================================================
   GRID
===================================================== */
.grid{
    display:grid;
    grid-template-columns:68% 32%;
    gap:14px;
}

/* =====================================================
   CHART FIX (PALING PENTING)
===================================================== */
.chart-card{
    height:320px;
    display:flex;
    flex-direction:column;
}

.chart-title{
    font-weight:bold;
    margin-bottom:6px;
}

.chart-body{
    position:relative;
    flex:1;
}

.chart-body canvas{
    position:absolute;
    inset:0;
    width:100%!important;
    height:100%!important;
}

/* =====================================================
   RIGHT INDICATORS
===================================================== */
.indicator-card{
    height:200px;
    display:flex;
    flex-direction:column;
}

.indicator-header h4{
    margin:0;
    font-size:13px;
    color:#64748b;
}

.indicator-value{
    font-size:26px;
    font-weight:bold;
}

.indicator-delta.up{color:#16a34a;font-size:12px;}
.indicator-delta.down{color:#dc2626;font-size:12px;}

.indicator-chart{
    position:relative;
    flex:1;
}

.indicator-chart canvas{
    position:absolute;
    inset:0;
}

/* =====================================================
   CALENDAR
===================================================== */
.calendar-page{
    display:none;
}

#calendar{
    width:100%;
    height:600px;
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

</style>
</head>

<body>

<!-- ================= HEADER ================= -->
<div class="top-header">
    <div class="logo">IVMAS</div>

    <div class="header-right">
        <div class="avatar">O</div>
        <span>Owner User</span>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                Logout
            </button>
        </form>
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
            <input type="date" onclick="alert('Coming soon!')">
            <span>to</span>
            <input type="date" onclick="alert('Coming soon!')">
        </div>
    </div>

    <div class="card">
        <h3>Export Booking Data</h3>
        <button onclick="alert('Coming soon!')">Export Data</button>
    </div>
</div>

<div class="kpi">
    <div class="card">
        <h3>Indicator 1</h3>
        <div class="value">950</div>
        <small style="color:#16a34a">▲ 11.8%</small>
    </div>
    <div class="card">
        <h3>Goal</h3>
        <div class="value">1,000</div>
    </div>
</div>

<div class="grid">

<!-- LEFT -->
<div>
    <div class="card chart-card">
        <div class="chart-title">Sales vs Goal</div>
        <div class="chart-body">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <div class="card chart-card">
        <div class="chart-title">% Goal</div>
        <div class="chart-body">
            <canvas id="goalChart"></canvas>
        </div>
    </div>

    <div class="card chart-card">
        <div class="chart-title">Month-over-Month (MoM)</div>
        <div class="chart-body">
            <canvas id="momChart"></canvas>
        </div>
    </div>
</div>

<!-- RIGHT -->
<div>
    <div class="card indicator-card">
        <div class="indicator-header">
            <h4>Indicator 2</h4>
            <div class="indicator-value">800</div>
            <div class="indicator-delta down">▼ 15.0%</div>
        </div>
        <div class="indicator-chart"><canvas id="i2"></canvas></div>
    </div>

    <div class="card indicator-card">
        <div class="indicator-header">
            <h4>Indicator 3</h4>
            <div class="indicator-value">518</div>
            <div class="indicator-delta up">▲ 1.6%</div>
        </div>
        <div class="indicator-chart"><canvas id="i3"></canvas></div>
    </div>

    <div class="card indicator-card">
        <div class="indicator-header">
            <h4>Indicator 4</h4>
            <div class="indicator-value">710</div>
            <div class="indicator-delta down">▼ 4.1%</div>
        </div>
        <div class="indicator-chart"><canvas id="i4"></canvas></div>
    </div>
</div>

</div>
</div>

<!-- ================= CALENDAR PAGE ================= -->
<div id="calendarPage" class="calendar-page">
    <div class="card">
        <h2>Calendar Interface</h2>
        <div id="calendar"></div>
    </div>
</div>

</div>
</div>

<script>
/* ================= TAB CONTROL ================= */
let calendar;
let calendarInitialized=false;

function showDashboard(){
    dashboardPage.style.display="block";
    calendarPage.style.display="none";
    tabDashboard.classList.add("active");
    tabCalendar.classList.remove("active");
}

function showCalendar(){
    dashboardPage.style.display="none";
    calendarPage.style.display="block";
    tabCalendar.classList.add("active");
    tabDashboard.classList.remove("active");

    if(!calendarInitialized){
        initCalendar();
        calendarInitialized=true;
    }else{
        calendar.updateSize();
    }
}

/* ================= CHART OPTIONS ================= */
const base={
    responsive:true,
    maintainAspectRatio:false,
    plugins:{legend:{display:false}}
};

/* ================= CHARTS ================= */
document.addEventListener("DOMContentLoaded",()=>{
    new Chart(salesChart,{
        type:"bar",
        data:{
            labels:["Jan","Feb","Mar","Apr","May","Jun"],
            datasets:[
                {data:[900,850,780,920,880,910],backgroundColor:"#2dd4bf"},
                {data:[1000,1000,1000,1000,1000,1000],backgroundColor:"#e5e7eb"}
            ]
        },
        options:base
    });

    new Chart(goalChart,{
        type:"doughnut",
        data:{datasets:[{data:[95,5],backgroundColor:["#2dd4bf","#e5e7eb"],cutout:"70%"}]},
        options:base
    });

    new Chart(momChart,{
        type:"bar",
        data:{
            labels:["Jan","Feb","Mar","Apr","May","Jun"],
            datasets:[{data:[2.5,1.2,-21,7.7,18.3,-2.1],
            backgroundColor:c=>c.raw<0?"#ef4444":"#2dd4bf"}]
        },
        options:base
    });

    ["i2","i3","i4"].forEach(id=>{
        new Chart(document.getElementById(id),{
            type:"line",
            data:{labels:[1,2,3,4,5,6],
            datasets:[{data:[10,12,9,14,11,13],borderColor:"#facc15",tension:.4}]},
            options:{responsive:true,maintainAspectRatio:false,
            plugins:{legend:{display:false}},
            scales:{x:{display:false},y:{display:false}}}
        });
    });
});

/* ================= FULLCALENDAR ================= */
function initCalendar(){
    calendar=new FullCalendar.Calendar(document.getElementById("calendar"),{
        initialView:"dayGridMonth",
        height:600,
        expandRows:true,
        headerToolbar:{
            left:"prev,next today",
            center:"title",
            right:"dayGridMonth,timeGridWeek,timeGridDay"
        },
        selectable:true,
        select(){alert("Coming soon!")},
        eventClick(){alert("Coming soon!")}
    });
    calendar.render();
    setTimeout(()=>calendar.updateSize(),50);
}
</script>

</body>
</html>
