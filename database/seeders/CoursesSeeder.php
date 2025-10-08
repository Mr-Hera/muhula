<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Curriculum;
use App\Models\SchoolLevel;
use App\Models\Course;

class CoursesSeeder extends Seeder
{
    public function run(): void
    {
        $data = [

            // ✅ CBC Curriculum
            'CBC' => [
                'Nursery' => [
                    'Language Activities',
                    'Mathematical Activities',
                    'Environmental Activities',
                    'Psychomotor',
                    'Creative Activities',
                    'Religious and Moral Activities',
                ],
                'Primary' => [
                    'English',
                    'Kiswahili',
                    'Mathematics',
                    'Religious Education (CRE)',
                    'Religious Education (IRE)',
                    'Religious Education (HRE)',
                    'Social Studies',
                    'Science & Technology',
                    'Agriculture & Nutrition',
                    'Creative Arts',
                    'Physical & Health Education',
                    'Indigenous Languages',
                    'Hygiene & Nutritional Activities',
                    'Digital Literacy',
                    'Kenya Sign Language',
                    'Braille',
                    'Pastoral Program Instruction (PPI)',
                ],
                'Secondary' => [
                    'English',
                    'Kiswahili or Kenyan Sign Language',
                    'Mathematics',
                    'Integrated Science',
                    'Health Education',
                    'Pre-Technical and Pre-Career Education',
                    'Social Studies',
                    'Religious Education',
                    'Business Studies',
                    'Agriculture',
                    'Life Skills',
                    'Sports and Physical Education',
                    'Visual Arts',
                    'Performing Arts',
                    'Home Science',
                    'Computer Science',
                    'Foreign Languages (German, French, Mandarin, or Arabic)',
                    'History and Citizenship',
                    'Geography',
                    'Christian Religious Education',
                    'Islamic Religious Education',
                    'Hindu Religious Education',
                    'Physics',
                    'Chemistry',
                    'Biology',
                    'Agriculture',
                ],
            ],

            // ✅ Montessori Curriculum
            'Montessori' => [
                'Nursery' => [
                    'Practical Life',
                    'Sensorial Development',
                    'Language',
                    'Mathematics',
                    'Science',
                    'Culture (Geography & History)',
                    'Arts',
                    'Basic Swahili',
                    'Basic French',
                    'Computer lessons',
                    'Music, Movement & Drama',
                    'Swimming',
                ],
            ],

            // ✅ IGCSE
            'IGCSE' => [
                'Nursery' => [
                    'Early Mathematics',
                    'Early Literacy & Language',
                    'Early Science & Discovery',
                    'Creative Arts & Expression',
                    'Music & Movement',
                    'Physical Development (PE)',
                    'Personal, Social & Emotional Development (PSED)',
                    'ICT (Play-based Introduction)',
                ],
                'Primary' => [
                    'Mathematics',
                    'English',
                    'Science',
                    'Social Studies',
                    'Geography',
                    'History',
                    'Art',
                    'Music',
                    'PE',
                    'Kiswahili',
                    'French',
                    'ICT',
                    'PSHE',
                ],
                'Secondary' => [
                    'Mathematics',
                    'English Language',
                    'English Literature',
                    'Biology',
                    'Chemistry',
                    'Physics',
                    'History',
                    'Geography',
                    'Sociology',
                    'Global Perspectives',
                    'Economics',
                    'French',
                    'Spanish',
                    'Chinese',
                    'Kiswahili',
                    'Art and Design',
                    'Business Studies',
                    'Drama',
                    'Music',
                    'Computer Science',
                    'ICT',
                    'Design and Technology',
                    'Physical Education',
                ],
            ],

            // ✅ British
            'British' => [
                'Nursery' => [
                    'Communication and Language',
                    'Physical Development',
                    'Personal, Social and Emotional Development (PSED)',
                    'Literacy (Early Reading & Writing)',
                    'Mathematics (Early Numeracy)',
                    'Understanding the World',
                    'Expressive Arts and Design',
                ],
                'Primary' => [
                    'Mathematics',
                    'English',
                    'Science',
                    'Social Studies',
                    'Geography',
                    'History',
                    'Art',
                    'Music',
                    'PE',
                    'Kiswahili',
                    'French',
                    'ICT',
                    'PSHE',
                ],
                'Secondary' => [
                    'Mathematics',
                    'English Language',
                    'English Literature',
                    'Biology',
                    'Chemistry',
                    'Physics',
                    'History',
                    'Geography',
                    'Sociology',
                    'Global Perspectives',
                    'Economics',
                    'French',
                    'Spanish',
                    'Chinese',
                    'Kiswahili',
                    'Art and Design',
                    'Business Studies',
                    'Drama',
                    'Music',
                    'Computer Science',
                    'ICT',
                    'Design and Technology',
                    'Physical Education',
                ],
            ],

            // ✅ International Baccalaureate (IB)
            'IB' => [
                'Nursery' => [
                    'Language Development',
                    'Mathematics (Early Numeracy)',
                    'Social Studies',
                    'Science (Exploration & Inquiry)',
                    'Arts',
                    'Physical, Social & Personal Education',
                    'Units of Inquiry',
                ],
                'Primary' => [
                    'Theory of Knowledge',
                    'English Literature',
                    'French',
                    'Swahili',
                    'Spanish',
                    'History',
                    'Geography',
                    'Economics',
                    'Biology',
                    'Chemistry',
                    'Physics',
                    'Math',
                    'Visual Arts',
                    'Theatre Art',
                ],
                'Secondary' => [
                    'Theory of Knowledge',
                    'English Literature',
                    'French',
                    'Swahili',
                    'Spanish',
                    'History',
                    'Geography',
                    'Economics',
                    'Biology',
                    'Chemistry',
                    'Physics',
                    'Math',
                    'Visual Arts',
                    'Theatre Art',
                ],
            ],

            // ✅ University Core Courses
            'Undergraduate' => [
                'College' => [
                    'Business Administration',
                    'Accounting',
                    'Finance',
                    'Marketing',
                    'Computer Science',
                    'Information Technology',
                    'Nursing',
                    'Public Health',
                    'Civil Engineering',
                    'Law',
                    'Education',
                    'Sociology',
                    'Psychology',
                ],
            ],
        ];

        foreach ($data as $curriculumName => $levels) {
            $curriculum = Curriculum::where('name', $curriculumName)->first();

            if (! $curriculum) {
                continue; // skip if not in CurriculumSeeder
            }

            foreach ($levels as $levelName => $courses) {
                $level = SchoolLevel::where('name', $levelName)->first();

                if (! $level) {
                    continue; // skip if not in SchoolLevelSeeder
                }

                foreach ($courses as $courseName) {
                    Course::firstOrCreate([
                        'name' => $courseName,
                        'curriculum_id' => $curriculum->id,
                        'school_level_id' => $level->id,
                    ]);
                }
            }
        }
    }
}
