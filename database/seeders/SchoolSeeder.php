<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schools = [
            [
                'name' => 'Westlands Academy',
                'slug' => Str::slug('Westlands Academy'),
                'school_level_id' => 2, // Primary
                'school_type_id' => 1, // Day
                'curriculum_id' => 1, // CBC
                'ownership' => 'Private',
                'gender_admission' => 'Mixed',
                'county_id' => 1, // Nairobi
                'constituency_id' => 1, // Westlands
                'ward_id' => 1, // Parklands/Highridge
                'address' => 'Westlands Rd, Nairobi',
                'logo' => null,
                'latitude' => -1.26482000,
                'longitude' => 36.811020000,
                'website_url' => 'https://westlandsacademy.ke',
                'contact_email' => 'info@westlandsacademy.ke',
                'contact_phone' => '+254712345678',
                'is_active' => true,
            ],
            [
                'name' => 'Langata Girls High School',
                'slug' => Str::slug('Langata Girls High School'),
                'school_level_id' => 3, // Secondary
                'school_type_id' => 2, // Boarding
                'curriculum_id' => 6, // Secondary (KCSE)
                'ownership' => 'Public',
                'gender_admission' => 'Female',
                'county_id' => 1,
                'constituency_id' => 2, // Langata
                'ward_id' => 3, // Karen
                'address' => 'Langata South Rd, Nairobi',
                'logo' => null,
                'latitude' => -1.35984000,
                'longitude' => 36.759270000,
                'website_url' => null,
                'contact_email' => null,
                'contact_phone' => '+254701112233',
                'is_active' => true,
            ],
            [
                'name' => 'Kapsoya Primary School',
                'slug' => Str::slug('Kapsoya Primary School'),
                'school_level_id' => 2, // Primary
                'school_type_id' => 1, // Day
                'curriculum_id' => 1, // CBC
                'ownership' => 'Public',
                'gender_admission' => 'Mixed',
                'county_id' => 2, // Eldoret
                'constituency_id' => 3, // Soy
                'ward_id' => 5, // Kapsoya
                'address' => 'Kapsoya, Eldoret',
                'logo' => null,
                'latitude' => 0.53253000,
                'longitude' => 35.269220000,
                'website_url' => null,
                'contact_email' => 'kapsoya.primary@edu.go.ke',
                'contact_phone' => '+254713333444',
                'is_active' => true,
            ],
            [
                'name' => 'Frere Town College',
                'slug' => Str::slug('Frere Town College'),
                'school_level_id' => 4, // College
                'school_type_id' => 3, // Day & Boarding
                'curriculum_id' => 5, // TVET
                'ownership' => 'Private',
                'gender_admission' => 'Mixed',
                'county_id' => 8, // Mombasa
                'constituency_id' => 11, // Nyali
                'ward_id' => 14, // Frere Town
                'address' => 'Frere Town, Mombasa',
                'logo' => null,
                'latitude' => -4.03443000,
                'longitude' => 39.689360000,
                'website_url' => 'https://freretowncollege.ac.ke',
                'contact_email' => 'admin@freretowncollege.ac.ke',
                'contact_phone' => '+254722000111',
                'is_active' => true,
            ],
            [
                'name' => 'Zombe Mixed Secondary',
                'slug' => Str::slug('Zombe Mixed Secondary'),
                'school_level_id' => 3, // Secondary
                'school_type_id' => 1, // Day
                'curriculum_id' => 6, // Secondary
                'ownership' => 'Public',
                'gender_admission' => 'Mixed',
                'county_id' => 18, // Mutito
                'constituency_id' => 21, // Mutito North
                'ward_id' => 24, // Zombe
                'address' => 'Zombe, Kitui County',
                'logo' => null,
                'latitude' => -1.30823000,
                'longitude' => 38.050790000,
                'website_url' => null,
                'contact_email' => null,
                'contact_phone' => '+254701987654',
                'is_active' => true,
            ],
            [
                'name' => 'Kapsabet Nursery School',
                'slug' => Str::slug('Kapsabet Nursery School'),
                'school_level_id' => 1, // Nursery
                'school_type_id' => 1, // Day
                'curriculum_id' => 4, // Montessori
                'ownership' => 'Private',
                'gender_admission' => 'Mixed',
                'county_id' => 19, // Kapsabet
                'constituency_id' => 22, // Emgwen
                'ward_id' => 25, // Kapsabet Town
                'address' => 'Kapsabet Town, Nandi County',
                'logo' => null,
                'latitude' => 0.20427000,
                'longitude' => 35.105560000,
                'website_url' => null,
                'contact_email' => 'contact@kapsabetnursery.ke',
                'contact_phone' => '+254745667788',
                'is_active' => true,
            ],
        ];

        foreach ($schools as $school) {
            School::create($school);
        }
    }
}
