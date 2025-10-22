<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\CoreValue;
use App\Models\Instructor;
use Illuminate\Http\Request;
use App\Models\InstructorClass;
use App\Models\CoreValueEvaluation;
use Illuminate\Support\Facades\Auth;

class InstructorStudentGradeController extends Controller
{
    // InstructorStudentGradeController.php

    /**
     * Display grade input form for instructors
     */
    public function gradeInput(Request $request)
    {
        // 1) Load the instructor and their classes
        $instructor = Instructor::with([
            'instructorClasses.class.subject',
            'instructorClasses.class.section',
        ])
        ->where('user_id', Auth::id())
        ->firstOrFail();

        $firstClass = $instructor->instructorClasses->first();
        if (!$firstClass) {
            return view('instructor_grade_input', [
                'instructor' => $instructor,
                'iclass' => null,
                'rows' => collect(),
                'error' => 'No classes assigned to this instructor.'
            ]);
        }
        
        $classId = $request->query('class_id', $firstClass->id);
        $ic = $instructor->instructorClasses
            ->firstWhere('id', $classId);

        // 2) Build rows for the student table
        $rows = collect();
        $class   = $ic->class;
        $subject = $class->subject;
        $students = Student::where('section_id', $class->section_id)->get();

        foreach ($students as $student) {
            $grade = Grade::firstOrNew([
                'student_id' => $student->student_id,
                'class_id'   => $class->id,
                'subject_id' => $subject->id,
            ]);
            $rows->push(compact('student','class','subject','grade'));
        }

        return view('instructor_grade_input', [
            'instructor'  => $instructor,
            'iclass'      => $ic,
            'rows'        => $rows,
        ]);
    }

