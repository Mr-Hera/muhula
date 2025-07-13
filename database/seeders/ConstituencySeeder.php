<?php

namespace Database\Seeders;

use App\Models\Constituency;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ConstituencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $constituencies = [
            ['county_id' => 1, 'name' => 'Westlands'],
            ['county_id' => 1, 'name' => 'Langata'],
            ['county_id' => 2, 'name' => 'Soy'],
            ['county_id' => 2, 'name' => 'Kapseret'],
            ['county_id' => 3, 'name' => 'Sabatia'],
            ['county_id' => 3, 'name' => 'Hamisi'],
            ['county_id' => 4, 'name' => 'Garissa Township'],
            ['county_id' => 5, 'name' => 'Tetu'],
            ['county_id' => 6, 'name' => 'Nandi Hills'],
            ['county_id' => 7, 'name' => 'Kimilili'],
            ['county_id' => 8, 'name' => 'Nyali'],
            ['county_id' => 9, 'name' => 'Kisumu Central'],
            ['county_id' => 10, 'name' => 'Machakos Town'],
            ['county_id' => 11, 'name' => 'Kiambaa'],
            ['county_id' => 12, 'name' => 'Lurambi'],
            ['county_id' => 13, 'name' => 'Mt. Elgon'],
            ['county_id' => 14, 'name' => 'Webuye East'],
            ['county_id' => 15, 'name' => 'Kitui South'],
            ['county_id' => 16, 'name' => 'Matuga'],
            ['county_id' => 17, 'name' => 'Kibwezi East'],
            ['county_id' => 18, 'name' => 'Mutito North'],
            ['county_id' => 19, 'name' => 'Emgwen'],
            ['county_id' => 20, 'name' => 'Bondo'],
            ['county_id' => 21, 'name' => 'Mutomo Central'],
        ];

        foreach ($constituencies as $constituency) {
            Constituency::create($constituency);
        }
    }
}
