<!DOCTYPE html>
<html>
<head>
    <title>Booking Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 12px;
        }

        th {
            background: #e5e7eb; /* softer gray */
            font-weight: bold;
        }

        th, td {
            border: 1px solid #9ca3af; /* softer border */
            padding: 8px;
            text-align: center;
        }

        td {
            background: #ffffff;
        }

        /* Summary table (no borders) */
        .summary-table td {
            border: none !important;
            padding: 4px 8px;
            text-align: left;
        }
    </style>
</head>
<body>

<h2 style="text-align:center;">Booking Report</h2>

@if(isset($start_date) && isset($end_date))
<p style="text-align:center;">
    Period: {{ $start_date }} → {{ $end_date }}
</p>
@endif

<hr>

<!-- ===== SUMMARY ===== -->
<h3>Summary</h3>
<table class="summary-table">
    <tr>
        <td><strong>Total Bookings:</strong> {{ $totalBookings ?? 0 }}</td>
        <td><strong>Total Revenue:</strong> Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</td>
        <td><strong>Avg Stay:</strong> {{ $avgStay ?? 0 }} days</td>
    </tr>
</table>

<!-- ===== BOOKINGS TABLE ===== -->
<table>
    <thead>
        <tr>
            <th>Guest</th>
            <th>Room</th>
            <th>Check In</th>
            <th>Check Out</th>
            <th>Total Price</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($bookings as $booking)
        <tr>
            <td>{{ $booking->guest_name }}</td>
            <td>{{ $booking->room->name ?? '-' }}</td>
            <td>{{ $booking->check_in_date }}</td>
            <td>{{ $booking->check_out_date }}</td>
            <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
            <td>{{ ucfirst($booking->status) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<br>

<p style="font-size:10px; text-align:right;">
    Generated on {{ now()->format('d M Y') }}
</p>

</body>
</html>