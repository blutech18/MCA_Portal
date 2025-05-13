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
        $instructors = Instructor::with([
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
        

        return view('admin_instructors', compact('instructors'));
    }



    public function store(Request $request)
{
    // 1) Immediately log entry and raw input
    Log::debug('→ store() entry', ['input' => $request->all()]);

    // 2) Validate
    $v = $request->validate([
        'instructor_school_number' => ['required','string','max:50'],
        'first_name'               => ['required','string','max:255'],
        'middle_name'              => ['nullable','string','max:255'],
        'last_name'                => ['required','string','max:255'],
        'suffix'                   => ['nullable','string','max:10'],
        'email'                    => ['required','email','unique:users,email'],
        'gender'                   => ['required','in:male,female,other'],
        'date_of_birth'            => ['required','date'],
        'contact_number'           => ['required','string'],
        'address'                  => ['required','string'],
        'job_start_date'           => ['required','date'],
        // we’ll default status server-side
    ]);
    Log::debug('→ validation passed', $v);

    // 3) Force a default if missing
    $v['status'] = $v['status'] ?? 'active';
    Log::debug('→ status set to', ['status' => $v['status']]);

    // 4) Create or fetch school-ID
    $idRecord = InstructorId::firstOrCreate([
        'instructor_number' => $v['instructor_school_number']
    ]);
    Log::debug('→ idRecord', ['idRecord' => $idRecord->toArray()]);

    if (Instructor::where('instructor_school_id', $idRecord->id)->exists()) {
        Log::warning('→ school number already assigned', ['school_id' => $idRecord->id]);
        return back()->withErrors([
            'instructor_school_number' => 'That school number is already assigned.'
        ])->withInput();
    }

    // 5) Build username & password
    $base = Str::lower(substr($v['first_name'],0,1) . $v['last_name']);
    do {
        $username = $base . rand(100,999);
    } while (User::where('username',$username)->exists());
    $passwordPlain = Str::lower($v['last_name']) . date('Ymd', strtotime($v['date_of_birth']));
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
            'end_time' => 'required',
            'room' => 'required|string',
        ]);
        
        Schedule::create([
            'instructor_class_id' => $validated['instructor_class_id'], 
            'day_of_week' => $validated['day_of_week'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'room' => $validated['room'],
        ]);
        
    
        return back()->with('success', 'Schedule added.');
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
