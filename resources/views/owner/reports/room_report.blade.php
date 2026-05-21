<!DOCTYPE html>
<html>
<head>
    <title>{{ $room->name }} Report</title>

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
            margin-top: 15px;
        }

        th {
            background: #e5e7eb;
            font-weight: bold;
        }

        th, td {
            border: 1px solid #9ca3af;
            padding: 8px;
            text-align: center;
        }

        .summary {
            margin-bottom: 15px;
        }

    </style>

</head>
<body>

<h2>{{ $room->name }} Booking Report</h2>

<div class="summary">
    <p><strong>Total Bookings:</strong> {{ $totalBookings }}</p>

    <p>
        <strong>Total Revenue:</strong>
        Rp {{ number_format($totalRevenue, 0, ',', '.') }}
    </p>
</div>

<table>

    <thead>
        <tr>
            <th>Guest</th>
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

            <td>{{ $booking->check_in_date }}</td>

            <td>{{ $booking->check_out_date }}</td>

            <td>
                Rp {{ number_format($booking->total_price, 0, ',', '.') }}
            </td>

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