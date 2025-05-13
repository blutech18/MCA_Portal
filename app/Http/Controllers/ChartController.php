<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Strand;
use App\Models\Subject;
use App\Models\Enrollment;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use App\Models\StudentSection;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function index()
    {
        // ————————————————————————————————
        // Chart data (as you already have)
        $strands  = Strand::all();
        $labels   = $strands->pluck('name');              // e.g. ["STEM", "ABM", …]
        $sections = $strands->pluck('no_of_sections');
        $classes = SchoolClass::with('subject')->get();    // e.g. [3, 5, …]

        // ————————————————————————————————
        // User counts
        $users = User::all();

        // Students
        $studentCount = $users
            ->where('user_type', 'student')
            ->count();

        // Instructors (exclude your admin account)
        $instructorCount = $users
            ->where('user_type', 'faculty')             // or 'instructor' if that's your code
            ->reject(fn($u) => $u->username === 'admin_mca' || $u->name === 'Administrator')
            ->count();

        // Total
        $totalCount = $studentCount + $instructorCount;

        $strands = Strand::all();
        $labels   = $strands->pluck('name');
        $sections = $strands->pluck('no_of_sections');

        // 2) count students / instructors (your existing logic)…
        $studentCount    = User::where('user_type','student')->count();
        $instructorCount = User::where('user_type','instructor')
                                ->whereNotIn('username',['admin_mca'])
                                ->count();
        $totalCount      = $studentCount + $instructorCount;

        // 3) all subjects
        $subjects = Subject::all();

        // 4) enrollments per subject by joining through classes:
        $enrollmentCounts = DB::table('subjects')
            ->leftJoin('classes',     'subjects.id',     '=', 'classes.subject_id')
            ->leftJoin('enrollments', 'classes.id',      '=', 'enrollments.class_id')
            ->select('subjects.id as subject_id', DB::raw('count(enrollments.id) as total'))
            ->groupBy('subjects.id')
            ->pluck('total','subject_id');
            // → returns a collection keyed by subject_id, value = enrollment count

            $sections = StudentSection::with('gradeLevel', 'strand')->get();

            // Group by grade level and strand, and count the sections
            $juniorSections = $sections->filter(function($section) {
                return $section->gradeLevel->name <= 10;  // Assuming junior high is grades 1-10
            });

            $seniorSections = $sections->filter(function($section) {
                return $section->gradeLevel->name >= 11;  // Assuming senior high is grades 11-12
            });
            

            // Prepare data for charts
            $juniorLabels = $juniorSections
                ->pluck('gradeLevel.name')  // e.g. Collection ['7', '8',  '7', ...]
                ->unique()                  // keeps only ['7','8']
                ->values()                  // re-indexes to [0=>'7',1=>'8']
                ->toArray();                // converts to plain PHP array

            $juniorData = collect($juniorLabels)
                ->map(fn($label) => 
                    $juniorSections->where('gradeLevel.name', $label)->count()
                )
                ->toArray();

            $seniorLabels = $seniorSections->pluck('strand.name')->unique()->values()->toArray();
            $seniorData = collect($seniorLabels)->map(function($label) use ($seniorSections) {
                return $seniorSections->where('strand.name', $label)->count();
            })->values()->toArray();
        
            return view('admin_dashboard', compact(
                'labels','sections',
                'studentCount','instructorCount','totalCount',
                'subjects','enrollmentCounts','classes',
                'juniorLabels','juniorData','seniorLabels','seniorData'
            ));
            
    }

    

}
