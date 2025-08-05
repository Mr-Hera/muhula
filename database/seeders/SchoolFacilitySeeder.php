<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\Facility;
use App\Models\SchoolFacility;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SchoolFacilitySeeder extends Seeder
{
    public function run(): void
    {
        $schools = School::all();
        $facilityIds = Facility::pluck('id')->toArray();

        foreach ($schools as $school) {
            // Randomly pick 3 to 6 unique facilities per school
            $assignedFacilities = collect($facilityIds)
                ->shuffle()
                ->take(rand(3, 6))
                ->all();

            foreach ($assignedFacilities as $facilityId) {
                DB::table('school_facilities')->insert([
                    'school_id' => $school->id,
                    'facility_id' => $facilityId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
