<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'guest_name',
        'room_id',
        'check_in_date',
        'check_out_date',
        'total_price',
        'status',
        'source',
        'handled_by',
    ];

    // Relationship: Booking belongs to Room
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    // Relationship: Booking handled by Staff (User)
    public function staff()
    {
        return $this->belongsTo(User::class, 'handled_by');
    }
}