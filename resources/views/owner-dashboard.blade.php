<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Owner Dashboard</title>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            padding: 40px;
        }

        .container {
            max-width: 900px;
            margin: auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
        }

        h1 {
            margin-bottom: 20px;
        }

        .section {
            margin-bottom: 40px;
        }

        .btn {
            display: inline-block;
            padding: 12px 20px;
            background-color: #2563eb;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 10px;
        }

        .btn.secondary {
            background-color: #4b5563;
        }

        input[type="date"] {
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Owner Dashboard</h1>

    <!--  Booking Calendar -->
    <div class="section">
        <h2>Booking Calendar</h2>
        <p>Select a date to view bookings (placeholder).</p>

        <input type="date">
    </div>

    <!--  Analytics Chart -->
    <div class="section">
        <h2>Booking Analytics</h2>
        <p>Monthly booking overview (sample data).</p>

        <canvas id="bookingChart"></canvas>
    </div>

    <!-- Import Booking Data -->
    <div class="section">
        <h2>Import Booking Data</h2>
        <p>Import booking data from external sources (CSV / API).</p>

        <button class="btn secondary" onclick="openModal()">
            Import Data
        </button>
    </div>

    <!-- Import Modal -->
    <div id="importModal" class="modal">
        <div class="modal-content">
            <h3>Import Booking Data</h3>
            <p>
                This feature will allow owners to import booking data from
                external platforms such as CSV files or third-party APIs.
            </p>

            <p><em>Feature coming soon.</em></p>

            <button class="btn" onclick="closeModal()">Close</button>
        </div>
    </div>

<script>
    const ctx = document.getElementById('bookingChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
            datasets: [{
                label: 'Bookings',
                data: [12, 19, 7, 15, 10],
                backgroundColor: '#2563eb'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

</body>
</html>