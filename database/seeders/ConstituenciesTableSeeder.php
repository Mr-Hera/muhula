<?php

namespace Database\Seeders;

use App\Models\County;
use App\Models\Constituency;
use Illuminate\Database\Seeder;

class ConstituenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $county = County::first(); // Assign all to the first county for simplicity

        $constituencies = ['Westlands', 'Langata', 'Ruaraka', 'Embakasi East', 'Kasarani'];

        foreach ($constituencies as $name) {
            Constituency::create([
                'county_id' => $county->id,
                'name' => $name,
            ]);
        }
    }
}
