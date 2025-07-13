<?php

namespace Database\Seeders;

use App\Models\County;
use Illuminate\Database\Seeder;

class CountiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $counties = [
            'Nairobi', 'Eldoret', 'Vihiga', 'Garissa', 'Nyeri', 'Nandi Hills', 'Bungoma',
            'Mombasa', 'Kisumu', 'Machakos', 'Kiambu', 'Kakamega', 'Kamilili', 'Webuye',
            'Kitui', 'Kwale', 'Makueni', 'Mutito', 'Kapsabet', 'Bondo', 'Mutomo',
        ];

        foreach ($counties as $name) {
            County::create(['name' => $name]);
        }
    }
}
