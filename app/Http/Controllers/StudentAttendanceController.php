<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentAttendanceController extends Controller
{
    /**
     * Display student's attendance records
     */
    public function index(Request $request)
    {
        $student = Student::with(['gradeLevel', 'studentID', 'section'])
            ->where('user_id', Auth::id())
            ->first();

        if (!$student) {
            return redirect()->route('student.dashboard')->with('error', 'Student profile not found.');
        }

        // Get date range for filtering (default to last 30 days)
        $dateFrom = $request->query('date_from', Carbon::today()->subDays(30)->toDateString());
        $dateTo = $request->query('date_to', Carbon::today()->toDateString());

        // Get attendance records for the student
        $attendances = Attendance::with(['instructorClass.class.subject'])
            ->where('student_id', $student->student_id)
            ->whereBetween('date', [$dateFrom, $dateTo])
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate attendance statistics
        $totalDays = $attendances->count();
        $presentDays = $attendances->where('status', 'present')->count();
        $absentDays = $attendances->where('status', 'absent')->count();
        $lateDays = $attendances->where('status', 'late')->count();
        
        $attendanceRate = $totalDays > 0 ? round(($presentDays / $totalDays) * 100, 2) : 0;

        // Group attendance by subject for better display
        $attendanceBySubject = $attendances->groupBy(function($attendance) {
            return $attendance->instructorClass->class->subject->name ?? 'Unknown Subject';
        });

        return view('student_attendance', compact(
            'student',
            'attendances',
            'attendanceBySubject',
            'dateFrom',
            'dateTo',
            'totalDays',
            'presentDays',
            'absentDays',
            'lateDays',
            'attendanceRate'
        ));
    }

    /**
     * API endpoint to get student attendance in real-time
     */
    public function getAttendance(Request $request)
    {
        try {
            $studentId = $request->input('student_id');
            
            if (!$studentId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Student ID is required'
                ], 400);
            }

            // Get recent attendance records (last 7 days)
            $attendances = Attendance::with(['instructorClass.class.subject'])
                ->where('student_id', $studentId)
                ->where('date', '>=', Carbon::today()->subDays(7))
                ->orderBy('date', 'desc')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function($attendance) {
                    return [
                        'id' => $attendance->attendance_id,
                        'date' => $attendance->date,
                        'subject_name' => $attendance->instructorClass->class->subject->name ?? 'N/A',
                        'class_name' => $attendance->instructorClass->class->name ?? 'N/A',
                        'status' => $attendance->status,
                        'time_in' => $attendance->time_in,
                        'time_out' => $attendance->time_out,
                        'updated_at' => $attendance->updated_at->format('F d, Y h:i A'),
                    ];
                });

            // Calculate recent attendance statistics
            $totalDays = $attendances->count();
            $presentDays = $attendances->where('status', 'present')->count();
            $absentDays = $attendances->where('status', 'absent')->count();
            $lateDays = $attendances->where('status', 'late')->count();
            
            $attendanceRate = $totalDays > 0 ? round(($presentDays / $totalDays) * 100, 2) : 0;

            return response()->json([
                'success' => true,
                'attendances' => $attendances,
                'statistics' => [
                    'total_days' => $totalDays,
                    'present_days' => $presentDays,
                    'absent_days' => $absentDays,
                    'late_days' => $lateDays,
                    'attendance_rate' => $attendanceRate,
                ],
                'timestamp' => now()->toIso8601String()
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching student attendance', [
                'error' => $e->getMessage(),
                'student_id' => $request->input('student_id')
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching attendance records.'
            ], 500);
        }
    }
}
