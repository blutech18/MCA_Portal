<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use App\Models\ClassAnnouncement;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function dashboard()
    {
        $student = Student::with('gradeLevel', 'studentID')->where('user_id', Auth::id())->first();


        if (!$student) {
            return redirect()->back()->with('error', 'Student not found.');
        }

        $section = $student->section;

        $classes = SchoolClass::where('section_id', $section->id)
                    ->with(['subject', 'schedules'])
                    ->get();
                        
        $grades = Grade::where('student_id', $student->student_id)
                    ->with('subject')
                    ->get();

        $announcements = ClassAnnouncement::where('class_name', $section->section_name)
                            ->latest('created_at')
                            ->get();

        return view('student_dashboard', compact(
            'student',
            'classes',
            'grades',
            'announcements'
        ));
    }

}
