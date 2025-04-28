<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Instructor;
use Illuminate\Http\Request;
use App\Models\InstructorClass;
use Illuminate\Support\Facades\Auth;

class InstructorAttendanceController extends Controller
{
    public function show(Request $req)
    {
        $instructor = Instructor::with('instructorClasses.class.section')
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // 1) Section dropdown → either ?class_id=… or default to the first
        $classId = $req->query('class_id', 
                       $instructor->instructorClasses->first()->id
                   );
        $iclass = $instructor->instructorClasses
                    ->where('id',$classId)
                    ->first();

        // 2) Date picker → either ?date=YYYY-MM-DD or default to today
        $date = $req->query('date', Carbon::today()->toDateString());

        // Students in that section
        $students = Student::where('section_id', $iclass->class->section_id)
                            ->orderBy('last_name')
                            ->get();

        // Pull existing attendance for this class+date, keyed by student_id
        $existing = Attendance::where('instructor_class_id',$iclass->id)
                      ->where('date',$date)
                      ->get()
                      ->keyBy('student_id');

        // Stats for that date
        $present = $existing->where('status','present')->count();
        $absent  = $existing->where('status','absent')->count();
        $late    = $existing->where('status','late')->count();
        $total   = $students->count();

        return view('instructor_attendance', compact(
            'instructor','iclass','students','existing',
            'present','absent','late','total','date'
        ));
    }

    public function mark(Request $req)
    {
        $data = $req->validate([
            'student_id'          => 'required|exists:students,student_id',
            'instructor_class_id' => 'required|exists:instructor_classes,id',
            'date'                => 'required|date',
            'status'              => 'required|in:present,absent,late',
        ]);

        Attendance::updateOrCreate(
            [
                'student_id'          => $data['student_id'],
                'instructor_class_id' => $data['instructor_class_id'],
                'date'                => $data['date'],
            ],
            ['status' => $data['status']]
        );

        return back()->withInput()->with('success','Attendance updated');
    }
}
