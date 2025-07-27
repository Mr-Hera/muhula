<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SchoolUniformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('school_uniforms')->insert([
            [
                'gender' => 'Male',
                'name' => 'Grey Trousers & White Shirt',
                'image' => 'uniforms/male1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'gender' => 'Female',
                'name' => 'Blue Dress & White Blouse',
                'image' => 'uniforms/female1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'gender' => 'Mixed',
                'name' => 'Grey Shorts & Blue Shirt',
                'image' => 'uniforms/mixed1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'gender' => 'Male',
                'name' => 'Black Trousers & Green Shirt',
                'image' => 'uniforms/male2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'gender' => 'Female',
                'name' => 'Checked Skirt & White Shirt',
                'image' => 'uniforms/female2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
