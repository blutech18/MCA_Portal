<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use App\Models\ClassAnnouncement;
use App\Models\CoreValueEvaluation;
use Illuminate\Support\Facades\Auth;

class StudentReportCardController extends Controller
{
    public function reportCard()
    {
        $student = Student::where('user_id', Auth::id())->first();

        if (!$student) {
            return redirect()->back()->with('error', 'Student not found.');
        }

        $grades = Grade::where('student_id', $student->student_id)
                    ->with('subject')
                    ->get();

        // ✅ Get core value evaluations for the current student
        $evaluations = CoreValueEvaluation::with('coreValue')
                        ->where('student_id', $student->student_id)
                        ->get();

        return view('student_report_card', compact('grades', 'evaluations'));
    }


}
