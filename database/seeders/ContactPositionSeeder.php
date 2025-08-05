<?php

namespace Database\Seeders;

use App\Models\ContactPosition;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ContactPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            'Other', 'Owner', 'Founder', 'Teacher/Lecturer', 'Admin', 'Employee', 'Student', 'Alumni',
            'Parent', 'Friend', 'N/A', 
        ];

        foreach ($positions as $position) {
            ContactPosition::create(['name' => $position]);
        }
    }
}
