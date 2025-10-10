<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Guest;

class GuestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        Guest::insert([
            [
                'first_name' => 'Bryan',
                'middle_name' => 'Santos',
                'last_name' => 'Dela Cruz',
                'gender' => 'Male',
                'phone' => '09171234567',
                'email' => 'juan@example.com',
                'address' => 'Manila City',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Maria',
                'middle_name' => 'Reyes',
                'last_name' => 'Lopez',
                'gender' => 'Female',
                'phone' => '09281234567',
                'email' => 'maria@example.com',
                'address' => 'Cebu City',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
