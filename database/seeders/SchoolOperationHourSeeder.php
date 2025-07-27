<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SchoolOperationHourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('school_operation_hours')->insert([
            [
                'period_of_day' => 'Morning',
                'starts_at' => '07:30',
                'ends_at' => '10:30',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'period_of_day' => 'Midday',
                'starts_at' => '10:30',
                'ends_at' => '13:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'period_of_day' => 'Afternoon',
                'starts_at' => '13:30',
                'ends_at' => '15:30',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'period_of_day' => 'Evening',
                'starts_at' => '16:00',
                'ends_at' => '18:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'period_of_day' => 'Boarding Prep',
                'starts_at' => '19:00',
                'ends_at' => '21:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
