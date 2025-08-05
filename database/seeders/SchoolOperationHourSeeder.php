<?php

namespace Database\Seeders;

use App\Models\School;
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
        // Get the first available school, or create one for testing if none exists
        $school = School::first() ?? School::create([
            'name' => 'Default Test School',
            // include any required fields for your School model
        ]);

        DB::table('school_operation_hours')->insert([
            [
                'school_id' => $school->id,
                'period_of_day' => 'Day',
                'starts_at' => '07:30',
                'ends_at' => '10:30',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'school_id' => $school->id,
                'period_of_day' => 'Day',
                'starts_at' => '10:30',
                'ends_at' => '13:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'school_id' => $school->id,
                'period_of_day' => 'Day',
                'starts_at' => '13:30',
                'ends_at' => '15:30',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'school_id' => $school->id,
                'period_of_day' => 'Evening',
                'starts_at' => '16:00',
                'ends_at' => '18:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'school_id' => $school->id,
                'period_of_day' => 'Evening',
                'starts_at' => '19:00',
                'ends_at' => '21:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
