<?php

namespace Database\Seeders;

use App\Models\SchoolLevel;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SchoolLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $school_levels = ['Nursery', 'Primary', 'Secondary', 'College'];

        foreach ($school_levels as $school_level) {
            SchoolLevel::create(['name' => $school_level]);
        }
    }
}
