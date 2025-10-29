<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\NewStudentEnrollee;
use App\Models\EnrollmentFee;
use App\Models\StudentDocument;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Mail\EnrollmentConfirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use App\Models\Strands;

class NewEnrollmentController extends Controller
{
    public function showStep1(Request $request)
    {
        // Check if coming from assessment result page
        $fromAssessment = $request->query('from_assessment', false);
        
        // Check for assessment email in session (from assessment page)
        $assessmentEmail = session('assessment_email');
        $assessmentResult = null;
        
        // Only auto-fill assessment data if coming from assessment result page
        if ($fromAssessment && $assessmentEmail) {
            // Get assessment result for current academic year only
            $assessmentResult = \App\Models\StrandAssessmentResult::latestForEmail($assessmentEmail)->first();
            
            if ($assessmentResult) {
                // Verify assessment is for current academic year
                $currentAcademicYear = \App\Models\AcademicYear::getCurrent();
                if ($assessmentResult->academic_year_id === $currentAcademicYear?->id) {
                    // Store assessment ID in session for later linking
                    session(['assessment_id' => $assessmentResult->id]);
                    
                    // Store assessment email in session for JavaScript access
                    session(['assessment_email_for_js' => $assessmentEmail]);
                    
                    // Set session marker to indicate assessment auto-fill should be enabled
                    session(['assessment_auto_fill' => true]);
                } else {
                    // Assessment is from different academic year, don't auto-fill
                    $assessmentResult = null;
                    session()->forget(['assessment_auto_fill', 'assessment_email_for_js']);
                }
            } else {
                // No assessment found for current academic year
                session()->forget(['assessment_auto_fill', 'assessment_email_for_js']);
            }
        } else {
            // Clear any existing assessment auto-fill session data
            session()->forget(['assessment_auto_fill', 'assessment_email_for_js']);
        }

        return view('new_step1', compact('assessmentResult'));
    }

