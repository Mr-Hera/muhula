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
        $countyId = County::first()->id;
        $constituencyId = Constituency::first()->id;
        $wardId = Ward::first()->id;
        $curriculumId = Curriculum::first()->id;

        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'first_name' => "First{$i}",
                'last_name' => "Last{$i}",
                'email' => "user{$i}@example.com",
                'phone' => "07000000{$i}",
                'gender' => $i % 2 === 0 ? 'Male' : 'Female',
                'date_of_birth' => now()->subYears(20 + $i)->toDateString(),
                'county_id' => $countyId,
                'constituency_id' => $constituencyId,
                'ward_id' => $wardId,
                'curriculum_id' => $curriculumId,
                'password' => Hash::make('password'),
            ]);
        }
    }
}
