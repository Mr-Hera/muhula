<?php

namespace Database\Seeders;

use App\Models\Curriculum;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CurriculumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $curricula = [
            'CBC' => 'Competency-Based Curriculum focusing on skills and learner outcomes.',
            'IGSCE' => 'International General Certificate of Secondary Education with global recognition.',
            'IB' => 'International Baccalaureate fostering critical thinking and global awareness.',
            'Montessori' => 'Child-centered learning emphasizing independence and hands-on activities.',
            'British' => 'Structured UK curriculum with defined key stages and assessments.',
            'Undergraduate' => 'University and college-level programs in Kenya, including core disciplines like Business, Education, IT, Engineering, Health Sciences, and Humanities.',
        ];

        foreach ($curricula as $name => $description) {
            Curriculum::create([
                'name' => $name,
                'description' => $description,
            ]);
        }
    }
}
