<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Booking;

class BookingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Booking::insert([
            [
                'guest_id' => 1, // Bryan
                'room_id' => 1, // Room 101
                'reference_id' => 'REF' . strtoupper(uniqid()),
                'check_in' => now()->addDays(1),
                'check_out' => now()->addDays(3),
                'num_of_guests' => 2,
                'total_price' => 5000,
                'payment_status' => 'Paid',
                'status' => 'Confirmed',
                'remarks' => 'Booked via website.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'guest_id' => 2, // Maria
                'room_id' => 2, // Room 102
                'reference_id' => 'REF' . strtoupper(uniqid()),
                'check_in' => now()->addDays(5),
                'check_out' => now()->addDays(8),
                'num_of_guests' => 3,
                'total_price' => 12000,
                'payment_status' => 'Unpaid',
                'status' => 'Pending',
                'remarks' => 'Awaiting payment confirmation.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
