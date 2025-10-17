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

        // Get all classes for dropdown
        $classes = $instructor->instructorClasses->map(function($iclass) {
            return [
                'id' => $iclass->id,
                'name' => $iclass->class->name ?? 'Unknown Class',
                'section' => $iclass->class->section->section_name ?? 'Unknown Section'
            ];
        });

        // Get date range for filtering
        $dateFrom = $req->query('date_from', Carbon::today()->subDays(7)->toDateString());
        $dateTo = $req->query('date_to', Carbon::today()->toDateString());
        $selectedClassId = $req->query('class_id');

        // Get attendance records based on filters
        $attendanceQuery = Attendance::with(['student', 'instructorClass.class'])
            ->whereHas('instructorClass', function($query) use ($instructor) {
                $query->where('instructor_id', $instructor->instructor_id);
            })
            ->whereBetween('date', [$dateFrom, $dateTo]);

        // Filter by class if selected
        if ($selectedClassId) {
            $attendanceQuery->where('instructor_class_id', $selectedClassId);
        }

        $attendances = $attendanceQuery->orderBy('date', 'desc')
            ->orderBy('student_id')
            ->get();

        // Debug: Log attendance data
        \Log::info('Attendance data loaded', [
            'instructor_id' => $instructor->instructor_id,
            'total_attendances' => $attendances->count(),
            'first_attendance' => $attendances->first() ? [
                'student_id' => $attendances->first()->student_id,
                'student_loaded' => $attendances->first()->student ? true : false,
                'student_name' => $attendances->first()->student ? $attendances->first()->student->first_name . ' ' . $attendances->first()->student->last_name : 'NULL'
            ] : null
        ]);

        // Calculate summary statistics
        $totalRecords = $attendances->count();
        $presentCount = $attendances->where('status', 'present')->count();
        $absentCount = $attendances->where('status', 'absent')->count();
        $lateCount = $attendances->where('status', 'late')->count();

        return view('instructor_attendance', compact(
            'instructor', 'classes', 'attendances', 'dateFrom', 'dateTo', 
            'selectedClassId', 'totalRecords', 'presentCount', 'absentCount', 'lateCount'
        ));
    }

    public function mark(Request $req)
    {
        $data = $req->validate([
            'student_id'          => 'required|exists:students,student_id',
            'instructor_class_id' => 'required|exists:instructor_classes,id',
            'date'                => 'required|date',
            'status'              => 'required|in:present,absent,late',
            'time_in'             => 'nullable|date_format:H:i',
            'time_out'            => 'nullable|date_format:H:i',
        ]);

        Attendance::updateOrCreate(
            [
                'student_id'          => $data['student_id'],
                'instructor_class_id' => $data['instructor_class_id'],
                'date'                => $data['date'],
            ],
            [
                'status' => $data['status'],
                'time_in' => $data['time_in'] ?? null,
                'time_out' => $data['time_out'] ?? null,
            ]
        );

        return response()->json(['success' => true, 'message' => 'Attendance updated successfully']);
    }

    public function markForm(Request $req)
    {
        $instructor = Instructor::with('instructorClasses.class.section')
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Get all classes for dropdown
        $classes = $instructor->instructorClasses->map(function($iclass) {
            return [
                'id' => $iclass->id,
                'name' => $iclass->class->name ?? 'Unknown Class',
                'section' => $iclass->class->section->section_name ?? 'Unknown Section'
            ];
        });

        // Get selected class and date
        $selectedClassId = $req->query('class_id', $instructor->instructorClasses->first()?->id);
        $selectedDate = $req->query('date', Carbon::today()->toDateString());

        $selectedClass = null;
        $students = collect();
        $existingAttendance = collect();

        if ($selectedClassId) {
            $selectedClass = $instructor->instructorClasses->where('id', $selectedClassId)->first();
            
            if ($selectedClass) {
                // Get students in the class section
                $students = Student::where('section_id', $selectedClass->class->section_id)
                    ->orderBy('last_name')
                    ->orderBy('first_name')
                    ->get();

                // Get existing attendance for this class and date
                $existingAttendance = Attendance::where('instructor_class_id', $selectedClassId)
                    ->where('date', $selectedDate)
                    ->get()
                    ->keyBy('student_id');
            }
        }

        return view('instructor_attendance_mark', compact(
            'instructor', 'classes', 'selectedClass', 'students', 
            'existingAttendance', 'selectedClassId', 'selectedDate'
        ));
    }

    public function bulkMark(Request $req)
    {
        try {
            // Custom validation for time fields
            $validator = \Validator::make($req->all(), [
                'instructor_class_id' => 'required|exists:instructor_classes,id',
                'date' => 'required|date',
                'attendance' => 'required|array',
                'attendance.*.student_id' => 'required|exists:students,student_id',
                'attendance.*.status' => 'required|in:present,absent,late',
                'attendance.*.time_in' => 'nullable|string',
                'attendance.*.time_out' => 'nullable|string',
            ]);

            // Add custom validation for time format only if time is provided
            $validator->after(function ($validator) use ($req) {
                $attendance = $req->input('attendance', []);
                foreach ($attendance as $index => $attendanceData) {
                    if (!empty($attendanceData['time_in']) && !preg_match('/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/', $attendanceData['time_in'])) {
                        $validator->errors()->add("attendance.{$index}.time_in", 'The time in must be in HH:MM format (e.g., 08:30).');
                    }
                    if (!empty($attendanceData['time_out']) && !preg_match('/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/', $attendanceData['time_out'])) {
                        $validator->errors()->add("attendance.{$index}.time_out", 'The time out must be in HH:MM format (e.g., 15:30).');
                    }
                }
            });

            if ($validator->fails()) {
                throw new \Illuminate\Validation\ValidationException($validator);
            }

            $data = $validator->validated();

            $instructor = Instructor::where('user_id', Auth::id())->firstOrFail();
            
            // Verify the instructor is assigned to this class
            $instructorClass = InstructorClass::where('id', $data['instructor_class_id'])
                ->where('instructor_id', $instructor->instructor_id)
                ->firstOrFail();

            $updated = 0;
            $created = 0;

            foreach ($data['attendance'] as $attendanceData) {
                // Clean up time values - set to null if empty
                $timeIn = !empty($attendanceData['time_in']) ? $attendanceData['time_in'] : null;
                $timeOut = !empty($attendanceData['time_out']) ? $attendanceData['time_out'] : null;
                
                $attendance = Attendance::updateOrCreate(
                    [
                        'student_id' => $attendanceData['student_id'],
                        'instructor_class_id' => $data['instructor_class_id'],
                        'date' => $data['date'],
                    ],
                    [
                        'status' => $attendanceData['status'],
                        'time_in' => $timeIn,
                        'time_out' => $timeOut,
                    ]
                );

                if ($attendance->wasRecentlyCreated) {
                    $created++;
                } else {
                    $updated++;
                }
            }

            return response()->json([
                'success' => true, 
                'message' => "Attendance recorded successfully! Created: {$created}, Updated: {$updated}"
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Attendance validation error', [
                'errors' => $e->errors(),
                'request_data' => $req->except(['_token'])
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            \Log::error('Attendance bulk mark error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $req->except(['_token'])
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving attendance. Please try again.'
            ], 500);
        }
    }
}
