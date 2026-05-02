<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    public function run()
    {

        $rooms = Room::all();

        $statuses = ['pending', 'confirmed', 'checked_in', 'checked_out', 'cancelled'];

        $guestNames = [
            'John Doe', 'Jane Smith', 'Michael Tan', 'Siti Aminah',
            'Budi Santoso', 'Chris Lee', 'Ahmad Rizki', 'Sarah Lim',
            'David Wong', 'Lisa Tan', 'Kevin Hart', 'Anna Williams'
        ];

        // Generate 60 bookings
        for ($i = 0; $i < 60; $i++) {

            $room = $rooms->random();

            // Random date between Jan–Jun 2026
            $checkIn = Carbon::create(2026, rand(1, 6), rand(1, 25));

            // Stay duration (1–7 days)
            $days = rand(1, 7);
            $checkOut = $checkIn->copy()->addDays($days);

            // Price calculation
            $totalPrice = $room->base_price * $days;

            Booking::create([
                'guest_name' => $guestNames[array_rand($guestNames)],
                'room_id' => $room->id,
                'check_in_date' => $checkIn->toDateString(),
                'check_out_date' => $checkOut->toDateString(),
                'total_price' => $totalPrice,
                'status' => $statuses[array_rand($statuses)],
                'source' => 'seed',
                'handled_by' => 4, // your staff user
            ]);
        }
    }
}