<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\OldStudentEnrollee;
use App\Models\Student;
use App\Models\EnrollmentFee;
use App\Mail\EnrollmentConfirmation;
use Illuminate\Support\Facades\Mail;

class OldEnrollmentController extends Controller
{
    public function showStep1()
    {
        return view('old_step1', [
            'errors' => session('errors', new \Illuminate\Support\MessageBag())
        ]);
    }

    /** Step 1: handle pre-registration POST */
    public function postStep1(Request $request)
    {
        try {
            // Log the incoming request data for debugging
            \Log::info('Old Enrollment Step 1 - Request data:', $request->all());
            
            $data = $request->validate([
                'semester'              => 'required|in:1st,2nd',
                'lrn'                   => 'required|string',
                'surname'               => 'required|string',
                'givenName'             => 'required|string',
                'middleName'            => 'nullable|string',
                'studentId'             => 'required|string',
                'gradeLevelApplying'    => 'required|integer|min:7|max:12',
                'terms'                 => 'required|array|size:6',
                'terms.*'               => 'in:completeness,abide,consequences,responsible,updated,aware',
            ]);

            // Verify that the student exists with the provided LRN
            // Check old_student_enrollees, accepted new_student_enrollees, and students tables
            $oldEnrollee = OldStudentEnrollee::where('lrn', $data['lrn'])->first();
            $newEnrollee = \App\Models\NewStudentEnrollee::where('lrn', $data['lrn'])
                ->where('status', 'accepted')
                ->first();
            $student = null;
            
            if ($oldEnrollee) {
                // Student found in old enrollees - this is valid for enrollment
                $student = (object) [
                    'student_id' => $oldEnrollee->id,
                    'first_name' => $oldEnrollee->given_name,
                    'middle_name' => $oldEnrollee->middle_name,
                    'last_name' => $oldEnrollee->surname,
                    'lrn' => $oldEnrollee->lrn
                ];
            } elseif ($newEnrollee) {
                // Student found in accepted new enrollees - this is valid for enrollment
                $student = (object) [
                    'student_id' => $newEnrollee->id,
                    'first_name' => $newEnrollee->given_name,
                    'middle_name' => $newEnrollee->middle_name,
                    'last_name' => $newEnrollee->surname,
                    'lrn' => $newEnrollee->lrn
                ];
            } else {
                // Check students table
                $student = Student::findByLRN($data['lrn']);
            }
            
            if (!$student) {
                return back()->withErrors(['lrn' => 'Student not found with the provided LRN.'])->withInput();
            }

            \Log::info('Old Enrollment Step 1 - Validation passed, creating enrollee');
            \Log::info('Old Enrollment Step 1 - Student data:', [
                'lrn' => $data['lrn'],
                'surname' => $data['surname'],
                'givenName' => $data['givenName'],
                'middleName' => $data['middleName'],
                'studentId' => $data['studentId'],
                'gradeLevelApplying' => $data['gradeLevelApplying']
            ]);

            $enrollee = OldStudentEnrollee::create([
                'semester'                  => $data['semester'],
                'surname'                   => $data['surname'],
                'given_name'                => $data['givenName'],
                'middle_name'               => $data['middleName'],
                'lrn'                       => $data['lrn'],
                'student_id'                => $data['studentId'],
                'grade_level_applying'      => $data['gradeLevelApplying'],
                'terms_accepted'  => $data['terms'],
            ]);

            \Log::info('Old Enrollment Step 1 - Enrollee created with ID: ' . $enrollee->id);

            session(['old_enrollee_id' => $enrollee->id]);

            \Log::info('Old Enrollment Step 1 - Session set, redirecting to step 2');

            return redirect()->route('enroll.old.step2');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Old Enrollment Step 1 - Validation failed:', $e->errors());
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Old Enrollment Step 1 - Error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred. Please try again.')->withInput();
        }
    }

