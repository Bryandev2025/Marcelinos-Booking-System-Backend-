<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guest extends Model
{
     use HasFactory;

    protected $fillable = [
        'first_name', 'middle_name', 'last_name', 'gender', 'phone', 'email', 'address',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