    public function gradeSheet(Request $request)
    {
        // 1) Load the instructor and their classes (unchanged)
        $instructor = Instructor::with([
            'instructorClasses.class.subject',
            'instructorClasses.class.section',
        ])
        ->where('user_id', Auth::id())
        ->firstOrFail();

        $firstClass = $instructor->instructorClasses->first();
        if (!$firstClass) {
            // Return view with empty data instead of redirecting
            return view('instructor_report', [
                'instructor' => $instructor,
                'iclass' => null,
                'rows' => collect(),
                'coreStudent' => null,
                'coreValues' => collect(),
                'evaluations' => collect(),
                'classes' => collect(),
                'subjects' => collect(),
                'error' => 'No classes assigned to this instructor.'
            ]);
        }
        
        $classId = $request->query('class_id', $firstClass->id);
        $ic = $instructor->instructorClasses
            ->firstWhere('id', $classId);

        // 2) Build your $rows for the student table (unchanged)
        $rows = collect();
        $class   = $ic->class;
        $subject = $class->subject;
        $students = Student::where('section_id', $class->section_id)->get();

        foreach ($students as $student) {
            $grade = Grade::firstOrNew([
                'student_id' => $student->student_id,
                'class_id'   => $class->id,
                'subject_id' => $subject->id,
            ]);
            $rows->push(compact('student','class','subject','grade'));
        }

        // 3) Determine which student to evaluate for Core Values
        //    Use ?student=ID in the URL, or default to the first student in $rows
        $studentId = $request->query(
            'student',
            $rows->first()['student']->student_id ?? null
        );
        $coreStudent = $studentId
            ? Student::where('student_id', $studentId)->first()
            : null;

        // 4) Load all Core Values and that student’s existing scores
        $coreValues  = CoreValue::all();
        $evaluations = $coreStudent
            ? CoreValueEvaluation::where('student_id', $coreStudent->student_id)
                ->pluck('score','core_value_id')
            : collect();

        // 5) Get all classes and subjects for the dropdown filters
        $classes = $instructor->instructorClasses->map(function($ic) {
            return (object)[
                'id' => $ic->id,
                'name' => $ic->class->name ?? 'N/A',
                'code' => $ic->class->code ?? '',
                'subject' => $ic->class->subject->name ?? 'N/A',
                'section' => $ic->class->section->section_name ?? 'N/A',
            ];
        });
        
        $subjects = $instructor->instructorClasses
            ->pluck('class.subject')
            ->filter()
            ->unique('id')
            ->values();

        // 6) Get all grades for this instructor's classes
        $classIds = $instructor->instructorClasses->pluck('class_id');
        $grades = Grade::whereIn('class_id', $classIds)
            ->with(['student', 'schoolClass', 'subjectRelation'])
            ->get()
            ->map(function($grade) {
                // Map to ensure proper structure for the view
                $grade->subject = $grade->subjectRelation;
                $grade->class = $grade->schoolClass;
                return $grade;
            });

        // 7) Pass everything into the same view
        return view('instructor_report', [
            'instructor'  => $instructor,
            'iclass'      => $ic,
            'rows'        => $rows,
            'coreStudent'=> $coreStudent,
            'coreValues'  => $coreValues,
            'evaluations' => $evaluations,
            'classes'     => $classes,
            'subjects'    => $subjects,
            'grades'      => $grades,
        ]);
    }


  
    // save one grade record (create or update) with enhanced validation
    public function saveGrade(Request $req)
    {
        try {
            // Enhanced validation with 70-100 range for passing grades
            // Custom validation to allow partial quarter grades
            $validationRules = [
                'grade_id'      => 'nullable|exists:grades,id',
                'student_id'    => 'required|exists:students,student_id',
                'class_id'      => 'required|exists:classes,id',
                'subject_id'    => 'required|exists:subjects,id',
                'first_quarter' => 'nullable|numeric|min:0|max:100',
                'second_quarter'=> 'nullable|numeric|min:0|max:100',
                'third_quarter' => 'nullable|numeric|min:0|max:100',
                'fourth_quarter'=> 'nullable|numeric|min:0|max:100',
            ];
            
            $customMessages = [
                '*.min' => 'Grade cannot be negative.',
                '*.max' => 'Grade cannot exceed 100.',
                '*.numeric' => 'Grade must be a valid number.',
            ];
            
            $data = $req->validate($validationRules, $customMessages);
            
            // Validate that at least one quarter has a grade
            // Check if any quarter has a non-null, non-empty value
            $hasAnyGrade = (isset($data['first_quarter']) && $data['first_quarter'] !== '' && $data['first_quarter'] !== null) ||
                          (isset($data['second_quarter']) && $data['second_quarter'] !== '' && $data['second_quarter'] !== null) ||
                          (isset($data['third_quarter']) && $data['third_quarter'] !== '' && $data['third_quarter'] !== null) ||
                          (isset($data['fourth_quarter']) && $data['fourth_quarter'] !== '' && $data['fourth_quarter'] !== null);
            
            if (!$hasAnyGrade) {
                return response()->json([
                    'success' => false,
                    'message' => 'At least one quarter grade must be provided.',
                    'errors' => ['general' => ['At least one quarter grade is required.']]
                ], 422);
            }
        
            // Calculate final grade (average of all quarters with grades)
            $quarters = array_filter([
                $data['first_quarter'] ?? null,
                $data['second_quarter'] ?? null,
                $data['third_quarter'] ?? null,
                $data['fourth_quarter'] ?? null
            ], function($val) { return $val !== null; });
            
            $finalGrade = count($quarters) > 0 ? array_sum($quarters) / count($quarters) : null;
            // Get subject name for legacy 'subject' column
            $subject = \App\Models\Subject::find($data['subject_id']);
            $subjectName = $subject ? $subject->name : 'N/A';
        
            // Find or create the grade record
            $grade = Grade::firstOrNew([
                'student_id' => $data['student_id'],
                'class_id'   => $data['class_id'],
                'subject_id' => $data['subject_id']
            ]);
            
            // Update only the quarters that have values (preserve existing grades for empty quarters)
            $grade->subject = $subjectName; // Legacy column
            
            if (isset($data['first_quarter']) && $data['first_quarter'] !== '' && $data['first_quarter'] !== null) {
                $grade->first_quarter = $data['first_quarter'];
            }
            if (isset($data['second_quarter']) && $data['second_quarter'] !== '' && $data['second_quarter'] !== null) {
                $grade->second_quarter = $data['second_quarter'];
            }
            if (isset($data['third_quarter']) && $data['third_quarter'] !== '' && $data['third_quarter'] !== null) {
                $grade->third_quarter = $data['third_quarter'];
            }
            if (isset($data['fourth_quarter']) && $data['fourth_quarter'] !== '' && $data['fourth_quarter'] !== null) {
                $grade->fourth_quarter = $data['fourth_quarter'];
            }
            
            // Recalculate final grade based on all available quarters
            $allQuarters = array_filter([
                $grade->first_quarter,
                $grade->second_quarter,
                $grade->third_quarter,
                $grade->fourth_quarter
            ], function($val) { return $val !== null && $val !== ''; });
            
            $grade->final_grade = count($allQuarters) > 0 ? array_sum($allQuarters) / count($allQuarters) : null;
            $grade->updated_at = now(); // Explicit timestamp for real-time sync
            $grade->save();
            
            \Log::info('Grade saved successfully', [
                'student_id' => $data['student_id'],
                'subject_id' => $data['subject_id'],
                'final_grade' => $finalGrade,
                'timestamp' => now()
            ]);
        
            return response()->json([
                'success' => true,
                'message' => 'Grade saved successfully! Students can now view this grade in real-time.',
                'grade' => [
                    'id' => $grade->id,
                    'first_quarter' => $grade->first_quarter,
                    'second_quarter' => $grade->second_quarter,
                    'third_quarter' => $grade->third_quarter,
                    'fourth_quarter' => $grade->fourth_quarter,
                    'final_grade' => $grade->final_grade,
                    'updated_at' => $grade->updated_at->format('F d, Y h:i A'),
                    'date_submitted' => $grade->updated_at->toDateTimeString(),
                ],
                'timestamp' => now()->toIso8601String()
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error saving grade', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving the grade. Please try again.'
            ], 500);
        }
    }
    