    /** Step 2: show payment form */
    public function showStep2()
    {
        $enrollee = OldStudentEnrollee::findOrFail(
            session('old_enrollee_id')
        );
        
        // Get the appropriate fee based on grade level
        // Check if grade level applying is SHS (Grade 11 or 12)
        $isSHS = !empty($enrollee->grade_level_applying) && ($enrollee->grade_level_applying == 11 || $enrollee->grade_level_applying == 12);
        $feeType = $isSHS ? EnrollmentFee::FEE_TYPE_OLD_SHS : EnrollmentFee::FEE_TYPE_OLD_JHS;
        $currentFee = EnrollmentFee::getCurrentFee($feeType);
        
        // Log for debugging
        Log::info('Fee determination for old enrollment', [
            'enrollee_id' => $enrollee->id,
            'grade_level_applying' => $enrollee->grade_level_applying,
            'isSHS' => $isSHS,
            'feeType' => $feeType,
            'currentFee' => $currentFee ? $currentFee->amount : null
        ]);
        
        // If no fee is set, create a default fee object for display
        if (!$currentFee) {
            $currentFee = new EnrollmentFee();
            $currentFee->amount = 1000.00;
        }
        
        return view('old_step2', compact('enrollee', 'currentFee'));
    }

    /** Handle payment POST and redirect to Step 3 */
    public function postStep2(Request $request)
    {
        $enrollee = OldStudentEnrollee::findOrFail(
            session('old_enrollee_id')
        );

        $data = $request->validate([
            'studentId'      => 'required|string',
            'fullName'       => 'required|string',
            'paymentRef'     => 'required|string',
            'receiptUpload'  => 'required|file|mimes:jpg,jpeg,png,pdf',
        ]);

        // store the file
        $path = $request->file('receiptUpload')
                    ->store('enroll/payments', 'public');

        // update record
        $enrollee->update([
            'payment_applicant_name' => $data['fullName'],
            'payment_reference'      => $data['paymentRef'],
            'payment_receipt_path'   => $path,
            'paid'                   => true,
        ]);

        return redirect()->route('enroll.old.step3');
    }

    /** Step 3: show clearances upload */
    public function showStep3()
    {
        $enrollee = OldStudentEnrollee::findOrFail(session('old_enrollee_id'));
        return view('old_step3', compact('enrollee'));
    }

    /** Handle clearances POST and redirect to Step 4 */
    public function postStep3(Request $request)
    {
        $enrollee = OldStudentEnrollee::findOrFail(session('old_enrollee_id'));

        $data = $request->validate([
            'registrar' => 'required|accepted',
            'accounting' => 'required|accepted',
            'library' => 'required|accepted',
            'discipline' => 'required|accepted',
            'guidance' => 'nullable|accepted',
        ]);

        // Update enrollee with clearance status
        $enrollee->update([
            'registrar_cleared' => $data['registrar'] ?? false,
            'accounting_cleared' => $data['accounting'] ?? false,
            'library_cleared' => $data['library'] ?? false,
            'discipline_cleared' => $data['discipline'] ?? false,
            'guidance_cleared' => $data['guidance'] ?? false,
        ]);

        return redirect()->route('enroll.old.step4');
    }

    /** Step 4: confirmation */
    public function showStep4()
    {
        $enrollee = OldStudentEnrollee::findOrFail(session('old_enrollee_id'));

        // generate unique application number if absent
        if (! $enrollee->application_number) {
            $year = now()->year;
            do {
                $token = strtoupper(Str::random(4));
                $appNum = "MCA-OLD-{$year}-{$token}";
            } while (OldStudentEnrollee::where('application_number',$appNum)->exists());
            $enrollee->update(['application_number' => $appNum]);
        }

        // (Optional) send confirmation email
        if ($enrollee->email ?? false) {
            Mail::to($enrollee->email)
                ->queue(new EnrollmentConfirmation($enrollee));
        }

        return view('old_step4', compact('enrollee'));
    }

