<?php

namespace Database\Seeders;

use App\Models\SchoolType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SchoolTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $school_types = ['Day', 'Boarding', 'Day & Boarding'];

        foreach ($school_types as $school_type) {
            SchoolType::create(['name' => $school_type]);
        }
    }
}
