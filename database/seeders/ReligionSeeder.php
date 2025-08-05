<?php

namespace Database\Seeders;

use App\Models\Religion;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReligionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $religions = [
            'Christian', 'Muslim', 'Hindu', 'Catholic', 'N/A',
        ];

        foreach ($religions as $religion) {
            Religion::create(['name' => $religion]);
        }
    }
}
