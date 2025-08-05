<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SchoolAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('school_addresses')->insert([
            [
                'latitude' => -1.292066,
                'longitude' => 36.821946,
                'google_maps_link' => 'https://maps.google.com/?q=-1.292066,36.821946',
                'address_text' => 'Nairobi CBD',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'latitude' => -0.514278,
                'longitude' => 36.452159,
                'google_maps_link' => null,
                'address_text' => 'Nakuru East',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'latitude' => 0.516667,
                'longitude' => 35.283333,
                'google_maps_link' => 'https://maps.google.com/?q=0.516667,35.283333',
                'address_text' => 'Kapsabet Central',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'latitude' => -0.091702,
                'longitude' => 34.767956,
                'google_maps_link' => 'https://maps.google.com/?q=-0.091702,34.767956',
                'address_text' => 'Kisumu',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'latitude' => -3.375276,
                'longitude' => 36.854248,
                'google_maps_link' => null,
                'address_text' => 'Arusha, TZ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
