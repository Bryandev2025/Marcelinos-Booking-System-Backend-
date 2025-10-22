<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReviewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('client_reviews')->insert([
            [
                'guest_id' => 1,
                'review_date' => Carbon::now()->subDays(10),
                'review_text' => 'Our stay was amazing! The staff was friendly and the room was spotless.',
                'stars' => 5,
            ],
            [
                'guest_id' => 2,
                'review_date' => Carbon::now()->subDays(25),
                'review_text' => 'Nice and cozy place. Would definitely come back again!',
                'stars' => 4,
            ],
            [
                'guest_id' => 3,
                'review_date' => Carbon::now()->subDays(40),
                'review_text' => 'Great experience overall. Clean rooms and good service.',
                'stars' => 5,
            ],
            [
                'guest_id' => 4,
                'review_date' => Carbon::now()->subDays(60),
                'review_text' => 'Comfortable stay, but breakfast could be improved.',
                'stars' => 3,
            ],
            [
                'guest_id' => 5,
                'review_date' => Carbon::now()->subDays(90),
                'review_text' => 'Excellent facilities and very helpful staff!',
                'stars' => 5,
            ],
        ]);
    }
}
