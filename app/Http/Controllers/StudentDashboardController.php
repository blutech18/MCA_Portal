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
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $student = Student::with(['gradeLevel', 'studentID', 'section'])
            ->where('user_id', Auth::id())
            ->first();

        if (!$student) {
            // Avoid redirect loops; show a friendly page with instructions
            return view('student_dashboard')->with([
                'student' => null,
                'classes' => collect(),
                'grades' => collect(),
                'announcements' => collect(),
                'profileMissing' => true,
            ]);
        }

        $section = $student->section; // May be null if not assigned yet

        $classes = collect();
        if ($section) {
            $classes = SchoolClass::where('section_id', $section->id)
                ->with(['subject', 'schedules'])
                ->get();
        }
                        
        $grades = Grade::where('student_id', $student->student_id)
                    ->with(['subjectModel', 'schoolClass'])
                    ->orderBy('subject_id')
                    ->get();

        $announcements = collect();
        if ($section && $section->section_name) {
            $announcements = ClassAnnouncement::where('class_name', $section->section_name)
                ->latest('created_at')
                ->get();
        }

        // Get assessment result for the student
        $assessmentResult = $student ? $student->getAssessmentResult() : null;

        return view('student_dashboard', compact(
            'student',
            'classes',
            'grades',
            'announcements',
            'assessmentResult'
        ));
    }

}
