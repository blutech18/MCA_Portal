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
        $student = Student::where('user_id', Auth::id())->first();

        if (!$student) {
            return redirect()->back()->with('error', 'Student not found.');
        }

        $section = $student->section;

        $classes = SchoolClass::where('section_id', $section->id)
                    ->with(['subject', 'schedules'])
                    ->get();
       

        return view('student_subjects', compact(
            'classes'
        ));
    }
}