    public function postStep1(Request $request)
    {
        // Debug: Log incoming request data
        Log::info('New Student Step 1 submission started', [
            'request_data' => $request->all(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        // Check if an existing enrolment exists with this email
        $existingEnrollee = NewStudentEnrollee::where('email', $request->input('email'))->first();
        
        if ($existingEnrollee) {
            Log::info('Found existing enrollment with same email, will update it', [
                'existing_enrollee_id' => $existingEnrollee->id,
                'email' => $request->input('email')
            ]);
            // Set session to existing enrollee ID
            session(['new_enrollee_id' => $existingEnrollee->id]);
        } else {
            Log::info('No existing enrollment found, will create new one');
            // Clear sessions for fresh enrollment
            session()->forget('new_enrollee_id');
        }
        
        session()->forget('step1_submitted_' . $request->ip());

        try {
            $data = $request->validate([
                'strand'                  => 'nullable|string|in:ABM,GAS,COMPREHENSIVE,STEM,HUMSS,HE,ICT',
                'shsGrade'                => 'nullable|in:11,12',
                'jhsGrade'                => 'nullable|in:7,8,9,10',
                'semester'                => 'nullable|string|in:1st,2nd',
                'surname'                 => 'required|string|max:255',
                'givenName'               => 'required|string|max:255',
                'middleName'              => 'nullable|string|max:255',
                'lrn'                     => 'required|string|size:12|regex:/^[0-9]{12}$/',
                'contactNo'               => 'required|string|regex:/^09[0-9]{9}$/',
                'email'                   => 'required|email|ends_with:@gmail.com',
                'address_house'           => 'required|string|max:255',
                'address_unit'            => 'nullable|string|max:255',
                'address_city'            => 'required|string|max:255',
                'address'                 => 'nullable|string|max:500', // Will be combined from above fields
                'dob'                     => 'required|date|before:'.date('Y-m-d', strtotime('-4 years')),
                'birthplace'              => 'required|string|max:255',
                'gender'                  => 'required|in:Male,Female,Other',
                'religion'                => 'required|string|max:255',
                'nationality'             => 'required|string|max:255',
                'formerSchool'            => 'required|string|max:255',
                'lastSchoolYear'          => 'required|string|in:2010-2011,2011-2012,2012-2013,2013-2014,2014-2015,2015-2016,2016-2017,2017-2018,2018-2019,2019-2020,2020-2021,2021-2022,2022-2023,2023-2024,2024-2025,2025-2026',
                'schoolType'              => 'required|string|in:Private,Public,Homeschool',
                'schoolAddress'           => 'required|string|max:500',
                'reasonTransfer'          => 'required|string|max:500',
                'workingStudent'          => 'nullable|in:Yes,No',
                'intendWorkingStudent'    => 'nullable|in:Yes,No',
                'siblings'                => 'nullable|integer|min:0',
                'clubMember'              => 'nullable|in:Yes,No',
                'clubName'                => 'nullable|string|required_if:clubMember,Yes|max:255',
                'fatherName'              => 'required|string|max:255',
                'fatherOccupation'        => 'required|string|max:255',
                'motherName'              => 'required|string|max:255',
                'motherOccupation'        => 'required|string|max:255',
                'guardianName'            => 'required|string|max:255',
                'guardianOccupation'      => 'required|string|max:255',
                'guardianContact'         => 'required|string|regex:/^09[0-9]{9}$/',
                'medicalHistory'          => 'nullable|array',
                'medicalHistory.*'       => 'string|in:Asthma,PhysicallyFit,SeizureDisorder,Allergy,HeartCondition,Others',
                'allergySpecify'          => 'nullable|string|max:500',
                'othersSpecify'           => 'nullable|string|max:500',
                'terms'                   => 'required|array|min:6',
                'terms.*'                 => 'string|in:completeness,abide,consequences,responsible,updated,aware',
            ]);
            
            // Validate semester is required when SHS is selected
            $gradeLevel = $request->input('gradeLevel');
            if ($gradeLevel === 'SHS' && !empty($data['shsGrade'])) {
                if (empty($data['semester']) || !in_array($data['semester'], ['1st', '2nd'])) {
                    throw ValidationException::withMessages([
                        'semester' => 'Semester is required for Senior High School students.'
                    ]);
                }
            } else {
                // Set default semester for JHS students (though they don't use it)
                $data['semester'] = $data['semester'] ?? '1st';
            }

            // Combine address fields
            $house = $data['address_house'] ?? '';
            $unit = $data['address_unit'] ?? '';
            $city = $data['address_city'] ?? '';
            
            $combinedAddress = $house;
            if (!empty($unit)) {
                $combinedAddress .= ', ' . $unit;
            }
            if (!empty($city)) {
                $combinedAddress .= ', ' . $city;
            }
            
            $data['address'] = $combinedAddress;
            
            Log::info('New Student Step 1 validation passed', ['validated_data' => $data]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('New Student Step 1 validation failed', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('New Student Step 1 error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            throw $e;
        }

        // Get current enrollee ID from session
        $currentEnrolleeId = session('new_enrollee_id');
        
        Log::info('Processing Step 1 submission', [
            'current_enrollee_id' => $currentEnrolleeId,
            'action' => $currentEnrolleeId ? 'updating_existing' : 'creating_new'
        ]);

        if ($currentEnrolleeId) {
            // Update existing enrollee
            Log::info('Updating existing enrollee', ['enrollee_id' => $currentEnrolleeId]);
            $enrollee = NewStudentEnrollee::findOrFail($currentEnrolleeId);

            $selectedCode = $data['strand'] ?? null;
            $oldCode = $enrollee->strand;

            DB::transaction(function () use (&$enrollee, $data, $selectedCode, $oldCode) {
                // Adjust strand counts atomically if changed and a strand is selected
                if ($selectedCode) {
                    $codeToName = [
                        'ABM' => 'ABM',
                        'GAS' => 'GAS',
                        'STEM' => 'STEM',
                        'HUMSS' => 'HUMSS',
                        'ICT' => 'TVL-ICT',
                        'HE' => 'TVL-HE',
                    ];

                    $newName = $codeToName[$selectedCode] ?? null;
                    $oldName = $oldCode ? ($codeToName[$oldCode] ?? null) : null;

                    if ($newName && $newName !== $oldName) {
                        $newStrand = Strands::where('name', $newName)->lockForUpdate()->first();
                        if ($newStrand) {
                            if (($newStrand->enrolled_count ?? 0) >= ($newStrand->capacity ?? 0)) {
                                throw ValidationException::withMessages([
                                    'strand' => "The {$selectedCode} strand is currently full. Please select another strand."
                                ]);
                            }
                            $newStrand->enrolled_count = ($newStrand->enrolled_count ?? 0) + 1;
                            $newStrand->save();
                        }

                        if ($oldName) {
                            $oldStrand = Strands::where('name', $oldName)->lockForUpdate()->first();
                            if ($oldStrand && ($oldStrand->enrolled_count ?? 0) > 0) {
                                $oldStrand->enrolled_count = $oldStrand->enrolled_count - 1;
                                $oldStrand->save();
                            }
                        }
                    }
                }

                // Update enrollee after count adjustments
                $enrollee->update([
                    'strand' => $data['strand'] ?? null,
                    'jhs_grade' => $data['jhsGrade'] ?? null,
                    'semester' => $data['semester'] ?? '1st',
                    'surname' => $data['surname'],
                    'given_name' => $data['givenName'],
                    'middle_name' => $data['middleName'],
                    'lrn' => $data['lrn'],
                    'contact_no' => $data['contactNo'],
                    'email' => $data['email'] ?? null,
                    'address' => $data['address'],
                    'dob' => $data['dob'],
                    'birthplace' => $data['birthplace'],
                    'gender' => $data['gender'],
                    'religion' => $data['religion'],
                    'nationality' => $data['nationality'],
                    'former_school' => $data['formerSchool'],
                    'last_school_year' => $data['lastSchoolYear'],
                ]);
            });
        } else {
            // Create new enrollee
            Log::info('Creating new enrollee');
            $selectedCode = $data['strand'] ?? null;
            $enrollee = null;

            DB::transaction(function () use (&$enrollee, $data, $selectedCode) {
                if ($selectedCode) {
                    $codeToName = [
                        'ABM' => 'ABM',
                        'GAS' => 'GAS',
                        'STEM' => 'STEM',
                        'HUMSS' => 'HUMSS',
                        'ICT' => 'TVL-ICT',
                        'HE' => 'TVL-HE',
                    ];
                    $name = $codeToName[$selectedCode] ?? null;
                    if ($name) {
                        $strand = Strands::where('name', $name)->lockForUpdate()->first();
                        if ($strand) {
                            if (($strand->enrolled_count ?? 0) >= ($strand->capacity ?? 0)) {
                                throw ValidationException::withMessages([
                                    'strand' => "The {$selectedCode} strand is currently full. Please select another strand."
                                ]);
                            }
                            $strand->enrolled_count = ($strand->enrolled_count ?? 0) + 1;
                            $strand->save();
                        }
                    }
                }

                $enrollee = NewStudentEnrollee::create([
                    'strand'                 => $data['strand'] ?? null,
                    'shs_grade'              => $data['shsGrade'] ?? null,
                    'jhs_grade'              => $data['jhsGrade'] ?? null,
                    'semester'               => $data['semester'] ?? '1st',
                    'surname'                => $data['surname'],
                    'given_name'             => $data['givenName'],
                    'middle_name'            => $data['middleName'],
                    'lrn'                    => $data['lrn'],
                    'contact_no'             => $data['contactNo'],
                    'email'                  => $data['email'] ?? null,
                    'address'                => $data['address'],
                    'dob'                    => $data['dob'],
                    'birthplace'             => $data['birthplace'],
                    'gender'                 => $data['gender'],
                    'religion'               => $data['religion'],
                    'nationality'            => $data['nationality'],
                    'former_school'          => $data['formerSchool'],
                    'last_school_year'       => $data['lastSchoolYear'],
                    'school_type'            => $data['schoolType'],
                    'school_address'         => $data['schoolAddress'],
                    'reason_transfer'        => $data['reasonTransfer'],
                    'working_student'        => ($data['workingStudent'] ?? 'No') === 'Yes',
                    'intend_working_student' => ($data['intendWorkingStudent'] ?? 'No') === 'Yes',
                    'siblings'               => $data['siblings'] ?? null,
                    'club_member'            => ($data['clubMember'] ?? 'No') === 'Yes',
                    'club_name'              => $data['clubName'] ?? null,
                    'father_name'            => $data['fatherName'],
                    'father_occupation'      => $data['fatherOccupation'],
                    'mother_name'            => $data['motherName'],
                    'mother_occupation'      => $data['motherOccupation'],
                    'guardian_name'          => $data['guardianName'],
                    'guardian_occupation'    => $data['guardianOccupation'],
                    'guardian_contact_no'    => $data['guardianContact'],
                    'medical_history'        => json_encode($data['medicalHistory'] ?? []),
                    'allergy_specify'        => $data['allergySpecify'] ?? null,
                    'others_specify'         => $data['othersSpecify'] ?? null,
                    'last_name'              => $data['surname'],
                    'first_name'             => $data['givenName'],
                    'pob'                    => $data['birthplace'],
                    'mobile'                 => $data['contactNo'],
                    'last_school'            => $data['formerSchool'],
                    'grade_completed'        => isset($data['jhsGrade']) ? ((int)$data['jhsGrade'] - 1) : (isset($data['shsGrade']) ? ((int)$data['shsGrade'] - 1) : 6),
                    'sy_completed'           => $data['lastSchoolYear'],
                    'form138_path'           => 'pending',
                    'desired_grade'          => isset($data['jhsGrade']) ? (int)$data['jhsGrade'] : (isset($data['shsGrade']) ? (int)$data['shsGrade'] : 7),
                ]);
            });
            
            Log::info('New enrollee created successfully', ['enrollee_id' => $enrollee->id]);
        }

        session(['new_enrollee_id' => $enrollee->id]);
        
        // Link assessment result if exists
        $assessmentId = session('assessment_id');
        if ($assessmentId) {
            \App\Models\StrandAssessmentResult::where('id', $assessmentId)
                ->update(['enrollment_id' => $enrollee->id, 'is_used' => true]);
            
            // Clear assessment session data
            session()->forget(['assessment_id', 'assessment_email']);
        }
        
        Log::info('New Student Step 1 completed successfully', [
            'enrollee_id' => $enrollee->id,
            'assessment_linked' => $assessmentId !== null,
            'redirecting_to' => 'enroll.new.step2'
        ]);
        
        return redirect()->route('enroll.new.step2');
    }

    public function showStep2()
    {
        $sessionId = session('new_enrollee_id');
        
        if (!$sessionId) {
            Log::error('No enrollment session found for Step 2 show', [
                'session' => session()->all()
            ]);
            return redirect()->route('enroll.new.step1')
                ->with('error', 'Session expired. Please start enrollment again.');
        }
        
        try {
            $enrollee = NewStudentEnrollee::findOrFail($sessionId);
            
            // Get existing documents from database
            $existingDocs = StudentDocument::where('enrollment_id', $enrollee->id)
                ->where('enrollment_type', 'new')
                ->get()
                ->keyBy('document_type');
            
            return view('new_step2', compact('enrollee', 'existingDocs'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Enrollee not found for Step 2', [
                'session_id' => $sessionId,
                'enrollee_exists' => NewStudentEnrollee::where('id', $sessionId)->exists()
            ]);
            return redirect()->route('enroll.new.step1')
                ->with('error', 'Enrollment data not found. Please start enrollment again.');
        }
    }

    public function postStep2(Request $request)
    {
        $enrollee = NewStudentEnrollee::findOrFail(
            session('new_enrollee_id')
        );

        // Check if documents already exist in database
        $existingDocs = StudentDocument::where('enrollment_id', $enrollee->id)
            ->where('enrollment_type', 'new')
            ->pluck('document_type')
            ->toArray();

        $requiredDocs = ['report_card', 'good_moral', 'birth_certificate', 'id_picture'];
        $hasAllDocs = count(array_intersect($requiredDocs, $existingDocs)) === count($requiredDocs);

        // Only validate files if they're being uploaded (not already in database)
        if (!$hasAllDocs) {
            $files = $request->validate([
                'reportCard'       => 'required|file|mimes:pdf,jpg,jpeg,png',
                'goodMoral'        => 'required|file|mimes:pdf,jpg,jpeg,png',
                'birthCertificate' => 'required|file|mimes:pdf,jpg,jpeg,png',
                'idPicture'        => 'required|file|mimes:jpg,jpeg,png',
            ]);
        }

        // Store documents in database instead of file system
        $documentMap = [
            'reportCard' => 'report_card',
            'goodMoral' => 'good_moral',
            'birthCertificate' => 'birth_certificate',
            'idPicture' => 'id_picture',
        ];

        foreach ($documentMap as $inputName => $docType) {
            $file = $request->file($inputName);
            
            // Only process if a new file is being uploaded
            if ($file) {
                // Delete old document if exists
                \App\Models\StudentDocument::where('enrollment_id', $enrollee->id)
                    ->where('enrollment_type', 'new')
                    ->where('document_type', $docType)
                    ->delete();
                
                // Store new document in database (base64 encoded)
                // Increase max_allowed_packet for large files
                try {
                    \DB::statement('SET GLOBAL max_allowed_packet = 67108864'); // 64MB
                } catch (\Exception $e) {
                    // If GLOBAL can't be set, try SESSION or just continue
                    try {
                        \DB::statement('SET SESSION max_allowed_packet = 67108864');
                    } catch (\Exception $e2) {
                        // Just continue - might work without setting it
                    }
                }
                
                \App\Models\StudentDocument::create([
                    'enrollment_id' => $enrollee->id,
                    'enrollment_type' => 'new',
                    'document_type' => $docType,
                    'original_filename' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                    'file_data' => base64_encode(file_get_contents($file->getRealPath())),
                ]);
                
                // Keep path references for backward compatibility
                $enrollee->update([
                    $docType . '_path' => 'db:' . $docType,
                ]);
            }
        }

        return redirect()->route('enroll.new.step3');
    }

    public function showStep3(Request $request)
    {
        $sessionId = session('new_enrollee_id');
        
        if (!$sessionId) {
            Log::error('No enrollment session found for Step 3 show', [
                'session' => session()->all()
            ]);
            return redirect()->route('enroll.new.step1')
                ->with('error', 'Session expired. Please start enrollment again.');
        }
        
        try {
            $enrollee = NewStudentEnrollee::findOrFail($sessionId);
            
            // Get the appropriate fee based on grade level
            // Check if SHS grade is set (Grade 11 or 12)
            $isSHS = !empty($enrollee->shs_grade) && ($enrollee->shs_grade == 11 || $enrollee->shs_grade == 12);
            $feeType = $isSHS ? EnrollmentFee::FEE_TYPE_NEW_SHS : EnrollmentFee::FEE_TYPE_NEW_JHS;
            $currentFee = EnrollmentFee::getCurrentFee($feeType);
            
            // Log for debugging
            Log::info('Fee determination for new enrollment', [
                'enrollee_id' => $enrollee->id,
                'shs_grade' => $enrollee->shs_grade,
                'jhs_grade' => $enrollee->jhs_grade,
                'isSHS' => $isSHS,
                'feeType' => $feeType,
                'currentFee_id' => $currentFee ? $currentFee->id : null,
                'currentFee_amount' => $currentFee ? $currentFee->amount : null
            ]);
            
            // If no fee is set, create a default fee object for display with amount 0
            if (!$currentFee) {
                $currentFee = new EnrollmentFee();
                $currentFee->amount = 0.00;
            }
            
            // Get existing payment receipt from database if exists
            $existingReceipt = StudentDocument::where('enrollment_id', $enrollee->id)
                ->where('enrollment_type', 'new')
                ->where('document_type', 'payment_receipt')
                ->first();
            
            return view('new_step3', compact('enrollee', 'currentFee', 'existingReceipt'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Enrollee not found for Step 3', [
                'session_id' => $sessionId,
                'enrollee_exists' => NewStudentEnrollee::where('id', $sessionId)->exists()
            ]);
            return redirect()->route('enroll.new.step1')
                ->with('error', 'Enrollment data not found. Please start enrollment again.');
        }
    }

    public function postStep3(Request $request)
    {
        Log::info('New Student Step 3 submission started', [
            'request_data' => $request->all(),
            'has_receipt' => $request->hasFile('receiptUpload'),
            'payment_method' => $request->input('paymentMethod'),
            'session_id' => session('new_enrollee_id'),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        Log::info('Looking up enrollee for Step 3', [
            'session_id' => session('new_enrollee_id')
        ]);

        $sessionId = session('new_enrollee_id');
        if (!$sessionId) {
            Log::error('No enrollment session found for Step 3');
            return redirect()->route('enroll.new.step1')
                ->with('error', 'No enrollment session found. Please start over.');
        }

        $enrollee = NewStudentEnrollee::find($sessionId);
        if (!$enrollee) {
            Log::error('Enrollee not found for Step 3', [
                'session_id' => $sessionId,
                'enrollee_exists' => NewStudentEnrollee::where('id', $sessionId)->exists()
            ]);
            return redirect()->route('enroll.new.step1')
                ->with('error', 'Enrollment data not found. Please start over.');
        }

        Log::info('Enrollee found successfully', [
            'enrollee_id' => $enrollee->id,
            'name' => $enrollee->display_name ?? 'unknown'
        ]);

        Log::info('Step 3 validation being processed', [
            'payment_method' => $request->input('paymentMethod'),
            'full_name' => $request->input('fullName'),
            'payment_ref' => $request->input('paymentRef'),
            'has_file' => $request->hasFile('receiptUpload')
        ]);

        // Check if receipt already exists in database
        $existingReceiptCheck = StudentDocument::where('enrollment_id', $enrollee->id)
            ->where('enrollment_type', 'new')
            ->where('document_type', 'payment_receipt')
            ->exists();

        // Only validate files if receipt doesn't exist in database
        $validationRules = [
            'paymentMethod' => 'required|in:digital,cash',
            'fullName'      => 'nullable|string',
            'paymentRef'    => 'nullable|string',
        ];
        
        if (!$existingReceiptCheck) {
            $validationRules['receiptUpload'] = 'required|file|mimes:jpg,jpeg,png,pdf';
        }
        
        $validatedData = $request->validate($validationRules);

        Log::info('Step 3 validation passed successfully', [
            'payment_method' => $validatedData['paymentMethod']
        ]);

        try {
            // Set payment data first (before file upload)
            if ($request->input('paymentMethod') === 'cash') {
                $enrollee->payment_applicant_name = 'Cash Payment';
                $enrollee->payment_reference      = 'CASH-' . date('YmdHis');
            } else {
                $enrollee->payment_applicant_name = $request->input('fullName');
                $enrollee->payment_reference      = $request->input('paymentRef');
            }
            
            $enrollee->paid = true;
            
            Log::info('Payment data set successfully', [
                'enrollee_id' => $enrollee->id,
                'payment_method' => $request->input('paymentMethod'),
                'applicant_name' => $enrollee->payment_applicant_name,
                'reference' => $enrollee->payment_reference
            ]);
            
                // Store receipt in database instead of filesystem (only if file is uploaded)
                if ($request->hasFile('receiptUpload')) {
                    try {
                        $receiptFile = $request->file('receiptUpload');
                        
                        // Delete old receipt if exists
                        StudentDocument::where('enrollment_id', $enrollee->id)
                            ->where('enrollment_type', 'new')
                            ->where('document_type', 'payment_receipt')
                            ->delete();
                        
                        // Store new receipt in database (base64 encoded)
                        // Increase max_allowed_packet for large files
                        try {
                            \DB::statement('SET GLOBAL max_allowed_packet = 67108864'); // 64MB
                        } catch (\Exception $e) {
                            // If GLOBAL can't be set, try SESSION or just continue
                            try {
                                \DB::statement('SET SESSION max_allowed_packet = 67108864');
                            } catch (\Exception $e2) {
                                // Just continue - might work without setting it
                            }
                        }
                        
                        StudentDocument::create([
                            'enrollment_id' => $enrollee->id,
                            'enrollment_type' => 'new',
                            'document_type' => 'payment_receipt',
                            'original_filename' => $receiptFile->getClientOriginalName(),
                            'mime_type' => $receiptFile->getMimeType(),
                            'file_size' => $receiptFile->getSize(),
                            'file_data' => base64_encode(file_get_contents($receiptFile->getRealPath())),
                        ]);
                        
                        Log::info('Receipt stored in database successfully', [
                            'enrollee_id' => $enrollee->id,
                            'file_size' => $receiptFile->getSize()
                        ]);
                    } catch (\Exception $fileError) {
                        Log::info('File upload error', [
                            'error' => $fileError->getMessage()
                        ]);
                    }
                }
                
                // Set payment receipt path reference
                $enrollee->payment_receipt_path = 'db:payment_receipt';
            
            // Save the enrollee
            $enrollee->save();
            
            Log::info('Step 3 save completed successfully', [
                'enrollee_id' => $enrollee->id,
                'payment_method' => $request->input('paymentMethod'),
                'receipt_path' => $enrollee->payment_receipt_path ?? 'not_set',
                'paid' => $enrollee->paid
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to save Step 3 data', [
                'enrollee_id' => $enrollee->id ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'payment_method' => $request->input('paymentMethod')
            ]);
            throw $e;
        }

        Log::info('New Student Step 3 completed successfully', [
            'enrollee_id' => $enrollee->id,
            'payment_method' => $request->input('paymentMethod'),
            'redirecting_to' => 'enroll.new.step4'
        ]);

        return redirect()->route('enroll.new.step4');
    }

    public function showStep4()
    {
        $enrollee = NewStudentEnrollee::findOrFail(session('new_enrollee_id'));

        // Generate unique application number if absent
        if (!$enrollee->application_number) {
            $year = now()->year;
            do {
                $token = strtoupper(\Illuminate\Support\Str::random(4));
                $appNum = "MCA-NEW-{$year}-{$token}";
            } while (NewStudentEnrollee::where('application_number', $appNum)->exists());
            $enrollee->update(['application_number' => $appNum]);
            
        // Refresh the enrollee object to get the updated application number
        $enrollee = $enrollee->fresh();
        }

        // Send confirmation email if email is available (send synchronously to avoid needing a queue worker)
        if ($enrollee->email) {
            try {
                \Illuminate\Support\Facades\Mail::to($enrollee->email)
                    ->send(new \App\Mail\EnrollmentConfirmation($enrollee));
                
                Log::info('Enrollment confirmation email sent successfully', [
                    'enrollee_id' => $enrollee->id,
                    'email' => $enrollee->email,
                    'application_number' => $enrollee->application_number
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to send enrollment confirmation email', [
                    'enrollee_id' => $enrollee->id,
                    'email' => $enrollee->email,
                    'error' => $e->getMessage()
                ]);
                // Don't fail the whole process if email fails
            }
        } else {
            Log::warning('No email address provided for enrollment confirmation', [
                'enrollee_id' => $enrollee->id
            ]);
        }

        // Generate deterministic 7-digit student number: yy + 5-digit enrollee ID
        $studentNumber = sprintf('%02d%05d', (int) now()->format('y'), (int) $enrollee->id);

        // Persist the generated student number so it can be used on admin acceptance
        try {
            \App\Models\StudentId::firstOrCreate([
                'student_number' => $studentNumber
            ]);
        } catch (\Exception $e) {
            Log::warning('Failed to persist generated student number', [
                'enrollee_id' => $enrollee->id,
                'student_number' => $studentNumber,
                'error' => $e->getMessage()
            ]);
        }

        return view('new_step4', compact('enrollee', 'studentNumber'));
    }

    public function checkEmailAvailability(Request $request)
    {
        $email = $request->email;
        
        $existsInEnrollees = NewStudentEnrollee::where('email', $email)
            ->where('id', '!=', session('new_enrollee_id', -1))
            ->exists();
            
        $existsInUsers = \App\Models\User::where('email', $email)->exists();
        
        return response()->json([
            'available' => !($existsInEnrollees || $existsInUsers)
        ]);
    }
}
