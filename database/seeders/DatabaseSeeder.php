<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\WardSeeder;
use Database\Seeders\SchoolSeeder;
use Database\Seeders\CoursesSeeder;
use Database\Seeders\FacilitySeeder;
use Database\Seeders\ReligionSeeder;
use Database\Seeders\CurriculumSeeder;
use Database\Seeders\SchoolTypeSeeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\WardsTableSeeder;
use Database\Seeders\SchoolLevelSeeder;
use Database\Seeders\ConstituencySeeder;
use Database\Seeders\CountiesTableSeeder;
use Database\Seeders\SchoolUniformSeeder;
use Database\Seeders\CountriesTableSeeder;
use Database\Seeders\SchoolFacilitySeeder;
use Database\Seeders\ContactPositionSeeder;
use Database\Seeders\SchoolImagesTableSeeder;
use Database\Seeders\SchoolOperationHourSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            CountiesTableSeeder::class,
            CountriesTableSeeder::class,
            ContactPositionSeeder::class,
            SchoolUniformSeeder::class,
            SchoolContactSeeder::class,
            SchoolAddressSeeder::class,
            SchoolOperationHourSeeder::class,
            ReligionSeeder::class,
            FacilitySeeder::class,
            SchoolFacilitySeeder::class,
            ExtendedSchoolServiceSeeder::class,
            ConstituencySeeder::class,
            WardSeeder::class,
            ConstituencySeeder::class,
            WardsTableSeeder::class,
            SchoolLevelSeeder::class,
            SchoolTypeSeeder::class,
            CurriculumSeeder::class,
            CoursesSeeder::class,
            UsersTableSeeder::class,
            SchoolSeeder::class,
            SchoolImagesTableSeeder::class,
        ]);
    }
}
