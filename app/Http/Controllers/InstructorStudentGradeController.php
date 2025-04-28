<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Instructor;
use Illuminate\Http\Request;
use App\Models\InstructorClass;
use Illuminate\Support\Facades\Auth;

class InstructorStudentGradeController extends Controller
{
    // InstructorStudentGradeController.php

    public function gradeSheet(Request $request)
    {
        $instructor = Instructor::with([
            'instructorClasses.class.subject',
            'instructorClasses.class.section',
        ])
        ->where('user_id', Auth::id())
        ->firstOrFail();

        $classId = $request->query(
            'class_id',
            $instructor->instructorClasses->first()->id
        );
        $ic = $instructor->instructorClasses
              ->firstWhere('id', $classId);

              $rows = collect();
              $class   = $ic->class;
              $subject = $class->subject;
          
              $students = Student::where('section_id', $class->section_id)->get();
          
              // Use $student here, not $s
              foreach ($students as $student) {
                  $grade = Grade::firstOrNew([
                      'student_id' => $student->student_id,
                      'class_id'   => $class->id,
                      'subject_id' => $subject->id,
                  ]);
                  // now compact('student', 'class', 'subject', 'grade') works
                  $rows->push(compact('student','class','subject','grade'));
              }
          
              return view('instructor_report', [
                  'instructor' => $instructor,
                  'iclass'     => $ic,
                  'rows'       => $rows,
              ]);
    }


  
    // save one grade record (create or update)
    public function saveGrade(Request $req)
    {
        $data = $req->validate([
            'grade_id'      => 'nullable|exists:grades,id',
            'student_id'    => 'required|exists:students,student_id',
            'class_id'      => 'required|exists:classes,id',
            'subject_id'    => 'required|exists:subjects,id',
            'first_quarter' => 'nullable|numeric',
            'second_quarter'=> 'nullable|numeric',
            'third_quarter' => 'nullable|numeric',
            'fourth_quarter'=> 'nullable|numeric',
        ]);
    
        $grade = Grade::updateOrCreate(
            ['id' => $data['grade_id'], 'student_id' => $data['student_id']],
            array_merge($data, [
                'final_grade' => (
                    ($data['first_quarter']  ?? 0)
                    +($data['second_quarter'] ?? 0)
                    +($data['third_quarter']  ?? 0)
                    +($data['fourth_quarter'] ?? 0)
                ) / 4
            ])
        );
    
        return back()->with('success','Grade saved');
    }
    

    
}
