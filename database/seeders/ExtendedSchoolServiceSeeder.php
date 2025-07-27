<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExtendedSchoolService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ExtendedSchoolServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $school_services = [
            'Meals Offered',
            'Special Needs Catered',
            'School Transport Available'
        ];

        foreach ($school_services as $school_service) {
            ExtendedSchoolService::create(['name' => $school_service]);
        }
    }
}
