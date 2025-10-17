<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Instructor;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use App\Models\InstructorClass;
use App\Models\StudentSection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InstructorStudentController extends Controller
{
    /**
     * Display all students taught by the instructor (across all classes)
     */
    public function index(Request $request)
    {
        // Get view type from query parameter (default: 'all')
        $viewType = $request->query('view', 'all');
        
        // 1) Get the instructor
        $instructor = Instructor::with([
            'instructorClasses.class.gradeLevel',
            'instructorClasses.class.strand',
            'instructorClasses.class.section',
            'instructorClasses.class.subject',
        ])
        ->where('user_id', Auth::id())
        ->firstOrFail();

        if ($viewType === 'advisory') {
            return $this->showAdvisorySection($instructor, $request);
        } else {
            return $this->showAllStudents($instructor, $request);
        }
    }

    /**
     * Show all students the instructor teaches
     */
    private function showAllStudents($instructor, $request)
    {
        // 2) Get the sections where the instructor is teaching
        $sectionIds = $instructor
            ->instructorClasses
            ->pluck('class.section_id')
            ->filter()
            ->unique();

        // 3) Build query for students with filters
        $query = Student::whereIn('section_id', $sectionIds)
            ->with([
                'section.gradeLevel', 
                'status', 
                'gradeLevel',
                'strand'
            ]);

        // Apply filters
        if ($request->has('section') && $request->section != '') {
            $query->where('section_id', $request->section);
        }

        if ($request->has('grade_level') && $request->grade_level != '') {
            $query->where('grade_level_id', $request->grade_level);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('school_student_id', 'like', "%{$search}%");
            });
        }

        $students = $query->get();

        // Get subjects taught to each student
        $studentsWithSubjects = $students->map(function($student) use ($instructor) {
            $subjects = $instructor->instructorClasses
                ->where('class.section_id', $student->section_id)
                ->pluck('class.subject.name')
                ->filter()
                ->unique()
                ->values();
            
            $student->subjects_taught = $subjects;
            return $student;
        });

        // Get filter options
        $sections = StudentSection::whereIn('id', $sectionIds)->get();
        $gradeLevels = $students->pluck('gradeLevel')->filter()->unique('grade_level_id')->values();

        return view('instructor_students_all', [
            'students' => $studentsWithSubjects,
            'instructor' => $instructor,
            'sections' => $sections,
            'gradeLevels' => $gradeLevels,
            'filters' => $request->only(['section', 'grade_level', 'search']),
            'viewType' => 'all'
        ]);
    }

    /**
     * Show only advisory section students
     */
    private function showAdvisorySection($instructor, $request)
    {
        // Assuming instructor has an advisory_section_id field
        // If not, we'll use the first section they teach
        $advisorySectionId = $instructor->advisory_section_id 
            ?? $instructor->instructorClasses->first()?->class?->section_id ?? null;

        if (!$advisorySectionId) {
            return view('instructor_students_advisory', [
                'students' => collect(),
                'instructor' => $instructor,
                'section' => null,
                'viewType' => 'advisory',
                'error' => 'No advisory section assigned.'
            ]);
        }

        // Get advisory section details
        $section = StudentSection::with('gradeLevel', 'strand')->find($advisorySectionId);

        // Build query for advisory students
        $query = Student::where('section_id', $advisorySectionId)
            ->with([
                'section.gradeLevel',
                'status',
                'gradeLevel',
                'strand',
                'studentId'
            ]);

        // Apply search filter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('school_student_id', 'like', "%{$search}%");
            });
        }

        $students = $query->get();

        return view('instructor_students_advisory', [
            'students' => $students,
            'instructor' => $instructor,
            'section' => $section,
            'filters' => $request->only(['search']),
            'viewType' => 'advisory'
        ]);
    }

    /**
     * Get student details for modal/quick view
     */
    public function show($studentId)
    {
        $student = Student::with([
            'section.gradeLevel',
            'status',
            'gradeLevel',
            'strand',
            'studentId'
        ])->findOrFail($studentId);

        // Get instructor to verify they teach this student
        $instructor = Instructor::where('user_id', Auth::id())->firstOrFail();
        
        // Get grades for this student in instructor's classes
        $grades = Grade::where('student_id', $student->student_id)
            ->whereIn('class_id', $instructor->instructorClasses->pluck('class_id'))
            ->with('subjectRelation')
            ->get();
        
        // Map grades to include subject name properly
        $grades = $grades->map(function($grade) {
            return [
                'id' => $grade->id,
                'subject' => [
                    'id' => $grade->subject_id,
                    'name' => $grade->subjectRelation ? $grade->subjectRelation->name : ($grade->getRawOriginal('subject') ?? 'N/A')
                ],
                'class_id' => $grade->class_id,
                'subject_id' => $grade->subject_id,
                'first_quarter' => $grade->first_quarter,
                'second_quarter' => $grade->second_quarter,
                'third_quarter' => $grade->third_quarter,
                'fourth_quarter' => $grade->fourth_quarter,
                'final_grade' => $grade->final_grade,
            ];
        });

        return response()->json([
            'student' => $student,
            'grades' => $grades
        ]);
    }

    /**
     * Get subjects for a specific student (for grade input)
     */
    public function getStudentSubjects($studentId)
    {
        $instructor = Instructor::where('user_id', Auth::id())->firstOrFail();
        
        // Get the student's section
        $student = Student::findOrFail($studentId);
        
        // Get subjects that the instructor teaches to this student's section
        $subjects = $instructor->instructorClasses
            ->where('class.section_id', $student->section_id)
            ->pluck('class.subject')
            ->filter()
            ->unique('id')
            ->values()
            ->map(function($subject) {
                return [
                    'id' => $subject->id,
                    'name' => $subject->name,
                    'code' => $subject->code,
                    'is_default' => $subject->is_default ?? false
                ];
            });

        // Sort subjects: default subjects first, then alphabetically
        $subjects = $subjects->sortBy(function($subject) {
            return $subject['is_default'] ? 0 : 1;
        })->values();

        return response()->json($subjects);
    }

}
