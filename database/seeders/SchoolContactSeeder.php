<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SchoolContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('school_contacts')->insert([
            [
                'contact_position_id' => 1,
                'full_names' => 'John Mwangi',
                'email' => 'john.mwangi@example.com',
                'phone_no' => '+254712345678',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'contact_position_id' => 2,
                'full_names' => 'Mary Wanjiku',
                'email' => 'mary.wanjiku@example.com',
                'phone_no' => '+254711223344',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'contact_position_id' => 4,
                'full_names' => 'Samuel Otieno',
                'email' => 'samuel.otieno@example.com',
                'phone_no' => '+254700998877',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'contact_position_id' => 3,
                'full_names' => 'Grace Njeri',
                'email' => null,
                'phone_no' => '+254733445566',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'contact_position_id' => 1,
                'full_names' => 'Peter Kiprotich',
                'email' => 'peter.kiprotich@example.com',
                'phone_no' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
