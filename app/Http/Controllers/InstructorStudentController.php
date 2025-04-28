<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Instructor;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use App\Models\InstructorClass;
use Illuminate\Support\Facades\Auth;

class InstructorStudentController extends Controller
{
    public function index()
    {
        // 1) Get the instructor
        $instructor = Instructor::with([
            'instructorClasses.class.gradeLevel',
            'instructorClasses.class.strand',
            'instructorClasses.class.section',
        ])
        ->where('user_id', Auth::id())
        ->firstOrFail();

        // 2) Get the sections where the instructor is teaching
        $sectionIds = $instructor
            ->instructorClasses
            ->pluck('class.section_id')
            ->filter()
            ->unique();

        // 3) Get the students based on the sections
        $students = Student::whereIn('section_id', $sectionIds)
            ->with(['section', 'status']) // add relationships for section and status
            ->get();

        return view('instructor_class_student', [
            'students' => $students,
            'instructor' => $instructor,
        ]);
    }

}