    /**
     * API endpoint to get student grades in real-time
     * Used by students to fetch their latest grades
     */
    public function getStudentGrades(Request $request)
    {
        try {
            $studentId = $request->input('student_id');
            
            if (!$studentId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Student ID is required'
                ], 400);
            }

            $grades = Grade::where('student_id', $studentId)
                ->with(['subjectModel', 'schoolClass'])
                ->orderBy('updated_at', 'desc')
                ->get()
                ->map(function($grade) {
                    return [
                        'id' => $grade->id,
                        'subject_name' => $grade->subjectModel->name ?? 'N/A',
                        'subject_code' => $grade->subjectModel->code ?? 'N/A',
                        'class_name' => $grade->schoolClass->name ?? 'N/A',
                        'first_quarter' => $grade->first_quarter,
                        'second_quarter' => $grade->second_quarter,
                        'third_quarter' => $grade->third_quarter,
                        'fourth_quarter' => $grade->fourth_quarter,
                        'final_grade' => $grade->final_grade,
                        'updated_at' => $grade->updated_at->format('F d, Y h:i A'),
                        'status' => ($grade->final_grade ?? 0) >= 75 ? 'Passed' : 'Failed',
                    ];
                });

            return response()->json([
                'success' => true,
                'grades' => $grades,
                'timestamp' => now()->toIso8601String()
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching student grades', [
                'error' => $e->getMessage(),
                'student_id' => $request->input('student_id')
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching grades.'
            ], 500);
        }
    }

   public function saveEvaluations(Request $request)
    {
    $data = $request->validate([
        'student_id'      => 'required|exists:students,student_id',
        'scores'          => 'required|array',
        'scores.*'        => 'nullable|numeric|min:0|max:100',
    ]);
    $studentId = $data['student_id'];

    foreach ($data['scores'] as $cvId => $score) {
        CoreValueEvaluation::updateOrCreate(
        ['student_id'    => $studentId,
        'core_value_id' => $cvId],
        ['score'=>$score]
        );
    }
    return back()->with('success','Core values saved.');
    }


    
}
