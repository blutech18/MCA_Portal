<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentSubjectController extends Controller
{
    public function subjects()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $student = Student::with(['section','gradeLevel','studentID'])
            ->where('user_id', Auth::id())
            ->first();

        if (!$student) {
            // Return view with empty data instead of redirect to avoid loops
            return view('student_subjects', [
                'student' => null,
                'classes' => collect(),
            ]);
        }

        $section = $student->section; // may be null

        $classes = collect();
        if ($section) {
            $classes = SchoolClass::where('section_id', $section->id)
                ->with(['subject', 'schedules'])
                ->get();
        }
       

        return view('student_subjects', compact(
            'student',
            'classes'
        ));
    }
}
