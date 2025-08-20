<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SchoolContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contacts = [
            [
                'contact_position_id' => 1,
                'full_names' => 'John Mwangi',
                'email' => 'john.mwangi@example.com',
                'phone_no' => '+254712345678',
            ],
            [
                'contact_position_id' => 2,
                'full_names' => 'Mary Wanjiku',
                'email' => 'mary.wanjiku@example.com',
                'phone_no' => '+254711223344',
            ],
            [
                'contact_position_id' => 4,
                'full_names' => 'Samuel Otieno',
                'email' => 'samuel.otieno@example.com',
                'phone_no' => '+254700998877',
            ],
            [
                'contact_position_id' => 3,
                'full_names' => 'Grace Njeri',
                'email' => null,
                'phone_no' => '+254733445566',
            ],
            [
                'contact_position_id' => 1,
                'full_names' => 'Peter Kiprotich',
                'email' => 'peter.kiprotich@example.com',
                'phone_no' => null,
            ],
        ];

        foreach ($contacts as $contact) {
            // Insert into school_contacts table
            $contactId = DB::table('school_contacts')->insertGetId([
                'contact_position_id' => $contact['contact_position_id'],
                'full_names' => $contact['full_names'],
                'email' => $contact['email'],
                'phone_no' => $contact['phone_no'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Split names (only first and last are considered)
            $names = explode(' ', trim($contact['full_names']));
            $firstName = $names[0] ?? '';
            $lastName = $names[1] ?? '';

            // Only create a user if email is provided
            if (!empty($contact['email'])) {
                DB::table('users')->insert([
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $contact['email'],
                    'password' => Hash::make(env('SECURE_APP_PASSWORD')),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
