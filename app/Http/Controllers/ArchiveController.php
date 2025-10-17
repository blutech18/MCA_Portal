<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\ArchivedStudent;
use App\Models\ArchivedGrade;
use App\Models\ArchivedAttendance;
use App\Models\AcademicYear;
use App\Models\ArchiveLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ArchiveController extends Controller
{
    /**
     * Display the archive page with year selector
     */
    public function index(Request $request)
    {
        // Ensure we have academic years
        if (AcademicYear::count() === 0) {
            AcademicYear::getOrCreateCurrentAcademicYear();
        }
        
        $academicYears = AcademicYear::orderBy('start_date', 'desc')->get();
        $currentAcademicYear = AcademicYear::getCurrentAcademicYear();

        $selectedYear = $request->input('year', $currentAcademicYear->year_name ?? null);
        $isCurrentYear = ($selectedYear === ($currentAcademicYear->year_name ?? null));

        $students = collect();
        $sections = collect();
        $gradeLevels = collect();

        if ($isCurrentYear) {
            // Display live data for the current academic year
            $students = Student::with(['gradeLevel', 'strand', 'section', 'status', 'studentId'])
                ->orderBy('last_name')
                ->get();
            $sections = \App\Models\StudentSection::orderBy('section_name')->get();
            $gradeLevels = \App\Models\GradeLevel::orderBy('grade_level_id')->get();
        } else {
            // Display archived data for historical years
            $students = ArchivedStudent::where('academic_year', $selectedYear)
                ->with(['grades', 'attendance'])
                ->orderBy('last_name')
                ->get();
            // For archived data, sections and grade levels are derived from archived students
            $sections = $students->pluck('section_name')->unique()->map(fn($name) => (object)['section_name' => $name]);
            $gradeLevels = $students->pluck('grade_level_name')->unique()->map(fn($name) => (object)['name' => $name]);
        }

        return view('admin_archive', compact('academicYears', 'currentAcademicYear', 'selectedYear', 'students', 'sections', 'gradeLevels', 'isCurrentYear'));
    }
    
    /**
     * Get students for selected year (current or archived)
     */
    public function getStudentsByYear(Request $request, $year)
    {
        $currentAcademicYear = AcademicYear::getCurrentAcademicYear();
        
        // Redirect to archive page with selected year
        return redirect()->route('admin.archive', ['year' => $year])
            ->with('success', "Viewing students for academic year: {$year}");
    }
    
    /**
     * Get student details for viewing
     */
    public function getStudentDetails(Request $request, $id)
    {
        $isCurrent = $request->input('current', false);
        
        if ($isCurrent) {
            // Get current student details using student_id as primary key
            $student = Student::with(['gradeLevel', 'strand', 'section', 'status', 'studentId', 'grades.subjectRelation', 'attendances'])
                ->where('student_id', $id)
                ->firstOrFail();
        } else {
            // Get archived student details using default id field
            $student = ArchivedStudent::with(['grades', 'attendance'])
                ->findOrFail($id);
        }
        
        return response()->json($student);
    }
    
    /**
     * Archive all current students to historical records
     */
    public function archiveCurrentYear(Request $request)
    {
        $currentAcademicYear = AcademicYear::getCurrentAcademicYear();

        if (!$currentAcademicYear) {
            return back()->with('error', 'No current academic year set.');
        }

        $studentsToArchive = Student::with(['gradeLevel', 'strand', 'section', 'status', 'grades', 'attendances', 'studentId'])->get();

        if ($studentsToArchive->isEmpty()) {
            return back()->with('info', 'No students to archive for the current academic year.');
        }

        DB::beginTransaction();
        try {
            $archivedCount = 0;
            foreach ($studentsToArchive as $student) {
                $archivedStudent = ArchivedStudent::create([
                    'original_student_id' => $student->student_id,
                    'academic_year' => $currentAcademicYear->year_name,
                    'school_student_id' => $student->studentId->student_number ?? null,
                    'first_name' => $student->first_name,
                    'middle_name' => $student->middle_name,
                    'last_name' => $student->last_name,
                    'suffix' => $student->suffix,
                    'lrn' => $student->lrn,
                    'picture' => $student->picture,
                    'gender' => $student->gender,
                    'date_of_birth' => $student->date_of_birth,
                    'contact_number' => $student->contact_number,
                    'email' => $student->email,
                    'address' => $student->address,
                    'grade_level_id' => $student->grade_level_id,
                    'grade_level_name' => $student->gradeLevel->name ?? 'N/A',
                    'section_id' => $student->section_id,
                    'section_name' => $student->section->section_name ?? 'N/A',
                    'strand_id' => $student->strand_id ?? $student->section->strand_id,
                    'strand_name' => $student->strand->name ?? $student->section->strand->name ?? null,
                    'status' => $student->status->name ?? 'N/A',
                    'date_enrolled' => $student->date_enrolled,
                    'archived_at' => now(),
                    'archived_by' => Auth::id(),
                ]);

                foreach ($student->grades as $grade) {
                    ArchivedGrade::create([
                        'archived_student_id' => $archivedStudent->id,
                        'academic_year' => $currentAcademicYear->year_name,
                        'subject_name' => $grade->subjectRelation->name ?? $grade->subject,
                        'first_quarter' => $grade->first_quarter,
                        'second_quarter' => $grade->second_quarter,
                        'third_quarter' => $grade->third_quarter,
                        'fourth_quarter' => $grade->fourth_quarter,
                        'final_grade' => $grade->final_grade,
                    ]);
                }

                foreach ($student->attendances as $attendance) {
                    ArchivedAttendance::create([
                        'archived_student_id' => $archivedStudent->id,
                        'academic_year' => $currentAcademicYear->year_name,
                        'date' => $attendance->date,
                        'status' => $attendance->status,
                        'remarks' => $attendance->remarks,
                    ]);
                }
                $archivedCount++;
            }

            // Log the archive action
            ArchiveLog::create([
                'user_id' => Auth::id(),
                'action' => 'archive_current_year',
                'academic_year' => $currentAcademicYear->year_name,
                'details' => 'Archived ' . $archivedCount . ' students from the current academic year.',
                'student_count' => $archivedCount,
            ]);

            // Optionally, clear the current students table or mark them as inactive
            // For now, we'll just archive and keep current students active.

            DB::commit();
            return back()->with('success', "Successfully archived {$archivedCount} students for {$currentAcademicYear->year_name}.");
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Archive Current Year Failed: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->with('error', 'Failed to archive students. An error occurred.');
        }
    }
    
    /**
     * Restore archived student to active students
     */
    public function restoreStudent($id)
    {
        $archivedStudent = ArchivedStudent::findOrFail($id);
        
        // Check if student already exists in current students
        $existingStudent = Student::where('school_student_id', $archivedStudent->school_student_id)->first();
        if ($existingStudent) {
            return back()->with('error', 'Student already exists in current students.');
        }
        
        // Create new student record
        $student = Student::create([
            'school_student_id' => $archivedStudent->school_student_id,
            'first_name' => $archivedStudent->first_name,
            'middle_name' => $archivedStudent->middle_name,
            'last_name' => $archivedStudent->last_name,
            'suffix' => $archivedStudent->suffix,
            'lrn' => $archivedStudent->lrn,
            'email' => $archivedStudent->email,
            'contact_number' => $archivedStudent->contact_number,
            'address' => $archivedStudent->address,
            'date_of_birth' => $archivedStudent->date_of_birth,
            'gender' => $archivedStudent->gender,
            'grade_level_id' => $archivedStudent->grade_level_id,
            'strand_id' => $archivedStudent->strand_id,
            'section_id' => $archivedStudent->section_id,
            'date_enrolled' => now(),
        ]);
        
        // Log the restore action
        ArchiveLog::logAction(
            $archivedStudent->academic_year,
            'restore_student',
            1,
            "Restored student {$archivedStudent->full_name} from {$archivedStudent->academic_year}"
        );
        
        return back()->with('success', "Student {$archivedStudent->full_name} restored successfully.");
    }
    
    /**
     * Export year data as CSV
     */
    public function exportYearData($year)
    {
        $currentYear = AcademicYear::getCurrent();
        
        if ($year === 'current' || ($currentYear && $year === $currentYear->year_name)) {
            $students = Student::with(['gradeLevel', 'section', 'strand', 'grades'])->get();
            $isCurrentYear = true;
        } else {
            $students = ArchivedStudent::where('academic_year', $year)->with('grades')->get();
            $isCurrentYear = false;
        }
        
        $filename = "students_{$year}_" . date('Y-m-d') . ".csv";
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($students, $isCurrentYear) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'Student ID', 'Name', 'Email', 'Contact Number', 'Grade Level', 
                'Section', 'Strand', 'Status', 'Date Enrolled'
            ]);
            
            foreach ($students as $student) {
                if ($isCurrentYear) {
                    fputcsv($file, [
                        $student->school_student_id,
                        $student->full_name,
                        $student->email,
                        $student->contact_number,
                        $student->gradeLevel ? $student->gradeLevel->name : 'Unknown',
                        $student->section ? $student->section->section_name : 'N/A',
                        $student->strand->name ?? ($student->section->strand->name ?? 'N/A'),
                        $student->status ? $student->status->name : 'Unknown',
                        $student->date_enrolled,
                    ]);
                } else {
                    fputcsv($file, [
                        $student->school_student_id,
                        $student->full_name,
                        $student->email,
                        $student->contact_number,
                        $student->grade_level_name,
                        $student->section_name ?? 'N/A',
                        $student->strand_name ?? 'N/A',
                        $student->status,
                        $student->date_enrolled,
                    ]);
                }
            }
            
            fclose($file);
        };
        
        // Log the export action
        ArchiveLog::logAction($year, 'export_data', $students->count(), "Exported {$students->count()} students for {$year}");
        
        return response()->stream($callback, 200, $headers);
    }
    
    /**
     * Get year-over-year statistics
     */
    public function getYearComparison()
    {
        $years = AcademicYear::orderBy('start_date', 'desc')->take(5)->get();
        
        $comparison = [];
        foreach ($years as $year) {
            if ($year->is_current) {
                $count = Student::count();
                $gradeDistribution = Student::select('grade_level_id', DB::raw('count(*) as count'))
                    ->groupBy('grade_level_id')
                    ->get()
                    ->map(function($item) {
                        $gradeLevel = \App\Models\GradeLevel::find($item->grade_level_id);
                        $gradeName = $gradeLevel ? $gradeLevel->name : "Grade {$item->grade_level_id}";
                        
                        // Clean up grade name - remove "Grade " prefix if it exists
                        if (strpos($gradeName, 'Grade ') === 0) {
                            $gradeName = substr($gradeName, 6);
                        }
                        
                        return (object)[
                            'grade_level_id' => $item->grade_level_id,
                            'count' => $item->count,
                            'gradeLevel' => (object)['name' => $gradeName]
                        ];
                    });
            } else {
                $count = ArchivedStudent::where('academic_year', $year->year_name)->count();
                $gradeDistribution = ArchivedStudent::where('academic_year', $year->year_name)
                    ->select('grade_level_id', DB::raw('count(*) as count'))
                    ->groupBy('grade_level_id')
                    ->get()
                    ->map(function($item) {
                        $gradeName = $item->grade_level_name ?? 'Unknown';
                        
                        // Clean up grade name - remove "Grade " prefix if it exists
                        if (strpos($gradeName, 'Grade ') === 0) {
                            $gradeName = substr($gradeName, 6);
                        }
                        
                        return (object)[
                            'grade_level_id' => $item->grade_level_id,
                            'count' => $item->count,
                            'gradeLevel' => (object)['name' => $gradeName]
                        ];
                    });
            }
            
            $comparison[] = [
                'year' => $year->year_name,
                'total_students' => $count,
                'grade_distribution' => $gradeDistribution,
            ];
        }
        
        $comparison = collect($comparison);
        
        return view('admin_archive_comparison', compact('comparison', 'years'));
    }
    
    /**
     * Search within archived students
     */
    public function searchArchived(Request $request)
    {
        $query = $request->query('q');
        $year = $request->query('year');
        
        $currentYear = AcademicYear::getCurrent();
        $isCurrentYear = $year === 'current' || ($currentYear && $year === $currentYear->year_name);
        
        if ($isCurrentYear) {
            $students = Student::with(['gradeLevel', 'section', 'strand', 'status'])
                ->where(function($q) use ($query) {
                    $q->where('first_name', 'like', "%{$query}%")
                      ->orWhere('last_name', 'like', "%{$query}%")
                      ->orWhere('school_student_id', 'like', "%{$query}%")
                      ->orWhere('lrn', 'like', "%{$query}%");
                })
                ->orderBy('grade_level_id')
                ->orderBy('last_name')
                ->get();
        } else {
            $students = ArchivedStudent::where('academic_year', $year)
                ->where(function($q) use ($query) {
                    $q->where('first_name', 'like', "%{$query}%")
                      ->orWhere('last_name', 'like', "%{$query}%")
                      ->orWhere('school_student_id', 'like', "%{$query}%")
                      ->orWhere('lrn', 'like', "%{$query}%");
                })
                ->orderBy('grade_level_id')
                ->orderBy('last_name')
                ->get();
        }
        
        return response()->json([
            'students' => $students,
            'count' => $students->count(),
            'isCurrentYear' => $isCurrentYear
        ]);
    }
}