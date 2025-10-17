<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use App\Models\ClassAnnouncement;
use App\Models\CoreValueEvaluation;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;

class StudentReportCardController extends Controller
{
    public function reportCard()
    {
        $student = Student::with(['gradeLevel','studentID','section'])
            ->where('user_id', Auth::id())
            ->first();

        if (!$student) {
            // Return view with empty data instead of redirect to avoid loops
            return view('student_report_card', [
                'student' => null,
                'grades' => collect(),
                'evaluations' => collect(),
            ]);
        }

        $grades = Grade::where('student_id', $student->student_id)
                    ->with('subjectModel')
                    ->get();

        // ✅ Get core value evaluations for the current student (if table exists)
        if (Schema::hasTable('core_value_evaluations')) {
            $evaluations = CoreValueEvaluation::with('coreValue')
                            ->where('student_id', $student->student_id)
                            ->get();
        } else {
            $evaluations = collect();
        }

        return view('student_report_card', compact('student', 'grades', 'evaluations'));
    }


}
