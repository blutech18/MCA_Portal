<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\CoreValue;
use Illuminate\Http\Request;
use App\Models\CoreValueEvaluation;
use Illuminate\Support\Facades\Auth;

class CoreValueEvaluationController extends Controller
{
    public function edit(Student $student)
    {
        // load all core values + existing evaluation
        $coreValues = CoreValue::all();
        $evaluations = CoreValueEvaluation::where('student_id', $student->student_id)
                             ->pluck('score','core_value_id');
        return view('instructor_report', compact('student','coreValues','evaluations'));
    }

    // Instructor: save scores
    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'scores' => 'required|array',
            'scores.*' => 'nullable|numeric|min:0|max:100'
        ]);

        foreach ($data['scores'] as $cvId => $score) {
            CoreValueEvaluation::updateOrCreate(
                ['student_id'=>$student->student_id,'core_value_id'=>$cvId],
                ['score'=>$score]
            );
        }

        return back()->with('success','Core values saved.');
    }

    // Student: display their own evaluations
    public function show()
    {
        $student = Student::where('user_id',Auth::id())->firstOrFail();
        $evaluations = CoreValueEvaluation::with('coreValue')
                         ->where('student_id',$student->student_id)
                         ->get();

        return view('student.evaluations_show', compact('evaluations'));
    }
}
