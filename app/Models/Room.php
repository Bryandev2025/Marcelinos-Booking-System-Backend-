<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
   use HasFactory;

    protected $fillable = [
        'room_number', 'type', 'capacity', 'price', 'status', 'description',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    
}   
