<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Student;
use App\Models\Schedule;
use App\Models\Instructor;
use Illuminate\Http\Request;
use App\Models\InstructorClass;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InstructorScheduleController extends Controller
{
    public function schedMore()
    {
        $instructor = Instructor::where('user_id', Auth::id())->firstOrFail();
        $today = Carbon::now()->format('l'); // Example: "Monday"

        // Fetch ALL schedules for the instructor
        $schedules = DB::table('schedules')
            ->join('instructor_classes', 'schedules.instructor_class_id', '=', 'instructor_classes.id')
            ->join('classes', 'instructor_classes.class_id', '=', 'classes.id')
            ->join('subjects', 'classes.subject_id', '=', 'subjects.id')
            ->join('grade_level', 'classes.grade_level_id', '=', 'grade_level.grade_level_id')
            ->join('section', 'classes.section_id', '=', 'section.id')
            ->select([
                'classes.name as class_name',
                'classes.code as code',
                'subjects.name as subject_name',
                'grade_level.name as grade',
                'section.section_name as section',
                'schedules.day_of_week as day',
                'schedules.start_time as start_time',
                'schedules.end_time as end_time',
                'schedules.room as room',
                DB::raw('ROUND(TIME_TO_SEC(TIMEDIFF(schedules.end_time, schedules.start_time))/3600, 2) as duration'),
            ])
            ->where('instructor_classes.instructor_id', $instructor->instructor_id)
            ->get();

        // Filter schedules for TODAY
        $schedulesToday = $schedules->filter(function ($s) use ($today) {
            return $s->day === $today;
        });

        return view('instructor_class_schedule', [
            'instructor' => $instructor,
            'schedules' => $schedules,
            'schedulesToday' => $schedulesToday,
        ]);
    }

}
