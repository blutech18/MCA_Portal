<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Student;
use App\Models\Schedule;
use App\Models\Instructor;
use Illuminate\Http\Request;
use App\Models\InstructorClass;
use Illuminate\Support\Facades\Auth;

class InstructorDashboardController extends Controller
{
    public function index()
    {
       // 1) Load the logged-in instructor + their pivot records
        $instructor = Instructor::with([
            'instructorClasses.class.gradeLevel',
            'instructorClasses.class.strand',
            'instructorClasses.class.section',
        ])
        ->where('user_id', Auth::id())
        ->firstOrFail();

        // 2) Grab all of their pivot IDs
        $pivotIds = $instructor->instructorClasses->pluck('id');

        // 3) Fetch “today”’s schedules for _those_ pivot IDs
        $today = Carbon::now()->format('l');
        $todaySchedules = Schedule::with('schoolClass')
            ->whereIn('instructor_class_id', $pivotIds)
            ->where('day_of_week', $today)
            ->get();

        // 4) Figure out which sections they teach, then load & group students by section
        $sectionIds = $instructor
            ->instructorClasses
            ->pluck('class.section_id')
            ->filter()
            ->unique();

        $studentsBySection = Student::whereIn('section_id', $sectionIds)
            ->get()
            ->groupBy('section_id');

        // 5) Compute total students today
        $totalStudents = $studentsBySection->flatten()->count();

        return view('instructor_dashboard', compact(
            'instructor',
            'todaySchedules',
            'studentsBySection',
            'totalStudents'
        ));
    
    }
       

}
