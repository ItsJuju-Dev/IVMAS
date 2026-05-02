<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Sabre\VObject;
use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // ===== BASIC DATA =====
        $bookings = Booking::all();
        $rooms = Room::all();
        $roomCount = $rooms->count();

        // ===== TOTAL BOOKINGS =====
        $totalBookings = $bookings->count();

        // ===== OCCUPANCY RATE =====
        $today = Carbon::today();

        $occupiedRooms = Booking::where('check_in_date', '<=', $today)
            ->where('check_out_date', '>=', $today)
            ->count();

        $occupancyRate = $roomCount > 0 
        ? round(($occupiedRooms / $roomCount) * 100, 2) 
        : 0;

        // ===== TOTAL REVENUE =====
        $totalRevenue = Booking::sum('total_price') ?? 0;

        // ===== AVG STAY =====
        $avgStay = Booking::selectRaw('AVG(DATEDIFF(check_out_date, check_in_date)) as avg_stay')
            ->value('avg_stay');

        $avgStay = round($avgStay ?? 0, 1);

        // =========================================================
        // ===== BOOKING TREND (MONTHLY) =====
        // =========================================================
        $bookingDataRaw = Booking::selectRaw('DATE_FORMAT(check_in_date, "%Y-%m") as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $bookingLabels = [];
        $bookingData = [];

        foreach ($bookingDataRaw as $row) {
            $bookingLabels[] = Carbon::parse($row->date . '-01')->format('M Y');
            $bookingData[] = (int)$row->total;
        }

        // ===== BOOKING FORECAST =====
        $futurePoints = 5;
        $bookingForecast = $this->linearRegressionForecast($bookingData, $futurePoints);

        // =========================================================
        // ===== REVENUE TREND (MONTHLY) =====
        // =========================================================
        $revenueDataRaw = Booking::selectRaw('DATE_FORMAT(check_in_date, "%Y-%m") as date, SUM(total_price) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $revenueLabels = [];
        $revenueData = [];

        foreach ($revenueDataRaw as $row) {
            $revenueLabels[] = Carbon::parse($row->date . '-01')->format('M Y');
            $revenueData[] = (float)$row->total;
        }

        // ===== REVENUE FORECAST =====
        $revenueForecast = $this->linearRegressionForecast($revenueData, $futurePoints);

        // ===== NEXT MONTH FORECAST (FOR KPI CARDS) =====
        $filteredBooking = array_filter($bookingForecast);
        $nextBookingForecast = !empty($filteredBooking) 
            ? end($filteredBooking) 
            : 0;

        $filteredRevenue = array_filter($revenueForecast);
        $nextRevenueForecast = !empty($filteredRevenue) 
            ? end($filteredRevenue) 
            : 0;

        // =========================================================
        // ===== EXTEND LABELS FOR FORECAST =====
        // =========================================================
        for ($i = 1; $i <= $futurePoints; $i++) {

            if (!empty($bookingLabels)) {
                $lastBookingDate = Carbon::createFromFormat('M Y', end($bookingLabels));
                $bookingLabels[] = $lastBookingDate->copy()->addMonths($i)->format('M Y');
            }

            if (!empty($revenueLabels)) {
                $lastRevenueDate = Carbon::createFromFormat('M Y', end($revenueLabels));
                $revenueLabels[] = $lastRevenueDate->copy()->addMonths($i)->format('M Y');
            }
        }

        // ===== AI-STYLE INSIGHTS =====
        // ===== SMARTER INSIGHTS =====
        $insights = [];

        // ===== MONTH-TO-MONTH BOOKING COMPARISON =====
        $currentMonth = Carbon::now()->month;
        $lastMonth = Carbon::now()->subMonth()->month;

        $currentBookings = Booking::whereMonth('check_in_date', $currentMonth)->count();
        $lastBookings = Booking::whereMonth('check_in_date', $lastMonth)->count();

        if ($lastBookings > 0) {
            $change = (($currentBookings - $lastBookings) / $lastBookings) * 100;

            if ($change > 0) {
                $insights[] = "Bookings increased by " . round($change, 1) . "% compared to last month.";
            } else {
                $insights[] = "Bookings decreased by " . abs(round($change, 1)) . "% compared to last month.";
            }
        }

        // ===== OCCUPANCY =====
        if ($occupancyRate > 70) {
            $insights[] = "High occupancy rate indicates strong demand.";
        } elseif ($occupancyRate < 40) {
            $insights[] = "Low occupancy suggests opportunity for promotions.";
        } else {
            $insights[] = "Occupancy is stable and balanced.";
        }

        // ===== REVENUE TREND =====
        if (count($revenueData) > 1) {
            $firstRev = $revenueData[0];
            $lastRev = end($revenueData);

            if ($firstRev > 0) {
                $changeRev = (($lastRev - $firstRev) / $firstRev) * 100;
            } else {
                $changeRev = 0;
            }

            if ($changeRev > 0) {
                $insights[] = "Revenue increased by " . round($changeRev, 1) . "% over the observed period.";
            } else {
                $insights[] = "Revenue decreased by " . abs(round($changeRev, 1)) . "% over the observed period.";
            }
        }

        // ===== FORECAST =====
        if ($nextRevenueForecast > 0 && $totalRevenue > 0) {
            if ($nextRevenueForecast > ($totalRevenue / 6)) {
                $insights[] = "Forecast suggests potential revenue growth in upcoming months.";
            } else {
                $insights[] = "Forecast indicates stable revenue performance ahead.";
            }
        }

        // ===== EDGE CASE =====
        if (empty($insights)) {
            $insights[] = "Not enough data available for insights.";
        }

        // =========================================================
        // ===== RETURN VIEW =====
        // =========================================================
        return view('owner.dashboard', [
            'totalBookings' => $totalBookings,
            'occupancyRate' => $occupancyRate,
            'totalRevenue' => $totalRevenue,
            'avgStay' => $avgStay,

            'bookingLabels' => $bookingLabels,
            'bookingData' => $bookingData,
            'bookingForecast' => $bookingForecast,

            'revenueLabels' => $revenueLabels,
            'revenueData' => $revenueData,
            'revenueForecast' => $revenueForecast,

            'insights' => $insights,

            'nextBookingForecast' => $nextBookingForecast,
            'nextRevenueForecast' => $nextRevenueForecast,

            'rooms' => $rooms, 
        ]);
    }

    /**
     * ===== SIMPLE LINEAR REGRESSION =====
     */
    private function linearRegressionForecast($data, $futurePoints = 5)
    {
        $n = count($data);

        //  Not enough data → return empty forecast
        if ($n < 2) {
            return array_fill(0, $n + $futurePoints, null);
        }

        $x = range(0, $n - 1);
        $y = $data;

        $sumX = array_sum($x);
        $sumY = array_sum($y);

        $sumXY = 0;
        $sumX2 = 0;

        for ($i = 0; $i < $n; $i++) {
            $sumXY += $x[$i] * $y[$i];
            $sumX2 += $x[$i] * $x[$i];
        }

        $denominator = ($n * $sumX2 - $sumX * $sumX);

        if ($denominator == 0) {
            return array_fill(0, $n + $futurePoints, null);
        }

        $m = ($n * $sumXY - $sumX * $sumY) / $denominator;
        $c = ($sumY - $m * $sumX) / $n;

        // Keep actual slots null for forecast alignment
        $forecast = array_fill(0, $n, null);

        for ($i = $n; $i < $n + $futurePoints; $i++) {
            $forecast[] = round($m * $i + $c, 2);
        }

        return $forecast;
    }

    public function export()
    {
        $bookings = \App\Models\Booking::with('room')->get();

        $filename = "bookings_export.csv";

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
        ];

        $callback = function () use ($bookings) {
            $file = fopen('php://output', 'w');

            // CSV HEADER
            fputcsv($file, [
                'Guest Name',
                'Room',
                'Check In',
                'Check Out',
                'Total Price',
                'Status'
            ]);

            // DATA
            foreach ($bookings as $b) {
                fputcsv($file, [
                    $b->guest_name,
                    $b->room->name ?? 'N/A',
                    $b->check_in_date,
                    $b->check_out_date,
                    $b->total_price,
                    $b->status
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf()
    {
        $bookings = Booking::with('room')
            ->orderBy('check_in_date', 'desc')
            ->get();

        // ===== SUMMARY =====
        $totalBookings = $bookings->count();
        $totalRevenue = $bookings->sum('total_price');

        $avgStay = $bookings->avg(function ($booking) {
            return \Carbon\Carbon::parse($booking->check_in_date)
                ->diffInDays(\Carbon\Carbon::parse($booking->check_out_date));
        });

        $avgStay = round($avgStay ?? 0, 1);

        $pdf = Pdf::loadView('owner.reports.bookings_pdf', [
            'bookings' => $bookings,
            'totalBookings' => $totalBookings,
            'totalRevenue' => $totalRevenue,
            'avgStay' => $avgStay,
        ]);

        return $pdf->download('booking_report.pdf');
    }

    public function generateReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $bookings = Booking::with('room')
            ->whereBetween('check_in_date', [
                $request->start_date,
                $request->end_date
            ])
            ->orderBy('check_in_date', 'desc')
            ->get();

        // ===== SUMMARY =====
        $totalBookings = $bookings->count();
        $totalRevenue = $bookings->sum('total_price');

        $avgStay = $bookings->avg(function ($booking) {
            return \Carbon\Carbon::parse($booking->check_in_date)
                ->diffInDays(\Carbon\Carbon::parse($booking->check_out_date));
        });

        $avgStay = round($avgStay ?? 0, 1);

        $pdf = Pdf::loadView('owner.reports.bookings_pdf', [
            'bookings' => $bookings,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'totalBookings' => $totalBookings,
            'totalRevenue' => $totalRevenue,
            'avgStay' => $avgStay,
        ]);

        return $pdf->download(
            'booking_report_' . $request->start_date . '_to_' . $request->end_date . '.pdf'
        );
    }

    public function importIcal(Request $request)
    {
        $url = $request->ical_url;

        $data = file_get_contents($url);

        $vcalendar = \Sabre\VObject\Reader::read($data);

        $importedCount = 0;

        foreach ($vcalendar->VEVENT as $event) {

            $start = $event->DTSTART->getDateTime();
            $end = $event->DTEND->getDateTime();

            $checkIn = $start->format('Y-m-d');
            $checkOut = $end->format('Y-m-d');

            // ===== GET UID (for strong duplicate prevention) =====
            $uid = isset($event->UID) ? (string) $event->UID : null;

            // ===== ASSIGN ROOM (simple version) =====
            $room = \App\Models\Room::find($request->room_id);

            if (!$room) continue;

            // ===== DUPLICATE CHECK (UID first) =====
            if ($uid && \App\Models\Booking::where('external_id', $uid)->exists()) {
                continue;
            }

            // ===== FALLBACK DUPLICATE CHECK =====
            if (\App\Models\Booking::where('check_in_date', $checkIn)
                ->where('check_out_date', $checkOut)
                ->where('room_id', $room->id)
                ->exists()) {
                continue;
            }

            // ===== ESTIMATE PRICE =====
            $days = $start->diff($end)->days;
            $totalPrice = $room->base_price * max($days, 1);

            // ===== CLEAN NAME =====
            $summary = isset($event->SUMMARY) ? (string) $event->SUMMARY : null;

            $guestName = ($summary && $summary !== 'Reserved')
                ? $summary
                : 'Airbnb Booking';

            // ===== CREATE BOOKING =====
            \App\Models\Booking::create([
                'guest_name' => $guestName,
                'room_id' => $room->id,
                'check_in_date' => $checkIn,
                'check_out_date' => $checkOut,
                'total_price' => $totalPrice,
                'status' => 'confirmed',
                'source' => 'ical',
                'external_id' => $uid,
            ]);

            $importedCount++;
        }

        // ===== START LOG =====
        \Log::info('iCal import started', [
            'url' => $url,
            'time' => now()
        ]);

        $importedCount = 0;

        foreach ($vcalendar->VEVENT as $event) {
            // (your existing loop stays the same)
        }

        // ===== END LOG =====
        \Log::info('iCal import completed', [
            'imported' => $importedCount,
            'url' => $url,
            'time' => now()
        ]);

        return back()->with('success', "$importedCount bookings imported successfully");
    }

    public function importAvailability(Request $request)
    {
        $url = $request->ical_url;

        $data = file_get_contents(public_path('importavailabilitytest.ics'));

        $vcalendar = \Sabre\VObject\Reader::read($data);

        $importedCount = 0; // ✅ ADD THIS

        foreach ($vcalendar->VEVENT as $event) {

            $start = \Carbon\Carbon::instance($event->DTSTART->getDateTime());
            $end = \Carbon\Carbon::instance($event->DTEND->getDateTime());

            $checkIn = $start->format('Y-m-d');
            $checkOut = $end->format('Y-m-d');

            $room = \App\Models\Room::inRandomOrder()->first();
            if (!$room) continue;

            if (\App\Models\Booking::where('check_in_date', $checkIn)
                ->where('check_out_date', $checkOut)
                ->where('room_id', $room->id)
                ->exists()) {
                continue;
            }

            \App\Models\Booking::create([
                'guest_name' => 'Unavailable (External)',
                'room_id' => $room->id,
                'check_in_date' => $checkIn,
                'check_out_date' => $checkOut,
                'total_price' => 0,
                'status' => 'blocked',
                'source' => 'ical_block'
            ]);

            $importedCount++; // ✅ ADD THIS
        }

        \Log::info('iCal availability import completed', [
            'imported' => $importedCount,
            'url' => $url
        ]);

        return back()->with('success', "$importedCount availability entries imported");
    }
}