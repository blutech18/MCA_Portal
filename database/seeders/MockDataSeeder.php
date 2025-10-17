<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MockDataSeeder extends Seeder
{
    /**
     * Run the database seeds - Creates mock data for grade input testing
     */
    public function run(): void
    {
        $this->command->info('🌱 Starting mock data seeding...');

        // 1. SUBJECTS (handle dual schema: subjects.name/code vs subjects.subject)
        $this->command->info('📚 Seeding subjects...');
        $subjects = [
            ['id' => 1, 'n' => 'Mathematics',      'code' => 'MATH-101'],
            ['id' => 2, 'n' => 'English',          'code' => 'ENG-101'],
            ['id' => 3, 'n' => 'Science',          'code' => 'SCI-101'],
            ['id' => 4, 'n' => 'Filipino',         'code' => 'FIL-101'],
            ['id' => 5, 'n' => 'Social Studies',   'code' => 'SS-101'],
        ];
        $hasName = Schema::hasColumn('subjects', 'name');
        $hasSubject = Schema::hasColumn('subjects', 'subject');
        foreach ($subjects as $s) {
            $payload = ['updated_at' => now()];
            if ($hasName)    { $payload['name'] = $s['n']; }
            if ($hasSubject) { $payload['subject'] = $s['n']; }
            if (Schema::hasColumn('subjects', 'code')) { $payload['code'] = $s['code']; }
            // Backward-compatible columns from older schema
            if (Schema::hasColumn('subjects', 'day'))     { $payload['day'] = 'Monday'; }
            if (Schema::hasColumn('subjects', 'time'))    { $payload['time'] = '08:00:00'; }
            if (Schema::hasColumn('subjects', 'teacher')) { $payload['teacher'] = 'Test Instructor'; }
            if (Schema::hasColumn('subjects', 'image'))   { $payload['image'] = null; }
            $payload['created_at'] = now();
            DB::table('subjects')->updateOrInsert(['id' => $s['id']], $payload);
        }

        // 2a. GRADE LEVELS (required FK for students and classes)
        $this->command->info('🔢 Seeding grade levels...');
        foreach ([
            ['grade_level_id' => 1, 'name' => '7'],
            ['grade_level_id' => 2, 'name' => '8'],
            ['grade_level_id' => 3, 'name' => '9'],
            ['grade_level_id' => 4, 'name' => '10'],
        ] as $gl) {
            DB::table('grade_level')->updateOrInsert(['grade_level_id' => $gl['grade_level_id']], $gl + ['created_at' => now(), 'updated_at' => now()]);
        }

        // 2b. SECTIONS
        $this->command->info('🏫 Seeding sections...');
        foreach ([
            ['id' => 1, 'section_name' => 'Grade 7 - Diamond', 'grade_level_id' => 1, 'strand_id' => null],
            ['id' => 3, 'section_name' => 'Grade 8 - Emerald', 'grade_level_id' => 2, 'strand_id' => null],
            ['id' => 5, 'section_name' => 'Grade 9 - Gold',    'grade_level_id' => 3, 'strand_id' => null],
        ] as $sec) {
            DB::table('section')->updateOrInsert(['id' => $sec['id']], $sec + ['created_at' => now(), 'updated_at' => now()]);
        }

        // 3. CLASSES
        $this->command->info('📖 Seeding classes...');
        foreach ([
            ['id' => 101, 'name' => 'Math 7-Diamond',     'code' => 'M7D', 'subject_id' => 1, 'grade_level_id' => 1, 'section_id' => 1, 'room' => 'R101'],
            ['id' => 102, 'name' => 'English 7-Diamond',  'code' => 'E7D', 'subject_id' => 2, 'grade_level_id' => 1, 'section_id' => 1, 'room' => 'R102'],
            ['id' => 103, 'name' => 'Science 8-Emerald',  'code' => 'S8E', 'subject_id' => 3, 'grade_level_id' => 2, 'section_id' => 3, 'room' => 'R201'],
        ] as $cls) {
            DB::table('classes')->updateOrInsert(['id' => $cls['id']], $cls + ['created_at' => now(), 'updated_at' => now()]);
        }

        // 4. USERS (create mock users referenced by students)
        $this->command->info('👤 Seeding users for students...');
        $userPk = Schema::hasColumn('users', 'user_id') ? 'user_id' : 'id';
        foreach ([
            [$userPk => 100, 'name' => 'Juan Dela Cruz',    'username' => 'juan.dc',    'email' => 'juan@example.com'],
            [$userPk => 101, 'name' => 'Maria Santos',      'username' => 'maria.s',    'email' => 'maria@example.com'],
            [$userPk => 102, 'name' => 'Pedro Reyes',       'username' => 'pedro.r',    'email' => 'pedro@example.com'],
        ] as $u) {
            $payload = $u + [
                'password' => bcrypt('Password123!'),
                'user_type' => 'student',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            DB::table('users')->updateOrInsert([$userPk => $u[$userPk]], $payload);
        }

        // 5. STUDENTS
        $this->command->info('👨‍🎓 Seeding students...');
        foreach ([
            ['student_id' => 1001, 'school_student_id' => 'STU-001', 'user_id' => 100, 'first_name' => 'Juan',  'last_name' => 'Dela Cruz', 'gender' => 'male',   'date_of_birth' => '2012-01-15', 'contact_number' => '09171234567', 'address' => 'Manila', 'grade_level_id' => 1, 'section_id' => 1, 'status_id' => 1, 'grade_id' => 1],
            ['student_id' => 1002, 'school_student_id' => 'STU-002', 'user_id' => 101, 'first_name' => 'Maria', 'last_name' => 'Santos',    'gender' => 'female', 'date_of_birth' => '2012-03-20', 'contact_number' => '09181234567', 'address' => 'Manila', 'grade_level_id' => 1, 'section_id' => 1, 'status_id' => 1, 'grade_id' => 1],
            ['student_id' => 1003, 'school_student_id' => 'STU-003', 'user_id' => 102, 'first_name' => 'Pedro', 'last_name' => 'Reyes',     'gender' => 'male',   'date_of_birth' => '2011-05-10', 'contact_number' => '09191234567', 'address' => 'Manila', 'grade_level_id' => 2, 'section_id' => 3, 'status_id' => 1, 'grade_id' => 2],
        ] as $stu) {
            DB::table('students')->updateOrInsert(['student_id' => $stu['student_id']], $stu + ['created_at' => now(), 'updated_at' => now()]);
        }

        // 6. INSTRUCTOR CLASSES
        $this->command->info('👩‍🏫 Seeding instructor assignments...');
        foreach ([
            ['id' => 201, 'instructor_id' => 1, 'class_id' => 101],
            ['id' => 202, 'instructor_id' => 1, 'class_id' => 102],
            ['id' => 203, 'instructor_id' => 1, 'class_id' => 103],
        ] as $ic) {
            DB::table('instructor_classes')->updateOrInsert(['id' => $ic['id']], $ic + ['created_at' => now(), 'updated_at' => now()]);
        }

        // 7. SCHEDULES
        $this->command->info('📅 Seeding schedules...');
        foreach ([
            ['schedule_id' => 301, 'instructor_class_id' => 201, 'day_of_week' => 'Monday',    'start_time' => '08:00', 'end_time' => '09:00', 'room' => 'R101'],
            ['schedule_id' => 302, 'instructor_class_id' => 202, 'day_of_week' => 'Tuesday',   'start_time' => '09:00', 'end_time' => '10:00', 'room' => 'R102'],
            ['schedule_id' => 303, 'instructor_class_id' => 203, 'day_of_week' => 'Wednesday', 'start_time' => '10:00', 'end_time' => '11:00', 'room' => 'R201'],
        ] as $sch) {
            DB::table('schedules')->updateOrInsert(['schedule_id' => $sch['schedule_id']], $sch + ['created_at' => now(), 'updated_at' => now()]);
        }

        // 8. GRADES
        $this->command->info('📊 Seeding grades...');
        $subjectNames = [1 => 'Mathematics', 2 => 'English', 3 => 'Science'];
        foreach ([
            ['student_id' => 1001, 'class_id' => 101, 'subject_id' => 1, 'first_quarter' => 85.50, 'second_quarter' => 88.00, 'third_quarter' => 90.25, 'fourth_quarter' => 87.75, 'final_grade' => 87.88],
            ['student_id' => 1001, 'class_id' => 102, 'subject_id' => 2, 'first_quarter' => 92.00, 'second_quarter' => 90.50, 'third_quarter' => 91.75, 'fourth_quarter' => 93.00, 'final_grade' => 91.81],
            ['student_id' => 1002, 'class_id' => 101, 'subject_id' => 1, 'first_quarter' => 78.00, 'second_quarter' => 82.50, 'third_quarter' => 80.00, 'fourth_quarter' => 83.25, 'final_grade' => 80.94],
            ['student_id' => 1002, 'class_id' => 102, 'subject_id' => 2, 'first_quarter' => 88.50, 'second_quarter' => 90.00, 'third_quarter' => 89.25, 'fourth_quarter' => 91.50, 'final_grade' => 89.81],
            ['student_id' => 1003, 'class_id' => 103, 'subject_id' => 3, 'first_quarter' => 95.00, 'second_quarter' => 93.50, 'third_quarter' => 94.75, 'fourth_quarter' => 96.00, 'final_grade' => 94.81],
        ] as $gr) {
            // Upsert by unique natural key (student_id + class_id + subject_id)
            $payload = $gr + ['created_at' => now(), 'updated_at' => now()];
            if (Schema::hasColumn('grades', 'subject') && isset($subjectNames[$gr['subject_id']])) {
                $payload['subject'] = $subjectNames[$gr['subject_id']];
            }
            DB::table('grades')->updateOrInsert(
                ['student_id' => $gr['student_id'], 'class_id' => $gr['class_id'], 'subject_id' => $gr['subject_id']],
                $payload
            );
        }

        // 9. ENROLLMENTS
        $this->command->info('📝 Seeding enrollments...');
        foreach ([
            ['student_id' => 1001, 'class_id' => 101],
            ['student_id' => 1001, 'class_id' => 102],
            ['student_id' => 1002, 'class_id' => 101],
            ['student_id' => 1002, 'class_id' => 102],
            ['student_id' => 1003, 'class_id' => 103],
        ] as $enr) {
            $payload = $enr;
            if (Schema::hasColumn('enrollments', 'enrolled_at')) { $payload['enrolled_at'] = now(); }
            if (Schema::hasColumn('enrollments', 'semester'))    { $payload['semester'] = '1st'; }
            if (Schema::hasColumn('enrollments', 'created_at'))  { $payload['created_at'] = now(); }
            if (Schema::hasColumn('enrollments', 'updated_at'))  { $payload['updated_at'] = now(); }
            DB::table('enrollments')->updateOrInsert(
                ['student_id' => $enr['student_id'], 'class_id' => $enr['class_id']],
                $payload
            );
        }

        $this->command->info('✅ Mock data seeded successfully!');
        $this->command->warn('⚠️ Note: Ensure instructor_id=1 and user_ids (100-102) exist in your database');
    }
}
