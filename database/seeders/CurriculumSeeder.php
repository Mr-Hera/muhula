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
            'TVET' => 'Technical and Vocational Education and Training for career-ready skills.',
            'Secondary' => 'KCSE Traditional academic pathway for students in high school.',
            'KNEC' => 'Kenyan national curriculum assessed by the Kenya National Examinations Council.',
            'Cambridge International Curriculum' => 'International curriculum offering a flexible and rigorous academic path.',
            'Edexcel' => 'UK-based academic and vocational qualification under Pearson Education.',
            'British Curriculum' => 'Structured UK curriculum with defined key stages and assessments.',
            'Pearson' => 'Global education curriculum and resources by Pearson Learning.',
            'International' => 'Broad curriculum blending global best practices and academic standards.',
            'Special School' => 'Customized curriculum to support students with special needs.',
            'Pre Vocational' => 'Foundation-level training preparing learners for vocational education.',
            'Vocational' => 'Hands-on curriculum preparing learners for skilled trades and jobs.',
        ];

        foreach ($curricula as $name => $description) {
            Curriculum::create([
                'name' => $name,
                'description' => $description,
            ]);
        }
    }
}
