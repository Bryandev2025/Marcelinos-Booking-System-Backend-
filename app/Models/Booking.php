<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model
{
     use HasFactory;

    protected $fillable = [
        'guest_id', 'room_id', 'reference_id', 'check_in', 'check_out', 'num_of_days',
        'num_of_guests', 'total_price', 'payment_status', 'status', 'remarks', 'pending_expires_at',
    ];

    protected static function booted()
    {
        static::creating(function ($booking) {
            $booking->reference_id = strtoupper(Str::random(8));
        });
    }

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
