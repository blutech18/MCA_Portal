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
       $enrolledId = $this->getEnrolledStatusId();
       $notEnrolledId = StudentStatus::where('name', 'Not Enrolled')->value('id');

        return [
            
            'gradeLevels'     => GradeLevel::orderBy('grade_level_id')->get(),

            'allStrands'      => Strands::orderBy('name')->get(),

            'student_section' => StudentSection::with(['gradeLevel', 'strand'])->get(),

            'students'       => Student::with(['studentId','status'])
                                   ->get(), // Show all students regardless of status

            // only needed on the admin form
            'student_status'  => StudentStatus::all(),
        ];
    }

    /**
     * Get enrolled status ID
     */
    private function getEnrolledStatusId()
    {
        $status = StudentStatus::where('name', 'Enrolled')->first();
        return $status ? $status->id : 1; // Default to ID 1 if not found
    }

    /**
     * Get not enrolled status ID
     */
    private function getNotEnrolledStatusId()
    {
        $status = StudentStatus::where('name', 'Not Enrolled')->first();
        return $status ? $status->id : 2; // Default to ID 2 if not found
    }

    /**
     * Automatically assign a student to an appropriate section
     * 
     * @param int $gradeLevelId The grade level ID (7-12)
     * @param int|null $strandId The strand ID (for SHS only)
     * @return int|null The section ID or null if no section available
     */
    private function assignSectionToStudent($gradeLevelId, $strandId = null)
    {
        try {
            // First, find available sections for this grade level and strand
            $query = StudentSection::where('grade_level_id', $gradeLevelId);
            
            // For senior high school (grades 11-12), also filter by strand
            if ($gradeLevelId >= 11 && $strandId) {
                $query->where('strand_id', $strandId);
            }

            $availableSections = $query->get();

            // Auto-create default section if none exists
            if ($availableSections->isEmpty()) {
                Log::warning('No sections available for grade level: ' . $gradeLevelId . ', strand: ' . $strandId);
                Log::info('Auto-creating default section for grade level: ' . $gradeLevelId);
                
                $newSection = $this->createDefaultSection($gradeLevelId, $strandId);
                
                if ($newSection) {
                    Log::info('Default section created successfully', [
                        'section_id' => $newSection->id,
                        'section_name' => $newSection->section_name,
                        'grade_level_id' => $gradeLevelId,
                        'strand_id' => $strandId
                    ]);
                    
                    return $newSection->id;
                } else {
                    return null;
                }
            }

            // Find section with available capacity (max 25 students per section)
            foreach ($availableSections as $section) {
                $studentCount = Student::where('section_id', $section->id)
                    ->where('grade_level_id', $gradeLevelId)
                    ->count();

                Log::info('Checking section capacity', [
                    'section_id' => $section->id,
                    'section_name' => $section->section_name,
                    'grade_level_id' => $gradeLevelId,
                    'current_students' => $studentCount,
                    'max_capacity' => 25
                ]);

                if ($studentCount < 25) {
                    // Ensure classes exist for this section before assigning student
                    $existingClasses = \App\Models\SchoolClass::where('section_id', $section->id)
                        ->where('grade_level_id', $gradeLevelId)
                        ->count();

                    if ($existingClasses === 0) {
                        Log::info('No classes found for section; auto-creating default classes', [
                            'section_id' => $section->id,
                            'section_name' => $section->section_name,
                            'grade_level_id' => $gradeLevelId,
                            'strand_id' => $strandId,
                        ]);
                        $this->createDefaultClassesForSection($section, $gradeLevelId, $strandId);
                    }
                    
                    Log::info('Student assigned to section', [
                        'section_id' => $section->id,
                        'section_name' => $section->section_name,
                        'student_count_after' => $studentCount + 1
                    ]);
                    
                    return $section->id;
                }
            }

            // All sections are full - auto-create new section
            Log::warning('All sections are full for grade level: ' . $gradeLevelId . ', strand: ' . $strandId);
            Log::info('Auto-creating additional section due to capacity');
            
            $newSection = $this->createDefaultSection($gradeLevelId, $strandId, true);
            
            if ($newSection) {
                Log::info('Additional section created successfully', [
                    'section_id' => $newSection->id,
                    'section_name' => $newSection->section_name
                ]);
                
                return $newSection->id;
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Error assigning section to student: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Create a default section for a grade level
     */
    private function createDefaultSection($gradeLevelId, $strandId = null, $isAdditional = false)
    {
        try {
            $gradeLevel = GradeLevel::find($gradeLevelId);
            if (!$gradeLevel) {
                Log::error('Grade level not found: ' . $gradeLevelId);
                return null;
            }

            // Generate section name
            $sectionName = $gradeLevel->name;
            if ($strandId) {
                $strand = Strands::find($strandId);
                if ($strand) {
                    $sectionName .= '-' . $strand->name;
                }
            }
            
            if ($isAdditional) {
                // Find the next available letter for additional sections
                $existingSections = StudentSection::where('grade_level_id', $gradeLevelId)
                    ->where('strand_id', $strandId)
                    ->get();
                
                $letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
                $usedLetters = [];
                
                foreach ($existingSections as $section) {
                    if (preg_match('/-([A-H])$/', $section->section_name, $matches)) {
                        $usedLetters[] = $matches[1];
                    }
                }
                
                $nextLetter = null;
                foreach ($letters as $letter) {
                    if (!in_array($letter, $usedLetters)) {
                        $nextLetter = $letter;
                        break;
                    }
                }
                
                if ($nextLetter) {
                    $sectionName .= '-' . $nextLetter;
                } else {
                    $sectionName .= '-' . (count($existingSections) + 1);
                }
            }

            $section = StudentSection::create([
                'section_name' => $sectionName,
                'grade_level_id' => $gradeLevelId,
                'strand_id' => $strandId,
            ]);

            Log::info('Section created successfully', [
                'section_id' => $section->id,
                'section_name' => $section->section_name,
                'grade_level_id' => $gradeLevelId,
                'strand_id' => $strandId
            ]);

            // Create default classes for this section
            $this->createDefaultClassesForSection($section, $gradeLevelId, $strandId);

            return $section;
        } catch (\Exception $e) {
            Log::error('Error creating default section: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Create default classes for a newly created section
     * 
     * @param StudentSection $section The section to create classes for
     * @param int $gradeLevelId The grade level ID
     * @param int|null $strandId The strand ID (for SHS)
     */
    private function createDefaultClassesForSection($section, $gradeLevelId, $strandId = null)
    {
        try {
            // Get default subjects for this grade level
            $defaultSubjects = \App\Models\Subject::where('is_default', true)->get();
            
            if ($defaultSubjects->isEmpty()) {
                Log::warning('No default subjects found for section', [
                    'section_id' => $section->id,
                    'grade_level_id' => $gradeLevelId
                ]);
                return;
            }

            $createdClasses = [];

            foreach ($defaultSubjects as $subject) {
                // Create class name: "Subject Name - Section Name"
                $className = $subject->name . ' - ' . $section->section_name;
                
                $class = \App\Models\SchoolClass::create([
                    'name' => $className,
                    'code' => strtoupper(substr($subject->name, 0, 3)) . '-' . $section->id,
                    'subject_id' => $subject->id,
                    'grade_level_id' => $gradeLevelId,
                    'strand_id' => $strandId,
                    'section_id' => $section->id,
                    'semester' => '1st',
                    'room' => 'TBA'
                ]);

                $createdClasses[] = [
                    'class_id' => $class->id,
                    'class_name' => $className,
                    'subject_name' => $subject->name
                ];
            }

            Log::info('✅ AUTO-CREATED CLASSES FOR SECTION', [
                'section_id' => $section->id,
                'section_name' => $section->section_name,
                'grade_level_id' => $gradeLevelId,
                'strand_id' => $strandId,
                'classes_created' => count($createdClasses),
                'classes' => $createdClasses
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to create default classes for section', [
                'section_id' => $section->id,
                'grade_level_id' => $gradeLevelId,
                'strand_id' => $strandId,
                'error' => $e->getMessage()
            ]);
        }
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
        $gradeLevelId = (int)$request->grade_level_id;
        
        Log::info('getFilteredSections called', [
            'grade_level_id' => $gradeLevelId,
            'strand_id' => $request->strand_id
        ]);
        
        if (!$gradeLevelId) {
            return response()->json(['sections' => []]);
        }
        
        $q = StudentSection::where('grade_level_id', $gradeLevelId)
            ->where('is_active', true); // Only show active sections

        // For SHS (grades 11-12), require strand selection
        if (in_array($gradeLevelId, [11, 12], true)) {
            if (!$request->strand_id) {
                Log::info('SHS grade selected but no strand provided, returning empty sections');
                return response()->json(['sections' => []]);
            }
            $q->where('strand_id', $request->strand_id);
            Log::info('SHS sections filtered by strand', ['strand_id' => $request->strand_id]);
        }
        
        $sections = $q->orderBy('section_priority')
            ->get(['id','section_name']);
        
        Log::info('Sections retrieved', [
            'count' => $sections->count(),
            'sections' => $sections->toArray()
        ]);

        return response()->json([
            'sections' => $sections
        ]);
    }

    public function store(Request $request)
    {
        
        Log::debug('Student form submitted', $request->all());
        
        // Check if this is a manual student addition or enrollment-based addition
        $isManualAddition = !$request->has('student_school_id') || 
                           !NewStudentEnrollee::where('application_number', $request->student_school_id)->exists();
        
        // 1) Validate only the student's personal & enrollment info (no username)
        try {
            $validationRules = [
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
                'section_id'         => ['nullable', Rule::exists('section','id')], // Section is optional - will be auto-assigned if not provided
                'date_enrolled'      => ['required','date'],
                'semester'           => ['nullable','in:1st,2nd'],
            ];
            
            // Add different validation for manual vs enrollment-based addition
            if ($isManualAddition) {
                // For manual addition, validate section capacity only if section is provided
                $validationRules['student_school_id'] = ['nullable','string'];
                if ($request->section_id) {
                    $this->validateSectionCapacity($request->section_id, $request->grade_level_id);
                }
            } else {
                // For enrollment-based addition, must exist in enrollee table
                $validationRules['student_school_id'] = ['required', Rule::exists('new_student_enrollees','application_number')];
            }
            
            $validated = Validator::make($request->all(), $validationRules)->validate();
        } catch (ValidationException $e) {
            Log::error('Validation failed:', $e->errors());
            return back()->withErrors($e->errors())->withInput();
        }
        
        Log::debug('Validation passed. Proceeding with manual addition:', ['is_manual_addition' => $isManualAddition]);

        $enrollee = null;
        $picturePath = null; // Default picture for manual addition
        
        // Handle picture upload for manual addition
        if ($isManualAddition && $request->hasFile('picture')) {
            $file = $request->file('picture');
            $picturePath = $file->store('student_pictures', 'public');
            Log::info('Student picture uploaded', ['path' => $picturePath]);
        }
        
        // Only get enrollee data if this is enrollment-based addition
        if (!$isManualAddition) {
            $enrollee = NewStudentEnrollee::where('application_number', $validated['student_school_id'])
                    ->firstOrFail(['id_picture_path']);
            $picturePath = $enrollee->id_picture_path ?? $picturePath;
        }

        // 2) Ensure or generate the official school-ID record
        if ($isManualAddition && empty($validated['student_school_id'])) {
            // Generate a unique school student ID in the format 250000X (sequential numeric)
            // Find the highest existing numeric ID starting with 2500
            $lastNumericId = StudentId::where('student_number', 'LIKE', '2500%')
                ->where('student_number', 'REGEXP', '^[0-9]+$')  // Only numeric IDs
                ->orderBy('student_number', 'desc')
                ->value('student_number');
            
            if ($lastNumericId) {
                $nextNumber = (int)$lastNumericId + 1;
            } else {
                $nextNumber = 2500001; // Start from 2500001 if no existing IDs
            }
            
            // Ensure uniqueness (safety check)
            do {
                $generatedId = (string)$nextNumber;
                $nextNumber++;
            } while (StudentId::where('student_number', $generatedId)->exists() || 
                     Student::where('school_student_id', $generatedId)->exists());

            $validated['student_school_id'] = $generatedId;
            
            Log::info('Generated numeric student ID for manual addition', [
                'student_id' => $generatedId,
                'student_name' => $validated['fname'] . ' ' . $validated['lname']
            ]);
        }

        // Prevent duplicate school-ID assignment (safety net)
        if (Student::where('school_student_id', $validated['student_school_id'])->exists()) {
            return back()
                ->withErrors(['student_school_id' => 'That school ID is already assigned.'])
                ->withInput();
        }

        $sid = StudentId::firstOrCreate([
            'student_number' => $validated['student_school_id'],
        ]);

        // Prevent duplicate school-ID assignment

        // 4) Generate credentials
        // Generate credentials using same format as enrollment acceptance
        $lastname = strtolower($validated['lname']);
        $lastname = preg_replace('/[^a-z0-9]/', '', $lastname); // Remove special characters
        $birthYear = date('Y', strtotime($validated['dob']));
        
        // Username format: lastname.IDnumber (e.g., smith.MCA-MAN-2025-A1B2)
        $username = $lastname . '.' . $validated['student_school_id'];
        
        // Ensure username uniqueness
        $originalUsername = $username;
        $counter = 1;
        while (User::where('username', $username)->exists()) {
            $username = $originalUsername . $counter;
            $counter++;
        }
        
        // Password format: lastnamebirthyear (e.g., smith2000)
        $passwordPlain = $lastname . $birthYear;

        try {
            DB::transaction(function() use ($validated, $sid, $enrollee, $username, $passwordPlain, $picturePath, $isManualAddition) {
                Log::debug('Inside transaction, before user create');

                $user = User::create([
                    'username'  => $username,
                    'name'      => "{$validated['fname']} {$validated['lname']}",
                    'email'     => $validated['email'],
                    'user_type' => 'student',
                    'password'  => Hash::make($passwordPlain),
                ]);

                Log::debug('User created', ['id' => $user->user_id]);

                // Auto-assign section if not provided for manual addition
                $sectionId = $validated['section_id'];
                if ($isManualAddition && !$sectionId) {
                    $sectionId = $this->assignSectionToStudent($validated['grade_level_id'], $validated['strand_id'] ?? null);
                    if (!$sectionId) {
                        throw new \Exception('Unable to assign student to a section. Please create a section first or provide a specific section.');
                    }
                    Log::info('Student auto-assigned to section', ['section_id' => $sectionId]);
                }

                $student = Student::create([
                    'user_id'            => $user->user_id,
                    'first_name'         => $validated['fname'],
                    'middle_name'        => $validated['mname'],
                    'last_name'          => $validated['lname'],
                    'suffix'             => $validated['suffix'],
                    'picture'            => $picturePath,
                    'gender'             => $validated['gender'],
                    'date_of_birth'      => $validated['dob'],
                    'contact_number'     => $validated['contact'],
                    'email'              => $validated['email'],
                    'address'            => $validated['address'],
                    'grade_level_id'     => $validated['grade_level_id'],
                    'strand_id'          => $validated['strand_id'] ?? null,
                    'status_id'          => $validated['status_id'] ?? $this->getNotEnrolledStatusId(),
                    'section_id'         => $sectionId,
                    'date_enrolled'      => $validated['date_enrolled'],
                    'semester'           => $validated['semester'] ?? null,
                    'school_student_id'  => $validated['student_school_id'],
                    'lrn'                => $validated['lrn'] ?? null,
                    'grade_id'           => 1, // Default grade ID
                    'schedule_id'        => null,
                    'documents_id'       => null,
                    'attendance_report_id' => null,
                ]);

                Log::debug('Student created', ['id' => $student->student_id]);
                
                // Assign default subjects to the student
                $student->assignDefaultSubjects();
            });
        } catch (\Throwable $e) {
            Log::error('Error creating student & user', [
                'exception' => $e->getMessage()
            ]);

            return back()
                ->withErrors(['general' => 'There was an error saving the student.'])
                ->withInput();
        }
                    
        $msg = "🎉 Student {$validated['fname']} {$validated['lname']} added successfully!\n\n";
        $msg .= "📧 Contact Information:\n";
        $msg .= "• Email: {$validated['email']}\n\n";
        
        $msg .= "🔑 Login Credentials (Same Format as Enrollment Acceptance):\n";
        $msg .= "• Username: {$username}\n";
        $msg .= "• Password: {$passwordPlain}\n\n";
        
        $msg .= "📝 Credential Formats:\n";
        $msg .= "• Username: lastname.IDnumber\n";
        $msg .= "• Password: lastnamebirthyear\n\n";
        
        $msg .= "⚠️  IMPORTANT: Take note of these credentials - they won't be shown again!\n";
        $msg .= "Distribute these credentials physically to the student.";
        
        Log::info("Manual student created successfully.", [
            'student_id' => $sid->id,
            'username' => $username,
            'password_format' => $passwordPlain,
            'is_manual_addition' => true,
            'section_id' => $validated['section_id']
        ]);
        
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
        Log::info('storeSection method called', [
            'request_data' => $request->all(),
            'grade_level_id' => $request->grade_level_id,
            'strand_id' => $request->section_strand_id,
            'section_name' => $request->section_name
        ]);
        
        $gradeLevelId = $request->grade_level_id;
        
        // Only allow JHS sections (Grades 7-10) to be created manually
        if ($gradeLevelId > 10) {
            Log::warning('Attempted to create SHS section manually', [
                'grade_level_id' => $gradeLevelId,
                'request_data' => $request->all()
            ]);
            
            return redirect()->back()->with('error', 'Senior High School sections (Grade 11-12) are automatically created for each strand. Only Junior High School sections can be created manually.');
        }
        
        $validationRules = [
            'grade_level_id' => 'required|exists:grade_level,grade_level_id|max:10',
            'section_name' => 'required|string|max:255',
        ];
        
        Log::info('About to validate request', ['validation_rules' => $validationRules]);
        
        try {
            $request->validate($validationRules);
            Log::info('Validation passed');
            
            // Create the section (JHS only, no strand required)
            Log::info('About to create JHS section', [
                'grade_level_id' => $request->grade_level_id,
                'section_name' => $request->section_name
            ]);
            
            $section = StudentSection::create([
                'grade_level_id' => $request->grade_level_id,
                'strand_id' => null, // JHS sections don't have strands
                'section_name' => $request->section_name,
            ]);

            Log::info('JHS Section created successfully', [
                'section_id' => $section->id,
                'grade_level_id' => $request->grade_level_id,
                'section_name' => $request->section_name
            ]);

            // Create default classes for this section
            $this->createDefaultClassesForSection($section, $request->grade_level_id, null);

            return redirect()->back()->with('success', 'Section added successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed for section creation', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Please correct the errors below.');
        } catch (\Exception $e) {
            Log::error('Error creating JHS section', [
                'grade_level_id' => $request->grade_level_id,
                'section_name' => $request->section_name,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()->with('error', 'Failed to create section. Please try again.');
        }
    }

    public function approveStudent($id)
    {
        try {
            $student = Student::findOrFail($id);
            
            Log::info('Approving student', [
                'student_id' => $id,
                'current_status_id' => $student->status_id,
                'current_status_name' => $student->status->name ?? 'Unknown'
            ]);

            // Get the "Enrolled" status ID
            $enrolledStatus = StudentStatus::where('name', 'Enrolled')->first();
            if (!$enrolledStatus) {
                Log::error('Enrolled status not found in database');
                return back()->with('error', 'Enrolled status not found. Please contact administrator.');
            }

            // Check if they already have a student_number
            if (!$student->studentId) {
                // Generate or assign a student_number
                $studentNumber = 'S' . str_pad($id, 5, '0', STR_PAD_LEFT); // Example: S00001

                // Save it to student_ids table (assuming relation is studentId)
                $student->studentId()->create([
                    'student_number' => $studentNumber
                ]);
                
                Log::info('Created student ID record', [
                    'student_id' => $id,
                    'student_number' => $studentNumber
                ]);
            }

            // Update status to "Enrolled"
            $oldStatusId = $student->status_id;
            $student->status_id = $enrolledStatus->id;
            $student->save();

            Log::info('Student status updated', [
                'student_id' => $id,
                'old_status_id' => $oldStatusId,
                'new_status_id' => $enrolledStatus->id,
                'new_status_name' => $enrolledStatus->name
            ]);

            return back()->with('success', 'Student approved successfully and status updated to Enrolled.');

        } catch (\Exception $e) {
            Log::error('Error approving student', [
                'student_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', 'Failed to approve student. Please try again.');
        }
    }

    public function resetEnrollment()
    {
        try {
            // Get the ID of the "Not Enrolled" status
            $notEnrolledId = $this->getNotEnrolledStatusId();
            
            if (!$notEnrolledId) {
                return redirect()->back()->with('error', 'Not Enrolled status not found. Please contact administrator.');
            }

            // Update all students to that status
            $updatedCount = Student::query()->update(['status_id' => $notEnrolledId]);
            
            Log::info('Reset enrollment completed', [
                'updated_count' => $updatedCount,
                'not_enrolled_status_id' => $notEnrolledId
            ]);

            return redirect()->back()->with('success', "All students ({$updatedCount}) have been set to Not Enrolled.");
        } catch (\Exception $e) {
            Log::error('Error resetting enrollment', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()->with('error', 'Failed to reset enrollment. Please try again.');
        }
    }

    /**
     * Get section capacity for AJAX check
     */
    public function getSectionCapacity(Request $request)
    {
        try {
            $sectionId = $request->input('section_id');
            $gradeLevelId = $request->input('grade_level_id');
            
            $count = Student::where('section_id', $sectionId)
                ->where('grade_level_id', $gradeLevelId)
                ->count();
            
            return response()->json([
                'success' => true,
                'count' => $count,
                'max_capacity' => 25,
                'available' => 25 - $count,
                'is_full' => $count >= 25
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Unable to check section capacity'
            ], 500);
        }
    }

    /**
     * Validate section capacity for manual student addition
     */
    private function validateSectionCapacity($sectionId, $gradeLevelId)
    {
        try {
            // Count current students in this section
            $currentCount = Student::where('section_id', $sectionId)
                ->where('grade_level_id', $gradeLevelId)
                ->count();
            
            Log::info('Section capacity check', [
                'section_id' => $sectionId,
                'grade_level_id' => $gradeLevelId,
                'current_count' => $currentCount,
                'max_capacity' => 25
            ]);
            
            if ($currentCount >= 25) {
                Log::warning('Section at capacity', [
                    'section_id' => $sectionId,
                    'current_count' => $currentCount
                ]);
                
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'section_id' => ['This section has reached maximum capacity (25 students). Please select a different section or create a new section.']
                ]);
            }
            
            Log::info('Section capacity validation passed');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Section capacity validation error', [
                'section_id' => $sectionId,
                'grade_level_id' => $gradeLevelId,
                'error' => $e->getMessage()
            ]);
            
            throw \Illuminate\Validation\ValidationException::withMessages([
                'section_id' => ['Unable to validate section capacity. Please try again.']
            ]);
        }
    }

    /**
     * Assign default subjects to a specific student
     */
    public function assignDefaultSubjects($id)
    {
        try {
            $student = Student::findOrFail($id);
            
            // Call the assignDefaultSubjects method from the Student model
            $student->assignDefaultSubjects();
            
            Log::info('Default subjects assigned to student', [
                'student_id' => $student->student_id,
                'student_name' => $student->display_name,
                'assigned_by' => Auth::id()
            ]);
            
            return redirect()->route('admin.classes')
                ->with('success', "Default subjects have been assigned to {$student->display_name} successfully!");
                
        } catch (\Exception $e) {
            Log::error('Failed to assign default subjects to student', [
                'student_id' => $id,
                'error' => $e->getMessage(),
                'assigned_by' => Auth::id()
            ]);
            
            return redirect()->route('admin.classes')
                ->with('error', 'Failed to assign default subjects. Please try again.');
        }
    }

    /**
     * Assign default subjects to all students in a section
     */
    public function assignDefaultSubjectsToSection($sectionId)
    {
        try {
            $section = StudentSection::findOrFail($sectionId);
            
            // Get all enrolled students in this section
            $enrolledId = StudentStatus::where('name', 'Enrolled')->value('id');
            $students = Student::where('section_id', $sectionId)
                ->where('status_id', $enrolledId)
                ->get();
            
            $assignedCount = 0;
            $studentsProcessed = [];
            
            foreach ($students as $student) {
                // Call the assignDefaultSubjects method from the Student model
                $student->assignDefaultSubjects();
                $assignedCount++;
                $studentsProcessed[] = $student->display_name;
            }
            
            Log::info('Default subjects assigned to section students', [
                'section_id' => $sectionId,
                'section_name' => $section->section_name,
                'students_count' => $assignedCount,
                'students_processed' => $studentsProcessed,
                'assigned_by' => Auth::id()
            ]);
            
            return redirect()->route('admin.classes')
                ->with('success', "Default subjects have been assigned to {$assignedCount} students in {$section->section_name} successfully!");
                
        } catch (\Exception $e) {
            Log::error('Failed to assign default subjects to section students', [
                'section_id' => $sectionId,
                'error' => $e->getMessage(),
                'assigned_by' => Auth::id()
            ]);
            
            return redirect()->route('admin.classes')
                ->with('error', 'Failed to assign default subjects to section students. Please try again.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'middle_name' => 'nullable|string|max:255',
                'last_name' => 'required|string|max:255',
                'lrn' => 'nullable|string|max:255',
                'email' => 'required|email|max:255',
                'contact_number' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:500',
            ]);

            // Find the student
            $student = Student::findOrFail($id);
            
            // Update student information
            $student->first_name = $validated['first_name'];
            $student->middle_name = $validated['middle_name'];
            $student->last_name = $validated['last_name'];
            $student->lrn = $validated['lrn'];
            $student->email = $validated['email'];
            $student->contact_number = $validated['contact_number'];
            $student->address = $validated['address'];
            
            // Update display_name
            $student->display_name = trim($validated['first_name'] . ' ' . ($validated['middle_name'] ?? '') . ' ' . $validated['last_name']);
            
            $student->save();

            // Also update the associated user if it exists
            $user = User::where('student_id', $student->student_id)->first();
            if ($user) {
                $user->name = $student->display_name;
                $user->email = $validated['email'];
                $user->save();
            }

            Log::info('Student updated successfully', [
                'student_id' => $student->student_id,
                'updated_by' => Auth::id(),
                'updated_fields' => array_keys($validated)
            ]);

            return redirect()->route('admin.classes')
                ->with('success', 'Student information updated successfully!');

        } catch (\Exception $e) {
            Log::error('Failed to update student', [
                'student_id' => $id,
                'error' => $e->getMessage(),
                'updated_by' => Auth::id()
            ]);

            return redirect()->route('admin.classes')
                ->with('error', 'Failed to update student information. Please try again.');
        }
    }


}
