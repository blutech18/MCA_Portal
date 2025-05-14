<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\CoreValue;
use App\Models\Instructor;
use Illuminate\Http\Request;
use App\Models\InstructorClass;
use App\Models\CoreValueEvaluation;
use Illuminate\Support\Facades\Auth;

class InstructorStudentGradeController extends Controller
{
    // InstructorStudentGradeController.php

    public function gradeSheet(Request $request)
    {
        // 1) Load the instructor and their classes (unchanged)
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

        // 2) Build your $rows for the student table (unchanged)
        $rows = collect();
        $class   = $ic->class;
        $subject = $class->subject;
        $students = Student::where('section_id', $class->section_id)->get();

        foreach ($students as $student) {
            $grade = Grade::firstOrNew([
                'student_id' => $student->student_id,
                'class_id'   => $class->id,
                'subject_id' => $subject->id,
            ]);
            $rows->push(compact('student','class','subject','grade'));
        }

        // 3) Determine which student to evaluate for Core Values
        //    Use ?student=ID in the URL, or default to the first student in $rows
        $studentId = $request->query(
            'student',
            $rows->first()['student']->student_id ?? null
        );
        $coreStudent = $studentId
            ? Student::where('student_id', $studentId)->first()
            : null;

        // 4) Load all Core Values and that student’s existing scores
        $coreValues  = CoreValue::all();
        $evaluations = $coreStudent
            ? CoreValueEvaluation::where('student_id', $coreStudent->student_id)
                ->pluck('score','core_value_id')
            : collect();

        // 5) Pass everything into the same view
        return view('instructor_report', [
            'instructor'  => $instructor,
            'iclass'      => $ic,
            'rows'        => $rows,
            'coreStudent'=> $coreStudent,
            'coreValues'  => $coreValues,
            'evaluations' => $evaluations,
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
    
   public function saveEvaluations(Request $request)
    {
    $data = $request->validate([
        'student_id'      => 'required|exists:students,student_id',
        'scores'          => 'required|array',
        'scores.*'        => 'nullable|numeric|min:0|max:100',
    ]);
    $studentId = $data['student_id'];

    foreach ($data['scores'] as $cvId => $score) {
        CoreValueEvaluation::updateOrCreate(
        ['student_id'    => $studentId,
        'core_value_id' => $cvId],
        ['score'=>$score]
        );
    }
    return back()->with('success','Core values saved.');
    }


    
}
