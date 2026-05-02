<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Booking;

class Room extends Model
{
    protected $fillable = [
        'name',
        'type',
        'capacity',
        'base_price',
        'description',
        'status',
    ];

    // Relationship: One room has many bookings
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
