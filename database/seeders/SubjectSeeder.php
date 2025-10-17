<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            // Core subjects
            ['name' => 'Mathematics', 'code' => 'MATH-101', 'subject' => 'Mathematics', 'day' => 'Monday', 'time' => '08:00:00', 'teacher' => 'Math Teacher', 'is_default' => true],
            ['name' => 'English', 'code' => 'ENG-101', 'subject' => 'English', 'day' => 'Monday', 'time' => '09:00:00', 'teacher' => 'English Teacher', 'is_default' => true],
            ['name' => 'Science', 'code' => 'SCI-101', 'subject' => 'Science', 'day' => 'Tuesday', 'time' => '08:00:00', 'teacher' => 'Science Teacher', 'is_default' => true],
            ['name' => 'Filipino', 'code' => 'FIL-101', 'subject' => 'Filipino', 'day' => 'Tuesday', 'time' => '09:00:00', 'teacher' => 'Filipino Teacher', 'is_default' => true],
            ['name' => 'Social Studies', 'code' => 'SS-101', 'subject' => 'Social Studies', 'day' => 'Wednesday', 'time' => '08:00:00', 'teacher' => 'Social Studies Teacher', 'is_default' => true],
            ['name' => 'Araling Panlipunan', 'code' => 'AP-101', 'subject' => 'Araling Panlipunan', 'day' => 'Wednesday', 'time' => '09:00:00', 'teacher' => 'AP Teacher', 'is_default' => true],
            ['name' => 'MAPEH', 'code' => 'MAPEH-101', 'subject' => 'MAPEH', 'day' => 'Thursday', 'time' => '08:00:00', 'teacher' => 'MAPEH Teacher', 'is_default' => true],
            ['name' => 'TLE', 'code' => 'TLE-101', 'subject' => 'TLE', 'day' => 'Thursday', 'time' => '09:00:00', 'teacher' => 'TLE Teacher', 'is_default' => true],
            
            // Additional subjects
            ['name' => 'Values Education', 'code' => 'VE-101', 'subject' => 'Values Education', 'day' => 'Friday', 'time' => '08:00:00', 'teacher' => 'Values Teacher', 'is_default' => false],
            ['name' => 'Computer Education', 'code' => 'CE-101', 'subject' => 'Computer Education', 'day' => 'Friday', 'time' => '09:00:00', 'teacher' => 'Computer Teacher', 'is_default' => false],
            ['name' => 'Physical Education', 'code' => 'PE-101', 'subject' => 'Physical Education', 'day' => 'Monday', 'time' => '10:00:00', 'teacher' => 'PE Teacher', 'is_default' => false],
            ['name' => 'Music', 'code' => 'MUS-101', 'subject' => 'Music', 'day' => 'Tuesday', 'time' => '10:00:00', 'teacher' => 'Music Teacher', 'is_default' => false],
            ['name' => 'Arts', 'code' => 'ART-101', 'subject' => 'Arts', 'day' => 'Wednesday', 'time' => '10:00:00', 'teacher' => 'Arts Teacher', 'is_default' => false],
            ['name' => 'Health', 'code' => 'HEALTH-101', 'subject' => 'Health', 'day' => 'Thursday', 'time' => '10:00:00', 'teacher' => 'Health Teacher', 'is_default' => false],
        ];

        foreach ($subjects as $subject) {
            DB::table('subjects')->insert(array_merge($subject, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        echo "Subjects seeded successfully!\n";
    }
}
