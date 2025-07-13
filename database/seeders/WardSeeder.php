<?php

namespace Database\Seeders;

use App\Models\Ward;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wards = [
            ['constituency_id' => 1, 'name' => 'Parklands/Highridge'],
            ['constituency_id' => 1, 'name' => 'Kangemi'],
            ['constituency_id' => 2, 'name' => 'Karen'],
            ['constituency_id' => 2, 'name' => 'South C'],
            ['constituency_id' => 3, 'name' => 'Kapsoya'],
            ['constituency_id' => 3, 'name' => 'Kimumu'],
            ['constituency_id' => 4, 'name' => 'Megun'],
            ['constituency_id' => 5, 'name' => 'Wodanga'],
            ['constituency_id' => 6, 'name' => 'Muhudu'],
            ['constituency_id' => 7, 'name' => 'Bulla'],
            ['constituency_id' => 8, 'name' => 'Aguthi-Gaaki'],
            ['constituency_id' => 9, 'name' => 'Chepkumia'],
            ['constituency_id' => 10, 'name' => 'Kibingei'],
            ['constituency_id' => 11, 'name' => 'Frere Town'],
            ['constituency_id' => 12, 'name' => 'Manyatta'],
            ['constituency_id' => 13, 'name' => 'Mumbuni'],
            ['constituency_id' => 14, 'name' => 'Karuri'],
            ['constituency_id' => 15, 'name' => 'Shirere'],
            ['constituency_id' => 16, 'name' => 'Kapkateny'],
            ['constituency_id' => 17, 'name' => 'Misikhu'],
            ['constituency_id' => 18, 'name' => 'Ikutha'],
            ['constituency_id' => 19, 'name' => 'Kubo South'],
            ['constituency_id' => 20, 'name' => 'Masongaleni'],
            ['constituency_id' => 21, 'name' => 'Zombe'],
            ['constituency_id' => 22, 'name' => 'Kapsabet Town'],
            ['constituency_id' => 23, 'name' => 'Nyamonye'],
            ['constituency_id' => 24, 'name' => 'Mutomo East'],
        ];

        foreach ($wards as $ward) {
            Ward::create($ward);
        }
    }
}
