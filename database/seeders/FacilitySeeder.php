<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $facilities = [
            '10 Acres Campus Size', 'Library', 'Play Ground', 'Urban Type Campus', 'Car Parking', 'Swimming Pool', 'Computer Laboratory',
            'Classrooms', 'Accommodation', 'Auditorium', 'Recreation Center', 'Buildings & Laboratories', 'Cafeteria', 'Sporting Facilities',
            'Research Center', 'College Canteen', 'Business Center', 'Practical Lab', 'Hospital', 'Meeting Room',
        ];

        foreach ($facilities as $facility) {
            Facility::create(['name' => $facility]);
        }
    }
}
