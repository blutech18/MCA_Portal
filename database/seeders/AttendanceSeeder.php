<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use App\Models\InstructorClass;
use App\Models\Student;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some instructor classes and students
        $instructorClasses = InstructorClass::with('class.section')->take(3)->get();
        $students = Student::take(10)->get();

        if ($instructorClasses->isEmpty() || $students->isEmpty()) {
            $this->command->info('No instructor classes or students found. Skipping attendance seeding.');
            return;
        }

        // Create attendance records for the last 7 days
        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::today()->subDays($i);
            
            foreach ($instructorClasses as $instructorClass) {
                // Get students from the same section as the class
                $sectionStudents = $students->where('section_id', $instructorClass->class->section_id);
                
                foreach ($sectionStudents as $student) {
                    // Randomly assign attendance status
                    $statuses = ['present', 'absent', 'late'];
                    $status = $statuses[array_rand($statuses)];
                    
                    $timeIn = null;
                    $timeOut = null;
                    
                    if ($status === 'present') {
                        $timeIn = '08:00:00';
                        $timeOut = '15:00:00';
                    } elseif ($status === 'late') {
                        $timeIn = '08:30:00';
                        $timeOut = '15:00:00';
                    }
                    
                    Attendance::create([
                        'student_id' => $student->student_id,
                        'instructor_class_id' => $instructorClass->id,
                        'date' => $date->toDateString(),
                        'status' => $status,
                        'time_in' => $timeIn,
                        'time_out' => $timeOut,
                    ]);
                }
            }
        }

        $this->command->info('Attendance records created successfully!');
    }
}