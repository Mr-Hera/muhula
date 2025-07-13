<?php

namespace Database\Seeders;

use App\Models\Ward;
use App\Models\Constituency;
use Illuminate\Database\Seeder;

class WardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $constituency = Constituency::first(); // Assign all to first constituency

        $wards = ['Kileleshwa', 'Karen', 'South C', 'Umoja', 'Donholm'];

        foreach ($wards as $name) {
            Ward::create([
                'constituency_id' => $constituency->id,
                'name' => $name,
            ]);
        }
    }
}
