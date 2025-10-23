<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Schedule;
use App\Models\Instructor;
use App\Models\SchoolClass;
use Illuminate\Support\Str;
use App\Models\InstructorId;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AdminInstructorController extends Controller
{

// AdminInstructorController.php

// in AdminInstructorController
    public function index()
    {
        // First, ensure all instructor users have corresponding instructor records
        $this->ensureInstructorRecordsExist();
        
        $instructors = Instructor::with([
            'user',
            'schoolId',
            // pivot → class → relationships
            'instructorClasses.class.gradeLevel',
            'instructorClasses.class.strand',
            'instructorClasses.class.section',   // <<<<<< load the real section model
            'instructorClasses.schedules',
        ])->get();

        $instructors->each(function($instr) {
            $instr->class_payload = $instr->instructorClasses->map(function($p) {
                return [
                    'pivot_id'   => $p->id,
                    'class_id'   => $p->class_id, 
                    'class'      => [
                        'name'          => $p->class->name,
                        'code'          => $p->class->code,
                        'grade_level'   => $p->class->gradeLevel->name ?? null,
                        'strand'        => optional($p->class->strand)->name,
                        'section_name'  => optional($p->class->section)->section_name,
                    ],
                    'schedules'  => $p->schedules->map(fn($s) => [
                        'schedule_id' => $s->schedule_id,
                        'day_of_week' => $s->day_of_week,
                        'start_time'  => $s->start_time,
                        'end_time'    => $s->end_time,
                        'room'        => $s->room,
                    ])->all(),
                ];
            })->all();
        });
        
        // Load all sections for advisory assignment dropdown
        $sections = \App\Models\StudentSection::with(['gradeLevel', 'strand'])
            ->orderBy('grade_level_id')
            ->orderBy('section_name')
            ->get();

        return view('admin_instructors', compact('instructors', 'sections'));
    }
    
    /**
     * Get all available classes for assignment (AJAX endpoint)
     */
    public function getAvailableClasses(Request $request)
    {
        $instructorId = $request->input('instructor_id');
        $instructor = null;
        $advisoryGradeLevelId = null;
        
        // Get instructor's advisory section to filter classes
        if ($instructorId) {
            $instructor = Instructor::with('advisorySection.gradeLevel')->find($instructorId);
            if ($instructor && $instructor->advisorySection) {
                $advisoryGradeLevelId = $instructor->advisorySection->grade_level_id;
            }
        }
        
        $defaultSubjects = \App\Models\Subject::where('is_default', true)->get();
        $defaultClassesQuery = \App\Models\SchoolClass::with(['subject', 'gradeLevel', 'strand', 'section']);
        
        if ($defaultSubjects->count() > 0) {
            $defaultClassesQuery->whereIn('subject_id', $defaultSubjects->pluck('id'));
        }
        
        // Filter based on advisory section (JHS: grades 7-10, SHS: grades 11-12)
        if ($advisoryGradeLevelId) {
            $defaultClassesQuery->whereHas('gradeLevel', function($query) use ($advisoryGradeLevelId) {
                if ($advisoryGradeLevelId >= 11) {
                    // SHS: show only grades 11-12
                    $query->whereIn('grade_level_id', [11, 12]);
                } else {
                    // JHS: show only grades 7-10
                    $query->whereIn('grade_level_id', [7, 8, 9, 10]);
                }
            });
        }
        
        $defaultClasses = $defaultClassesQuery->get();
        
        if ($defaultClasses->isEmpty()) {
            $defaultClasses = \App\Models\SchoolClass::with(['subject', 'gradeLevel', 'strand', 'section'])->get();
        }
        
        $defaultClasses = $defaultClasses->sortBy(function($class) {
            return ($class->subject->is_default ?? false) ? 0 : 1;
        })->values();
        
        $allClasses = \App\Models\SchoolClass::with(['subject', 'gradeLevel', 'strand', 'section'])
            ->get()
            ->sortBy(function($class) {
                if ($class->subject->is_default ?? false) {
                    return '0' . ($class->subject->name ?? 'Unknown');
                }
                return '1' . ($class->subject->name ?? 'Unknown');
            })->values();
        
        return response()->json([
            'success' => true,
            'defaultClasses' => $defaultClasses->map(function($course) {
                return [
                    'id' => $course->id,
                    'name' => $course->name,
                    'subject' => [
                        'name' => $course->subject->name ?? 'Unknown Subject',
                        'is_default' => $course->subject->is_default ?? false,
                    ],
                    'section' => [
                        'section_name' => $course->section->section_name ?? 'N/A',
                    ],
                    'gradeLevel' => [
                        'name' => $course->gradeLevel->name ?? 'Unknown',
                    ],
                    'strand' => $course->strand ? [
                        'name' => $course->strand->name,
                    ] : null,
                ];
            }),
            'allClasses' => $allClasses->map(function($course) {
                return [
                    'id' => $course->id,
                    'name' => $course->name,
                    'code' => $course->code,
                    'subject' => [
                        'name' => $course->subject->name ?? 'Unknown',
                        'code' => $course->subject->code ?? 'N/A',
                        'is_default' => $course->subject->is_default ?? false,
                    ],
                    'section' => [
                        'section_name' => $course->section->section_name ?? 'N/A',
                    ],
                    'gradeLevel' => [
                        'name' => $course->gradeLevel->name ?? 'Unknown',
                    ],
                    'strand' => $course->strand ? [
                        'name' => $course->strand->name,
                    ] : null,
                ];
            }),
        ]);
    }
    
    /**
     * Ensure all instructor users have corresponding instructor records
     */
    private function ensureInstructorRecordsExist()
    {
        $instructorUsers = User::where('user_type', 'instructor')->get();
        
        foreach ($instructorUsers as $user) {
            $existingInstructor = Instructor::where('user_id', $user->user_id)->first();
            
            if (!$existingInstructor) {
                // Extract name parts
                $nameParts = explode(' ', trim($user->name));
                $firstName = $nameParts[0] ?? '';
                $lastName = end($nameParts) ?? '';
                $middleName = count($nameParts) > 2 ? implode(' ', array_slice($nameParts, 1, -1)) : '';
                
                // Generate instructor number (similar to student number generation)
                $instructorNumber = sprintf('INS%04d', $user->user_id);
                
                // Create instructor ID record first
                $instructorId = \App\Models\InstructorId::create([
                    'instructor_number' => $instructorNumber
                ]);
                
                // Create instructor record
                Instructor::create([
                    'user_id' => $user->user_id,
                    'instructor_school_id' => $instructorId->id,
                    'first_name' => $firstName,
                    'middle_name' => $middleName,
                    'last_name' => $lastName,
                    'suffix' => null,
                    'picture' => null,
                    'gender' => 'male', // Default
                    'date_of_birth' => '1990-01-01', // Default
                    'contact_number' => '0000000000', // Default
                    'email' => $user->email,
                    'address' => 'Default Address', // Default
                    'job_start_date' => now()->format('Y-m-d'),
                    'status' => 'active',
                    'advisory_section_id' => null,
                ]);
                
                Log::info('Created missing instructor record for user: ' . $user->name . ' with instructor number: ' . $instructorNumber);
            }
        }
    }



    public function store(Request $request)
    {
        try {
            // 1) Immediately log entry and raw input
            Log::debug('→ store() entry', ['input' => $request->all()]);

            // 2) Enhanced validation with better error messages
            $v = $request->validate([
                // auto-generate instructor_school_number server-side
                'first_name'               => ['required','string','max:255','regex:/^[a-zA-Z\s\-\.]+$/'],
                'middle_name'              => ['nullable','string','max:255','regex:/^[a-zA-Z\s\-\.]*$/'],
                'last_name'                => ['required','string','max:255','regex:/^[a-zA-Z\s\-\.]+$/'],
                'suffix'                   => ['nullable','string','max:10','regex:/^[a-zA-Z\.]*$/'],
                'email'                    => ['required','email','unique:users,email'],
                'gender'                   => ['required','in:male,female,other'],
                'date_of_birth'            => ['required','date','before:'.date('Y-m-d', strtotime('-18 years'))],
                'contact_number'           => ['required','string','regex:/^[0-9\-\+\(\)\s]+$/'],
                'address'                  => ['required','string','max:500'],
                'job_start_date'           => ['required','date','after_or_equal:today'],
                'advisory_section_id'      => ['nullable', 'exists:section,id'],
                // we'll default status server-side
            ], [
                'first_name.regex' => 'First name can only contain letters, spaces, hyphens, and periods.',
                'middle_name.regex' => 'Middle name can only contain letters, spaces, hyphens, and periods.',
                'last_name.regex' => 'Last name can only contain letters, spaces, hyphens, and periods.',
                'suffix.regex' => 'Suffix can only contain letters and periods.',
                'email.unique' => 'This email address is already registered.',
                'date_of_birth.before' => 'Instructor must be at least 18 years old.',
                'contact_number.regex' => 'Contact number contains invalid characters.',
                'job_start_date.after_or_equal' => 'Job start date cannot be in the past.',
            ]);
            Log::debug('→ validation passed', $v);

            // 3) Force a default if missing
            $v['status'] = $v['status'] ?? 'active';
            Log::debug('→ status set to', ['status' => $v['status']]);

            // 4) Generate next instructor id: INS-YYYY-XXX
            $year = date('Y');
            $prefix = 'INS-' . $year . '-';
            $latest = InstructorId::where('instructor_number', 'like', $prefix.'%')
                        ->orderBy('id','desc')
                        ->first();
            $nextSeq = 1;
            if ($latest) {
                $lastNum = (int)substr($latest->instructor_number, -3);
                $nextSeq = $lastNum + 1;
            }
            $generatedNumber = $prefix . str_pad((string)$nextSeq, 3, '0', STR_PAD_LEFT);

            $idRecord = InstructorId::create([
                'instructor_number' => $generatedNumber,
            ]);
            Log::debug('→ idRecord', ['idRecord' => $idRecord->toArray()]);

            // uniqueness ensured by sequence logic above

            // 5) Build username & password using required format
            // Username: lastname.instructorID (e.g., santos.INS-2025-001)
            // Password: lastnamebirthyear (e.g., santos1985)
            // Normalize last name more safely to avoid dropping the first letter
            $lastNameRaw = trim($v['last_name']);
            // Normalize to decomposed form to preserve base letters, then strip diacritics
            if (class_exists('Normalizer')) {
                $lastNameRaw = \Normalizer::normalize($lastNameRaw, \Normalizer::FORM_D);
            }
            // Remove combining marks (accents), keep base letters and digits
            $lastNameNoMarks = preg_replace('/\p{Mn}+/u', '', $lastNameRaw);
            // Keep only letters and digits (unicode), then lowercase
            $lastname = mb_strtolower(preg_replace('/[^\p{L}0-9]+/u','', $lastNameNoMarks));
            if ($lastname === '') {
                // Final fallback: ASCII transliteration
                $lastNameAscii = @iconv('UTF-8', 'ASCII//TRANSLIT', $lastNameRaw) ?: $lastNameRaw;
                $lastname = strtolower(preg_replace('/[^a-z0-9]/','', $lastNameAscii));
            }
            $username = $lastname . '.' . $generatedNumber;
            $originalUsername = $username;
            $counter = 1;
            while (User::where('username',$username)->exists()) {
                $username = $originalUsername . $counter;
                $counter++;
            }
            $passwordPlain = $lastname . date('Y', strtotime($v['date_of_birth']));
            Log::debug('→ generated credentials', compact('username','passwordPlain'));

            // 6) Wrap in a transaction & log at each step
            DB::transaction(function() use($v, $idRecord, $username, $passwordPlain) {
                Log::debug('↳ creating User record');
                $newUser = User::create([
                    'username'  => $username,
                    'name'      => "{$v['first_name']} {$v['last_name']}",
                    'email'     => $v['email'],
                    'user_type' => 'instructor',
                    'password'  => Hash::make($passwordPlain),
                ]);
                Log::debug('↳ User created', ['user' => $newUser->toArray()]);

                Log::debug('↳ creating Instructor record');
                $newInstructor = Instructor::create([
                    'user_id'               => $newUser->user_id,
                    'instructor_school_id'  => $idRecord->id,
                    'first_name'            => $v['first_name'],
                    'middle_name'           => $v['middle_name'],
                    'last_name'             => $v['last_name'],
                    'suffix'                => $v['suffix'],
                    'gender'                => $v['gender'],
                    'date_of_birth'         => $v['date_of_birth'],
                    'contact_number'        => $v['contact_number'],
                    'email'                 => $v['email'],
                    'address'               => $v['address'],
                    'job_start_date'        => $v['job_start_date'],
                    'status'                => $v['status'],
                    'advisory_section_id'   => $v['advisory_section_id'] ?? null,
                ]);
                Log::debug('↳ Instructor created', ['instructor' => $newInstructor->toArray()]);
            });

            Log::info('→ store() complete, instructor & user created', compact('username'));
            return redirect()
                ->route('admin.instructors', [
                    'new_username' => $username,
                    'new_password' => $passwordPlain,
                ])
                ->with('success','Instructor added successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Instructor creation validation failed', [
                'errors' => $e->errors(),
                'request_data' => $request->except(['_token'])
            ]);
            return redirect()
                ->route('admin.instructors')
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Please correct the errors below and try again.');
        } catch (\Exception $e) {
            Log::error('Instructor creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->except(['_token'])
            ]);
            return redirect()
                ->route('admin.instructors')
                ->with('error', 'Failed to create instructor. Please try again. If the problem persists, contact the administrator.')
                ->withInput();
        }
    }

    // in AdminInstructorController.php


