<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Grade;

class AssignDefaultSubjectsToStudents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'students:assign-default-subjects';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign default subjects to all students who do not have them';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to assign default subjects to students...');

        $defaultSubjects = Subject::where('is_default', true)->get();
        $this->info('Found ' . $defaultSubjects->count() . ' default subjects:');
        foreach ($defaultSubjects as $subject) {
            $this->line('- ' . $subject->name);
        }

        $students = Student::all();
        $this->info('Processing ' . $students->count() . ' students...');

        $assignedCount = 0;
        $skippedCount = 0;

        foreach ($students as $student) {
            $this->line("Processing student: {$student->first_name} {$student->last_name} (ID: {$student->student_id})");
            
            $assignedForStudent = 0;
            foreach ($defaultSubjects as $subject) {
                // Check if student already has this subject
                $existingGrade = Grade::where('student_id', $student->student_id)
                    ->where('subject_id', $subject->id)
                    ->first();
                
                if (!$existingGrade) {
                    Grade::create([
                        'student_id' => $student->student_id,
                        'subject_id' => $subject->id,
                        'subject' => $subject->name, // For backward compatibility
                        'first_quarter' => 0,
                        'second_quarter' => 0,
                        'third_quarter' => 0,
                        'fourth_quarter' => 0,
                        'final_grade' => 0,
                    ]);
                    $assignedForStudent++;
                    $this->line("  ✓ Assigned: {$subject->name}");
                } else {
                    $this->line("  - Already has: {$subject->name}");
                }
            }
            
            if ($assignedForStudent > 0) {
                $assignedCount++;
            } else {
                $skippedCount++;
            }
        }

        $this->info("\n=== SUMMARY ===");
        $this->info("Students with new subjects assigned: {$assignedCount}");
        $this->info("Students already had all subjects: {$skippedCount}");
        $this->info("Total students processed: " . $students->count());
        
        $this->info("\nDone! All students now have default subjects assigned.");
    }
}