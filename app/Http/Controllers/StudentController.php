<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Strands;
use App\Models\Student;
use App\Models\StudentId;
use App\Models\GradeLevel;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\StudentStatus;
use App\Models\StudentSection;
use Illuminate\Validation\Rule;
use App\Models\NewStudentEnrollee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class StudentController extends Controller
{
    protected function getCommonData(): array
    {
       $enrolledId = StudentStatus::where('name', 'Enrolled')->value('id');

        return [
            
            'gradeLevels'     => GradeLevel::orderBy('grade_level_id')->get(),

            'allStrands'      => Strands::orderBy('name')->get(),

            'student_section' => StudentSection::all(),

            'students'       => Student::with(['studentId','status'])
                                   ->where('status_id', $enrolledId)
                                   ->get(),

            // only needed on the admin form
            'student_status'  => StudentStatus::all(),
        ];
    }

    public function getEnrolleeByAppNum($appNum)
    {
        $enrollee = NewStudentEnrollee::where('application_number', $appNum)
                    ->first(['surname','given_name','middle_name','email','dob','contact_no','address','id_picture_path']);
        if (! $enrollee) {
            return response()->json(['error'=>'Not found'], 404);
        }

        return response()->json([
            'surname'      => $enrollee->surname,
            'given_name'   => $enrollee->given_name,
            'middle_name'  => $enrollee->middle_name,
            'email'        => $enrollee->email,
            'dob'          => $enrollee->dob,
            'contact_no'   => $enrollee->contact_no,
            'address'      => $enrollee->address,
            'id_picture_path' => $enrollee->id_picture_path,
        ]);
    }


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
        
        Log::debug('Student form submitted', $request->all());
        // 1) Validate only the student’s personal & enrollment info (no username)
        try {
            $validated = Validator::make($request->all(), [
                'fname'              => ['required','string','max:255'],
                'mname'              => ['nullable','string','max:255'],
                'lname'              => ['required','string','max:255'],
                'suffix'             => ['nullable','string','max:10'],
                'gender'             => ['required', Rule::in(['Male','Female'])],
                'dob'                => ['required','date'],
                'contact'            => ['nullable','string'],
                'email'              => ['required','email','unique:users,email'],
                'address'            => ['nullable','string'],
                'grade_level_id'     => ['required', Rule::exists('grade_level','grade_level_id')],
                'strand_id'          => ['nullable', Rule::exists('strands','id')],
                'status_id'          => ['nullable', Rule::exists('status','id')],
                'section_id'         => ['nullable', Rule::exists('section','id')],
                'date_enrolled'      => ['required','date'],
                'semester'           => ['nullable','in:1st,2nd'],
                'student_school_id'  => ['required', Rule::exists('new_student_enrollees','application_number')],
            ])->validate();
        } catch (ValidationException $e) {
            Log::error('Validation failed:', $e->errors());
            return back()->withErrors($e->errors())->withInput();
        }
        
        Log::debug('Validation passed. Proceeding...');

        $enrollee = NewStudentEnrollee::where('application_number', $validated['student_school_id'])
                ->firstOrFail([
                'id_picture_path',  // we only need the picture
                ]);

        // 2) Ensure or create the official school-ID record
        $sid = StudentId::firstOrCreate([
            'student_number' => $validated['student_school_id'],
        ]);

        // Prevent duplicate school-ID assignment
        if (Student::where('student_school_id', $sid->id)->exists()) {
            return back()
                ->withErrors(['student_school_id' => 'That school ID is already assigned.'])
                ->withInput();
        }

        // 4) Generate credentials
        $base          = Str::lower(substr($validated['fname'],0,1).$validated['lname']);
        $username      = $base . rand(100,999);
        $passwordPlain = Str::lower($validated['lname']).date('Ymd', strtotime($validated['dob']));

        try {
            DB::transaction(function() use ($validated, $sid, $enrollee, $username, $passwordPlain) {
                Log::debug('Inside transaction, before user create');

                $user = User::create([
                    'username'  => $username,
                    'name'      => "{$validated['fname']} {$validated['lname']}",
                    'email'     => $validated['email'],
                    'user_type' => 'student',
                    'password'  => Hash::make($passwordPlain),
                ]);

                Log::debug('User created', ['id' => $user->user_id]);

                $student = Student::create([
                    'user_id'            => $user->user_id,
                    'first_name'         => $validated['fname'],
                    'middle_name'        => $validated['mname'],
                    'last_name'          => $validated['lname'],
                    'suffix'             => $validated['suffix'],
                    'picture'            => $enrollee->id_picture_path,
                    'gender'             => $validated['gender'],
                    'date_of_birth'      => $validated['dob'],
                    'contact_number'     => $validated['contact'],
                    'email'              => $validated['email'],
                    'address'            => $validated['address'],
                    'grade_level_id'     => $validated['grade_level_id'],
                    'strand_id'          => $validated['strand_id'] ?? null,
                    'status_id'          => $validated['status_id'] ?? null,
                    'section_id'         => $validated['section_id'] ?? null,
                    'date_enrolled'      => $validated['date_enrolled'],
                    'semester'           => $validated['semester'] ?? null,
                    'student_school_id'  => $sid->id,
                ]);

                Log::debug('Student created', ['id' => $student->student_id]);
            });
        } catch (\Throwable $e) {
            Log::error('Error creating student & user', [
                'exception' => $e->getMessage()
            ]);

            return back()
                ->withErrors(['general' => 'There was an error saving the student.'])
                ->withInput();
        }
                    
        $msg  = "Student {$validated['fname']} added successfully.\n";
        $msg .= "Username: {$username}\n";
        $msg .= "Password: {$passwordPlain}";
        
        return redirect()
        ->route('admin.classes', [
            'new_username' => $username,
            'new_password' => $passwordPlain,
        ]);

    }

    
    public function showStudentList($gradeLevelId, $sectionId)
    {
        // Fetch grade level, strand, and section details
        $gradeLevel = GradeLevel::find($gradeLevelId); // Single grade level
        $section = StudentSection::find($sectionId); // Single section
        $strand = Strands::find($section->strand_id); // Single strand

        $enrolledStatus = StudentStatus::where('name', 'Enrolled')->firstOrFail();
   
        $students = Student::with(['studentId','status'])
            ->where('grade_level_id', $gradeLevelId)
            ->where('section_id',   $sectionId)
            ->where('status_id',    $enrolledStatus->id)
            ->get();

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

    public function approveStudent($id)
    {
        $student = Student::findOrFail($id);

        // Optionally check if they already have a student_number
        if (!$student->studentId) {
            // Generate or assign a student_number
            $studentNumber = 'S' . str_pad($id, 5, '0', STR_PAD_LEFT); // Example: S00001

            // Save it to student_ids table (assuming relation is studentId)
            $student->studentId()->create([
                'student_number' => $studentNumber
            ]);
        }

        // Optionally insert into old/new enrollee tables here

        // Optionally update status if you're using a status_id column
        $student->status_id = 1; // Assuming 1 = Enrolled
        $student->save();

        return back()->with('success', 'Student approved successfully.');
    }

    public function resetEnrollment()
    {
        // First, get the ID of the "Not Enrolled" status
        $notEnrolledId = DB::table('status')->where('name', 'Not Enrolled')->value('id');

        // Then, update all students to that status
        Student::query()->update(['status_id' => $notEnrolledId]);

        return redirect()->back()->with('success', 'All students have been set to Not Enrolled.');
    }


}
