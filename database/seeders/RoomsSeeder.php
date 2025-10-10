<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Room::insert([
            [
                'room_number' => '101',
                'type' => 'Standard',
                'capacity' => 2,
                'price' => 2500,
                'status' => 'Available',
                'description' => 'Cozy standard room with garden view.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'room_number' => '102',
                'type' => 'Deluxe',
                'capacity' => 3,
                'price' => 4000,
                'status' => 'Available',
                'description' => 'Spacious deluxe room with balcony.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'room_number' => '201',
                'type' => 'Family',
                'capacity' => 5,
                'price' => 6500,
                'status' => 'Available',
                'description' => 'Large family room with two queen beds.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
