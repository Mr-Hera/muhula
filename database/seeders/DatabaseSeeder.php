<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\WardSeeder;
use Database\Seeders\SchoolSeeder;
use Database\Seeders\CoursesSeeder;
use Database\Seeders\CurriculumSeeder;
use Database\Seeders\SchoolTypeSeeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\WardsTableSeeder;
use Database\Seeders\SchoolLevelSeeder;
use Database\Seeders\ConstituencySeeder;
use Database\Seeders\CountiesTableSeeder;
use Database\Seeders\ConstituenciesTableSeeder;

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
            ConstituencySeeder::class,
            WardSeeder::class,
            ConstituenciesTableSeeder::class,
            WardsTableSeeder::class,
            SchoolLevelSeeder::class,
            SchoolTypeSeeder::class,
            CurriculumSeeder::class,
            CoursesSeeder::class,
            UsersTableSeeder::class,
            SchoolSeeder::class,
        ]);
    }
}