    /**
     * AJAX endpoint to lookup student by LRN
     * Checks old_student_enrollees first, then accepted new_student_enrollees, then students table
     */
    public function lookupStudentByLRN(Request $request)
    {
        $request->validate([
            'lrn' => 'required|string'
        ]);

        // First, check if student exists in old_student_enrollees (previous enrollment)
        $oldEnrollee = OldStudentEnrollee::where('lrn', $request->lrn)->first();
        
        if ($oldEnrollee) {
            return response()->json([
                'success' => true,
                'student' => [
                    'student_id' => $oldEnrollee->id,
                    'first_name' => $oldEnrollee->given_name,
                    'middle_name' => $oldEnrollee->middle_name,
                    'last_name' => $oldEnrollee->surname,
                    'suffix' => null,
                    'full_name' => $oldEnrollee->display_name,
                    'grade_level_id' => $oldEnrollee->grade_level_applying,
                    'grade_level_name' => 'Grade ' . $oldEnrollee->grade_level_applying,
                    'strand_id' => null,
                    'strand_name' => null,
                    'section_id' => null,
                    'section_name' => null,
                    'status_id' => null,
                    'status_name' => 'Previous Enrollee',
                    'source' => 'old_enrollee'
                ]
            ]);
        }

        // Second, check if student exists in accepted new_student_enrollees
        $newEnrollee = \App\Models\NewStudentEnrollee::where('lrn', $request->lrn)
            ->where('status', 'accepted')
            ->first();
        
        if ($newEnrollee) {
            // Check if this accepted enrollee has been converted to a student with section assignment
            $student = \App\Models\Student::where('lrn', $request->lrn)
                ->with(['gradeLevel', 'strand', 'section', 'status'])
                ->first();
            
            if ($student) {
                // If student record exists, use the student data (more accurate)
                // Determine if this is SHS (Grades 11-12) or JHS (Grades 7-10)
                $isSHS = in_array($student->grade_level_id, [11, 12]);
                
                return response()->json([
                    'success' => true,
                    'student' => [
                        'student_id' => $student->student_id,
                        'first_name' => $student->first_name,
                        'middle_name' => $student->middle_name,
                        'last_name' => $student->last_name,
                        'suffix' => $student->suffix,
                        'full_name' => $student->display_name,
                        'grade_level_id' => $student->grade_level_id,
                        'grade_level_name' => $student->gradeLevel->name ?? 'N/A',
                        'strand_id' => $student->strand_id,
                        'strand_name' => $isSHS ? ($student->strand->name ?? 'Not Assigned') : 'N/A (JHS)',
                        'section_id' => $student->section_id,
                        'section_name' => $student->section->section_name ?? 'N/A',
                        'status_id' => $student->status_id,
                        'status_name' => $student->status->name ?? 'N/A',
                        'source' => 'accepted_new_enrollee'
                    ]
                ]);
            } else {
                // If no student record yet, use enrollee data
                $gradeLevel = $newEnrollee->shs_grade ?: $newEnrollee->desired_grade;
                $isSHS = in_array($gradeLevel, [11, 12]);
                
                return response()->json([
                    'success' => true,
                    'student' => [
                        'student_id' => $newEnrollee->id,
                        'first_name' => $newEnrollee->given_name,
                        'middle_name' => $newEnrollee->middle_name,
                        'last_name' => $newEnrollee->surname,
                        'suffix' => null,
                        'full_name' => $newEnrollee->surname . ', ' . $newEnrollee->given_name . ' ' . $newEnrollee->middle_name,
                        'grade_level_id' => $gradeLevel,
                        'grade_level_name' => $newEnrollee->shs_grade ? 'Grade ' . $newEnrollee->shs_grade : 'Grade ' . $newEnrollee->desired_grade,
                        'strand_id' => null,
                        'strand_name' => $isSHS ? ($newEnrollee->strand ?: 'Not Assigned Yet') : 'N/A (JHS)',
                        'section_id' => null,
                        'section_name' => 'Not Assigned Yet',
                        'status_id' => null,
                        'status_name' => 'Accepted New Student',
                        'source' => 'accepted_new_enrollee'
                    ]
                ]);
            }
        }

        // Third, check students table with proper relationships loaded
        $student = Student::with(['gradeLevel', 'strand', 'section', 'status'])
            ->where('lrn', $request->lrn)
            ->first();

        if ($student) {
            // Determine if this is SHS (Grades 11-12) or JHS (Grades 7-10)
            $isSHS = in_array($student->grade_level_id, [11, 12]);
            
            return response()->json([
                'success' => true,
                'student' => [
                    'student_id' => $student->student_id,
                    'first_name' => $student->first_name,
                    'middle_name' => $student->middle_name,
                    'last_name' => $student->last_name,
                    'suffix' => $student->suffix,
                    'full_name' => $student->display_name,
                    'grade_level_id' => $student->grade_level_id,
                    'grade_level_name' => $student->gradeLevel->name ?? 'N/A',
                    'strand_id' => $student->strand_id,
                    'strand_name' => $isSHS ? ($student->strand->name ?? 'Not Assigned') : 'N/A (JHS)',
                    'section_id' => $student->section_id,
                    'section_name' => $student->section->section_name ?? 'N/A',
                    'status_id' => $student->status_id,
                    'status_name' => $student->status->name ?? 'N/A',
                    'source' => 'students'
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Student not found with the provided LRN. Please check your LRN or contact the school if you believe this is an error.'
        ], 404);
    }
}
