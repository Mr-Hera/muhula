<?php

namespace Database\Seeders;

use App\Models\SchoolImage;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SchoolImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SchoolImage::create([
            'school_id' => 1, // Make sure this ID exists in your 'schools' table
            'image_path' => 'school_images/sample.jpg',
            'caption' => 'Front view of the main school building',
        ]);
    }
}
