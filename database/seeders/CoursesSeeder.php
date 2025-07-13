<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Curriculum;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $curricula = [
            'Mathematics' => 'Competency-Based Curriculum focusing on skills and learner outcomes.',
            'English' => 'International General Certificate of Secondary Education with global recognition.',
            'History' => 'International Baccalaureate fostering critical thinking and global awareness.',
            'Geography' => 'Child-centered learning emphasizing independence and hands-on activities.',
            'Drawing' => 'Technical and Vocational Education and Training for career-ready skills.',
            'Media Studies' => 'KCSE Traditional academic pathway for students in high school.',
            'Hair Dressing' => 'Kenyan national curriculum assessed by the Kenya National Examinations Council.',
            'Beauty & Therapy' => 'International curriculum offering a flexible and rigorous academic path.',
            'Hospitality & Tourism' => 'UK-based academic and vocational qualification under Pearson Education.',
            'Engineering' => 'Structured UK curriculum with defined key stages and assessments.',
            'Information Technology' => 'Global education curriculum and resources by Pearson Learning.',
            'Health & Social Sciences' => 'Broad curriculum blending global best practices and academic standards.',
            'Business Studies' => 'Customized curriculum to support students with special needs.',
            'Theology' => 'Foundation-level training preparing learners for vocational education.',
            'Bible & Theology' => 'Hands-on curriculum preparing learners for skilled trades and jobs.',
            'Food and Beverages' => 'Customized curriculum to support students with special needs.',
            'Human Resource Management' => 'Foundation-level training preparing learners for vocational education.',
            'Supply Chain Management' => 'Hands-on curriculum preparing learners for skilled trades and jobs.',
            'Cooperative Management' => 'Competency-Based Curriculum focusing on skills and learner outcomes.',
            'Social Work & Community Development' => 'International General Certificate of Secondary Education with global recognition.',
            'Library Information Studies' => 'International Baccalaureate fostering critical thinking and global awareness.',
            'Guidance & Counselling' => 'Child-centered learning emphasizing independence and hands-on activities.',
            'Store Keeping' => 'Technical and Vocational Education and Training for career-ready skills.',
            'Sales & Marketing' => 'KCSE Traditional academic pathway for students in high school.',
            'Physics' => 'Kenyan national curriculum assessed by the Kenya National Examinations Council.',
            'Chemistry' => 'International curriculum offering a flexible and rigorous academic path.',
            'Kiswahili' => 'UK-based academic and vocational qualification under Pearson Education.',
            'Biology' => 'Structured UK curriculum with defined key stages and assessments.',
            'C.R.E' => 'Global education curriculum and resources by Pearson Learning.',
            'Home Science' => 'Broad curriculum blending global best practices and academic standards.',
            'Computer Studies' => 'Customized curriculum to support students with special needs.',
            'Art & Design' => 'Foundation-level training preparing learners for vocational education.',
            'Agriculture' => 'Hands-on curriculum preparing learners for skilled trades and jobs.',
            'Business & Finance Management' => 'Customized curriculum to support students with special needs.',
            'Vocational Skills Development' => 'Foundation-level training preparing learners for vocational education.',
            'Engineering $ Technical Skills Development' => 'Hands-on curriculum preparing learners for skilled trades and jobs.',
            'Health Sciences Guidance & Counselling' => 'Competency-Based Curriculum focusing on skills and learner outcomes.',
            'Journalism & Mass Communication' => 'International General Certificate of Secondary Education with global recognition.',
            'Professional Short Courses' => 'International Baccalaureate fostering critical thinking and global awareness.',
            'Basic & Advanced Computer Courses' => 'Child-centered learning emphasizing independence and hands-on activities.',
            'Caregiving & Languages' => 'Technical and Vocational Education and Training for career-ready skills.',
            'Education & Social Studies' => 'KCSE Traditional academic pathway for students in high school.',
            'Integrated Sciences' => 'Kenyan national curriculum assessed by the Kenya National Examinations Council.',
            'Science' => 'International curriculum offering a flexible and rigorous academic path.',
            'Social Studies' => 'UK-based academic and vocational qualification under Pearson Education.',
            'Language Activities' => 'Structured UK curriculum with defined key stages and assessments.',
            'Environmental Activities' => 'Global education curriculum and resources by Pearson Learning.',
            'Psychomotor & Creative Activities' => 'Broad curriculum blending global best practices and academic standards.',
            'Religious Education Activities' => 'Customized curriculum to support students with special needs.',
            'Termly Themes & Projects' => 'Foundation-level training preparing learners for vocational education.',
            'Creative Arts' => 'Hands-on curriculum preparing learners for skilled trades and jobs.',
            'French' => 'Customized curriculum to support students with special needs.',
            'Science & Technology' => 'Foundation-level training preparing learners for vocational education.',
            'Music' => 'Hands-on curriculum preparing learners for skilled trades and jobs.',
            'ICT' => 'Competency-Based Curriculum focusing on skills and learner outcomes.',
            'Design Technology' => 'International General Certificate of Secondary Education with global recognition.',
            'Physical Development' => 'International Baccalaureate fostering critical thinking and global awareness.',
            'Life Skills Education' => 'Child-centered learning emphasizing independence and hands-on activities.',
            'Physical Education' => 'Technical and Vocational Education and Training for career-ready skills.',
            'Hair Beauty & Design' => 'KCSE Traditional academic pathway for students in high school.',
            'Hair Cutting' => 'Kenyan national curriculum assessed by the Kenya National Examinations Council.',
            'Crocheting/Knitting' => 'International curriculum offering a flexible and rigorous academic path.',
            'Building & Construction' => 'UK-based academic and vocational qualification under Pearson Education.',
            'Woodwork' => 'Structured UK curriculum with defined key stages and assessments.',
            'Leatherwork' => 'Global education curriculum and resources by Pearson Learning.',
            'Tailoring' => 'Broad curriculum blending global best practices and academic standards.',
            'First Aid' => 'Customized curriculum to support students with special needs.',
            'Home Management' => 'Foundation-level training preparing learners for vocational education.',
            'Entrepreneurship' => 'Hands-on curriculum preparing learners for skilled trades and jobs.',
            'Number Work' => 'Customized curriculum to support students with special needs.',
            'Social Skills' => 'Foundation-level training preparing learners for vocational education.',
            'Perpetual Training' => 'Hands-on curriculum preparing learners for skilled trades and jobs.',
            'Activities Of Daily Living' => 'Broad curriculum blending global best practices and academic standards.',
            'Pew Vocational Skills' => 'Customized curriculum to support students with special needs.',
            'Science Social Studies' => 'Foundation-level training preparing learners for vocational education.',
            'Science Social Science' => 'Foundation-level training preparing learners for vocational education.',
            'I.R.E Arabic' => 'Customized curriculum to support students with special needs.',
            'Arabic' => 'Foundation-level training preparing learners for vocational education.',
            'Medical Courses' => 'Hands-on curriculum preparing learners for skilled trades and jobs.',
        ];

        foreach ($curricula as $name => $description) {
            Course::create([
                'name' => $name,
                'description' => $description,
            ]);
        }
    }
}