public function update(Request $request, $id)
{
    // Log to verify we got the right ID
    Log::debug('→ update() called', [
        'route_instructor_id' => $id,
        'payload'             => $request->all(),
    ]);

    // 1) Find the instructor by its true PK
    $instructor = Instructor::findOrFail($id);

    // 2) Validate
    $v = $request->validate([
        'first_name'     => 'required|string|max:255',
        'middle_name'    => 'nullable|string|max:255',
        'last_name'      => 'required|string|max:255',
        'suffix'         => 'nullable|string|max:10',
        'email'          => ['required','email',
                             Rule::unique('instructors','email')
                                 ->ignore($instructor->instructor_id, 'instructor_id')],
        'gender'         => 'required|in:male,female,other',
        'date_of_birth'  => 'required|date',
        'contact_number' => 'required|string',
        'address'        => 'required|string',
        'job_start_date' => 'required|date',
        'status'         => 'required|in:active,on leave,retired,terminated',
        'advisory_section_id' => ['nullable', 'exists:section,id'],
    ]);

    // 3) Update
    $instructor->update($v);

    // 4) Redirect
    return redirect()
        ->route('admin.instructors')
        ->with('success','Instructor updated successfully.');
}




    public function checkUsername($username)
    {
        $user = User::where('username', $username)->first();

        return response()->json([
        'valid'         => (bool) $user,
        'has_instructor'=> $user
                            ? Instructor::where('user_id',$user->user_id)->exists()
                            : false,
        'user_id'       => $user?->user_id,
        ]);
    }


    public function search(Request $request)
    {
        $query = $request->query('query');

        $instructors = Instructor::with('schoolId')
            ->where(function ($q) use ($query) {
                $q->where('first_name', 'like', "%$query%")
                ->orWhere('last_name', 'like', "%$query%")
                ->orWhere('email', 'like', "%$query%");
            })
            ->get()
            ->map(function ($instr) {
                return [
                    'instructor_id'     => $instr->instructor_id,
                    'instructor_number' => $instr->schoolId->instructor_number ?? '',
                    'first_name'        => $instr->first_name,
                    'middle_name'       => $instr->middle_name,
                    'last_name'         => $instr->last_name,
                    'suffix'            => $instr->suffix,
                    'display_name'      => $instr->display_name,
                    'short_name'        => $instr->short_name,
                    'full_name'         => $instr->full_name,
                    'email'             => $instr->email,
                    'status'            => $instr->status,
                    'job_start_date'    => \Carbon\Carbon::parse($instr->job_start_date)->toDateString(),
                ];
            });

        return response()->json($instructors);
    }

    public function storeSchedule(Request $request)
    {
        $validated = $request->validate([
            'instructor_class_id' => 'required|exists:instructor_classes,id', 
            'day_of_week' => 'required',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'room' => 'required|string',
        ]);
        
        // Check for duplicate schedules (same class, day, time, and room)
        $existingSchedule = Schedule::where([
            'instructor_class_id' => $validated['instructor_class_id'],
            'day_of_week' => $validated['day_of_week'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'room' => $validated['room']
        ])->first();
        
        if ($existingSchedule) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This exact schedule already exists for this class.',
                    'errors' => ['duplicate' => 'Schedule with same day, time, and room already exists.']
                ], 422);
            }
            return back()->withErrors(['duplicate' => 'This exact schedule already exists for this class.']);
        }
        
        // Check for time conflicts (overlapping schedules on the same day for the same class)
        $conflictingSchedule = Schedule::where('instructor_class_id', $validated['instructor_class_id'])
            ->where('day_of_week', $validated['day_of_week'])
            ->where(function($query) use ($validated) {
                $query->where(function($q) use ($validated) {
                    // New schedule starts during existing schedule
                    $q->where('start_time', '<=', $validated['start_time'])
                      ->where('end_time', '>', $validated['start_time']);
                })->orWhere(function($q) use ($validated) {
                    // New schedule ends during existing schedule
                    $q->where('start_time', '<', $validated['end_time'])
                      ->where('end_time', '>=', $validated['end_time']);
                })->orWhere(function($q) use ($validated) {
                    // New schedule completely contains existing schedule
                    $q->where('start_time', '>=', $validated['start_time'])
                      ->where('end_time', '<=', $validated['end_time']);
                });
            })->first();
            
        if ($conflictingSchedule) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Time conflict detected with existing schedule.',
                    'errors' => ['time_conflict' => "Schedule conflicts with existing schedule: {$conflictingSchedule->start_time} - {$conflictingSchedule->end_time} in {$conflictingSchedule->room}"]
                ], 422);
            }
            return back()->withErrors(['time_conflict' => "Schedule conflicts with existing schedule: {$conflictingSchedule->start_time} - {$conflictingSchedule->end_time} in {$conflictingSchedule->room}"]);
        }
        
        $schedule = Schedule::create([
            'instructor_class_id' => $validated['instructor_class_id'], 
            'day_of_week' => $validated['day_of_week'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'room' => $validated['room'],
        ]);
        
        // Return JSON for AJAX requests
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Schedule added successfully! You can add more schedules for different times on the same day.',
                'schedule' => $schedule
            ]);
        }
    
        return back()->with('success', 'Schedule added successfully! You can add more schedules for different times on the same day.');
    }
    
    public function updateSchedule(Request $request, $scheduleId)
    {
        $validated = $request->validate([
            'day_of_week' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'room' => 'required|string',
        ]);

        $schedule = Schedule::findOrFail($scheduleId);
        $schedule->update($validated);

        return back()->with('success', 'Schedule updated.');
    }

    public function deleteSchedule($scheduleId)
    {
        $schedule = \App\Models\Schedule::findOrFail($scheduleId);

        // 2) Delete
        $schedule->delete();
    
        // 3) Return a JSON response
        return response()->json([
            'message' => 'Schedule deleted',
        ], 200);
    }

    /**
     * Get instructor schedules with classes for AJAX updates
     */
    public function getInstructorSchedules($instructorId)
    {
        $instructor = Instructor::with([
            'instructorClasses.class.gradeLevel',
            'instructorClasses.class.strand',
            'instructorClasses.class.section',
            'instructorClasses.class.subject',
            'instructorClasses.schedules'
        ])->findOrFail($instructorId);

        // Format the data similar to how it's done in the index method
        $instructorClasses = $instructor->instructorClasses->map(function ($pivot) {
            return [
                'pivot_id' => $pivot->id,
                'class_id' => $pivot->class_id,
                'class' => [
                    'id' => $pivot->class->id,
                    'name' => $pivot->class->name,
                    'code' => $pivot->class->code,
                    'section_name' => $pivot->class->section->section_name ?? 'N/A',
                    'grade_level' => $pivot->class->gradeLevel->name ?? 'Unknown',
                    'strand' => $pivot->class->strand->name ?? null,
                ],
                'schedules' => $pivot->schedules->map(function ($sched) {
                    return [
                        'schedule_id' => $sched->schedule_id,
                        'day_of_week' => $sched->day_of_week,
                        'start_time' => $sched->start_time,
                        'end_time' => $sched->end_time,
                        'room' => $sched->room,
                    ];
                })->toArray()
            ];
        })->toArray();

        return response()->json([
            'success' => true,
            'instructorClasses' => $instructorClasses
        ]);
    }

    public function assignClasses(Request $request)
    {
        $request->validate([
            'instructor_id' => 'required|exists:instructors,instructor_id', // Specify the correct column
            'class_ids' => 'required|array',
        ]);

        $instructor = Instructor::findOrFail($request->instructor_id);
        $instructor->classes()->sync($request->class_ids); // Sync once!

        return redirect()->back()->with('success', 'Classes assigned.');
    }

}
