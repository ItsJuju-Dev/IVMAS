<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Owner Dashboard</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
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

/* ================= SIDEBAR ================= */
.sidebar {
    width: 220px;
    min-width: 220px;
    background: #1f2937;
    color: #fff;
    padding: 16px;
}

.sidebar h2 {
    margin: 0 0 20px;
    font-size: 20px;
}

.sidebar a {
    display: block;
    color: #cbd5e1;
    text-decoration: none;
    margin-bottom: 12px;
    font-size: 14px;
}

/* ================= MAIN ================= */
.main {
    flex: 1;
    padding: 20px 24px;
    max-width: 1400px;
}

/* ================= CARD ================= */
.card {
    background: #fff;
    border-radius: 10px;
    padding: 16px 18px;
    margin-bottom: 12px;
}

/* ================= TOP ACTIONS ================= */
.top-actions {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    margin-bottom: 12px;
}

/* ================= KPI ================= */
.kpi {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    margin-bottom: 12px;
}

.kpi h3 {
    margin: 0;
    font-size: 13px;
    color: #64748b;
}

.kpi .value {
    font-size: 32px;
    font-weight: bold;
}

/* ================= GRID ================= */
.grid {
    display: grid;
    grid-template-columns: 68% 32%;
    gap: 14px;
}

/* ================= CHART CARD ================= */
.chart-card {
    height: 320px;
}

.chart-card canvas {
    width: 100% !important;
    height: 100% !important;
}

/* ================= INDICATOR CARD (FIXED) ================= */
.indicator-card {
    height: 200px;
    display: flex;
    flex-direction: column;
}

.indicator-header h4 {
    margin: 0;
    font-size: 13px;
    color: #64748b;
}

.indicator-header .number {
    font-size: 26px;
    font-weight: bold;
}

.indicator-chart {
    flex: 1;
    position: relative;
}

.indicator-chart canvas {
    width: 100% !important;
    height: 100% !important;
}

/* ================= BUTTON ================= */
.btn {
    padding: 10px 16px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
}

.btn.secondary {
    background: #4b5563;
    color: #fff;
}

.btn.primary {
    background: #2563eb;
    color: #fff;
}

/* ================= MODAL ================= */
.modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.45);
    justify-content: center;
    align-items: center;
    z-index: 999;
}

.modal-content {
    background: #fff;
    padding: 24px;
    width: 420px;
    border-radius: 10px;
}
</style>
</head>

<body>

<div class="wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>IVMAS</h2>
        <a href="#">Settings</a>
        <a href="#">Metrics</a>
        <a href="#"><strong>Dashboard</strong></a>
    </div>

    <!-- MAIN -->
    <div class="main">

        <!-- TOP ACTIONS -->
        <div class="top-actions">
            <div class="card">
                <h3>Booking Calendar</h3>
                <p style="font-size:13px;color:#64748b">
                    Select a date to view bookings (placeholder).
                </p>
                <input type="date" style="padding:8px;font-size:14px">
            </div>

            <div class="card">
                <h3>Import Booking Data</h3>
                <p style="font-size:13px;color:#64748b">
                    Import booking data from external sources (CSV / API).
                </p>
                <button class="btn secondary" onclick="openImportModal()">Import Data</button>
            </div>
        </div>

        <!-- KPI -->
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

        <!-- GRID -->
        <div class="grid">

            <!-- LEFT -->
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

            <!-- RIGHT (INDICATORS) -->
            <div>
                <div class="card indicator-card">
                    <div class="indicator-header">
                        <h4>Indicator 2</h4>
                        <div class="number">800</div>
                    </div>
                    <div class="indicator-chart">
                        <canvas id="i2"></canvas>
                    </div>
                </div>

                <div class="card indicator-card">
                    <div class="indicator-header">
                        <h4>Indicator 3</h4>
                        <div class="number">518</div>
                    </div>
                    <div class="indicator-chart">
                        <canvas id="i3"></canvas>
                    </div>
                </div>

                <div class="card indicator-card">
                    <div class="indicator-header">
                        <h4>Indicator 4</h4>
                        <div class="number">710</div>
                    </div>
                    <div class="indicator-chart">
                        <canvas id="i4"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- MODAL -->
<div id="importModal" class="modal">
    <div class="modal-content">
        <h3>Import Booking Data</h3>
        <p>
            This feature will allow owners to import booking data from external
            platforms such as CSV files or third-party APIs.
        </p>
        <em>Feature coming soon.</em><br><br>
        <button class="btn primary" onclick="closeImportModal()">Close</button>
    </div>
</div>

<script>
function openImportModal() {
    document.getElementById('importModal').style.display = 'flex';
}
function closeImportModal() {
    document.getElementById('importModal').style.display = 'none';
}

const baseOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: { legend: { display: false } }
};

new Chart(salesChart, {
    type: 'bar',
    data: {
        labels: ['Jan','Feb','Mar','Apr','May','Jun'],
        datasets: [
            { data: [900,850,780,920,880,910], backgroundColor:'#2dd4bf' },
            { data: [1000,1000,1000,1000,1000,1000], backgroundColor:'#e5e7eb' }
        ]
    },
    options: baseOptions
});

new Chart(goalChart, {
    type: 'doughnut',
    data: {
        datasets: [{ data: [95,5], backgroundColor:['#2dd4bf','#e5e7eb'] }]
    },
    options: baseOptions
});

new Chart(momChart, {
    type: 'bar',
    data: {
        labels: ['Jan','Feb','Mar','Apr','May','Jun'],
        datasets: [{
            data: [2.5,1.2,-21,7.7,18.3,-2.1],
            backgroundColor: ctx => ctx.raw < 0 ? '#ef4444' : '#2dd4bf'
        }]
    },
    options: baseOptions
});

function miniChart(id){
    new Chart(document.getElementById(id),{
        type:'line',
        data:{
            labels:[1,2,3,4,5,6],
            datasets:[{
                data:[10,12,9,14,11,13],
                borderColor:'#facc15',
                tension:0.4
            }]
        },
        options:{
            responsive:true,
            maintainAspectRatio:false,
            plugins:{ legend:{display:false} },
            scales:{ x:{display:false}, y:{display:false} }
        }
    });
}
miniChart('i2'); miniChart('i3'); miniChart('i4');
</script>

</body>
</html>
