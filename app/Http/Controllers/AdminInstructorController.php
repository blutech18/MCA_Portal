<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Schedule;
use App\Models\Instructor;
use App\Models\SchoolClass;
use App\Models\InstructorId;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
                        'schedule_id' => $s->id,
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

        $validated = $request->validate([
            'instructor_school_number' => ['required','string','max:50'],
            'first_name'               => ['required','string'],
            'middle_name'              => ['nullable','string'],
            'last_name'                => ['required','string'],
            'suffix'                   => ['nullable','string'],
            'username'                 => ['required','string','exists:users,username'],
            'email'                    => ['required','email','unique:instructors,email'],
            'gender'                   => ['required','in:male,female,other'],
            'date_of_birth'            => ['required','date'],
            'contact_number'           => ['required','string'],
            'address'                  => ['required','string'],
            'job_start_date'           => ['required','date'],
            'status'                   => ['required','in:active,on leave,inactive'],
            'picture'                  => ['nullable','image','max:2048'],
        ]);

        $idRecord = InstructorId::firstOrCreate(
            ['instructor_number' => $validated['instructor_school_number']]
        );
        
        if (Instructor::where('instructor_school_id', $idRecord->id)->exists()) {
            return back()
                ->withErrors(['instructor_school_number' => 'That school ID is already assigned.'])
                ->withInput();
        }
        $user = User::where('username', $validated['username'])->firstOrFail();
        $userId = $user->getKey();

        Log::info('User fetched for username:', ['user' => $user]);
        
        if (Instructor::where('user_id', $userId)->exists()) {
            return back()
                ->withErrors(['username' => 'This username is already assigned to another instructor.'])
                ->withInput();
        }
        
        $picturePath = null;
        if ($request->hasFile('picture')) {
            $picturePath = $request->file('picture')->store('instructors', 'public');
        }

        $instructor = Instructor::create([
            'user_id'               => $userId,
            'instructor_school_id'  => $idRecord->id,
            'first_name'            => $validated['first_name'],
            'middle_name'           => $validated['middle_name'],
            'last_name'             => $validated['last_name'],
            'suffix'                => $validated['suffix'],
            'picture'               => $picturePath,
            'gender'                => $validated['gender'],
            'date_of_birth'         => $validated['date_of_birth'],
            'contact_number'        => $validated['contact_number'],
            'email'                 => $validated['email'],
            'address'               => $validated['address'],
            'job_start_date'        => $validated['job_start_date'],
            'status'                => $validated['status'],
        ]);

        $currentClassId = request()->query('class_id');

        return redirect()
            ->route('admin.instructors')
            ->with('success', 'Instructor added successfully.');
    
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
        Schedule::destroy($scheduleId);
        return response()->noContent();
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
