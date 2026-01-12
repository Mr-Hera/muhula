<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Ward;
use App\Models\County;
use App\Models\Curriculum;
use App\Models\Constituency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $countyId = County::first()->id;
        // $constituencyId = Constituency::first()->id;
        // $wardId = Ward::first()->id;
        // $curriculumId = Curriculum::first()->id;

        User::create([
            'first_name' => "Muhula",
            'last_name' => "Hub",
            'email' => "muhulahub@gmail.com",
            'phone' => "0721899572",
            'gender' => "Other",
            // 'date_of_birth' => now()->subYears(20 + $i)->toDateString(),
            // 'county_id' => $countyId,
            // 'constituency_id' => $constituencyId,
            // 'ward_id' => $wardId,
            // 'curriculum_id' => $curriculumId,
            'password' => Hash::make('Muhulahub@25!'),
            'is_admin' => true,
        ]);
    }
}
