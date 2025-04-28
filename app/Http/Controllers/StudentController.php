<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Strands;
use App\Models\Student;
use App\Models\StudentId;
use App\Models\GradeLevel;
use Illuminate\Http\Request;
use App\Models\StudentStatus;
use App\Models\StudentSection;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    protected function getCommonData(): array
    {
        return [
            // now always Eloquent models with grade_level_id & name
            'gradeLevels'     => GradeLevel::orderBy('grade_level_id')->get(),

            'allStrands'      => Strands::orderBy('name')->get(),

            'student_section' => StudentSection::all(),

            'students'        => Student::with(['studentId','status'])->get(),

            // only needed on the admin form
            'student_status'  => StudentStatus::all(),
        ];
    }

    /**
     * Show the Admin “Add Student” page.
     */
    public function create()
    {
        return view('admin_classes', $this->getCommonData());
    }

    public function index()
    {
        return view('students.index', $this->getCommonData());
    }

    public function getFilteredSections(Request $request)
    {
        $q = StudentSection::where('grade_level_id', $request->grade_level_id);

        if (in_array((int)$request->grade_level_id, [5, 6], true)) {
            if (! $request->strand_id) {
                return response()->json(['sections' => []]);
            }
            $q->where('strand_id', $request->strand_id);
        }

        return response()->json([
        'sections' => $q->get(['id','section_name'])
        ]);
    }



    public function store(Request $request)
    { 
        $validated = $request->validate([
            'username'           => ['required','exists:users,username'],
            'fname'              => ['required','string','max:255'],
            'mname'              => ['nullable','string','max:255'],
            'lname'              => ['required','string','max:255'],
            'suffix'             => ['nullable','string','max:10'],
            'gender'             => ['required', Rule::in(['Male','Female'])],
            'dob'                => ['required','date'],
            'contact'            => ['nullable','string'],
            'email'              => ['required','email'],
            'address'            => ['nullable','string'],
            'grade_level_id'     => ['required', Rule::exists('grade_level','grade_level_id')],
            'strand_id'          => ['nullable', Rule::exists('strands','id')],
            'status_id'          => ['nullable', Rule::exists('status','id')],
            'section_id'         => ['nullable', Rule::exists('section','id')],
            'date_enrolled'      => ['required','date'],
            'semester'           => ['nullable','in:1st,2nd'],
            'student_school_id'  => ['required', Rule::unique('student_id','student_number')],
        ]);

    
        // Check if user exists
        $user = User::where('username', $validated['username'])->firstOrFail();
        $userId = $user->getKey();  
        
        // Prevent reuse of the same user_id
        if (Student::where('user_id', $userId)->exists()) {
            return back()
                ->withErrors(['username' => 'This username is already assigned to another student.'])
                ->withInput();
        }
    
        // 4) Get or create the "official" school‑ID record
        $sid = StudentId::firstOrCreate([
            'student_number' => $validated['student_school_id'],
        ]);
    
        if (Student::where('student_school_id',$sid->id)->exists()) {
            return back()
                ->withErrors(['student_school_id'=>'That school ID is already assigned.'])
                ->withInput();
        } 

        $student = Student::create([
            'user_id'           => $userId,
            'first_name'        => $validated['fname'],
            'middle_name'       => $validated['mname'],
            'last_name'         => $validated['lname'],
            'suffix'            => $validated['suffix'],
            'gender'            => $validated['gender'],
            'date_of_birth'     => $validated['dob'],
            'contact_number'    => $validated['contact'],
            'email'             => $validated['email'],
            'address'           => $validated['address'],
            'grade_level_id'    => $validated['grade_level_id'],
            'strand_id'         => $validated['strand_id'] ?? null,
            'status_id'         => $validated['status_id'],
            'section_id'        => $validated['section_id'],
            'date_enrolled'     => $validated['date_enrolled'],
            'semester'          => $validated['semester'] ?? null,
            'student_school_id' => $sid->id,
        ]);

        Log::info('Created Student ID:', ['student_id' => $student->student_id]);
    
        return redirect()
            ->route('admin.classes')
            ->with('success','Student added successfully!');

    }

    public function checkUsername($username)
    {
        $user = User::where('username', $username)->first();
        
        if ($user) {
            return response()->json([
                'valid' => true,
                'user_id' => $user->user_id,
                'has_student' => $user->student()->exists(),
                'student_id' => optional($user->student)->student_id,
            ]);
        } else {
            return response()->json([
                'valid' => false,
                'message' => 'Username does not exist',
            ]);
        }
    }
    
    
    public function showStudentList($gradeLevelId, $sectionId)
    {
        // Fetch grade level, strand, and section details
        $gradeLevel = GradeLevel::find($gradeLevelId); // Single grade level
        $section = StudentSection::find($sectionId); // Single section
        $strand = Strands::find($section->strand_id); // Single strand
   
        $students = Student::where('grade_level_id', $gradeLevelId)
                            ->where('section_id', $sectionId)
                            ->get(); // Collection of students

        return view('student_list', compact('gradeLevel', 'strand', 'section', 'students'));
    }

    public function storeSection(Request $request)
    {
        $request->validate([
            'grade_level_id' => 'required|exists:grade_level,grade_level_id',
            'section_name' => 'required|string|max:255',
            'strand_id' => 'nullable|exists:strands,id',
        ]);

        // Create the section
        StudentSection::create([
            'grade_level_id' => $request->grade_level_id,
            'strand_id' => $request->strand_id,
            'section_name' => $request->section_name,
        ]);

        return redirect()->back()->with('success', 'Section added successfully.');
    }


}
