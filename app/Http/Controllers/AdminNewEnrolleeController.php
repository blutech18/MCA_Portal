<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewStudentEnrollee;
use App\Models\OldStudentEnrollee;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\StudentSection;
use App\Mail\StudentCredentialsMail;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminNewEnrolleeController extends Controller
{
    public function index(Request $request)
    {
        // Only show pending and accepted enrollees (exclude declined)
        $newEnrollees = NewStudentEnrollee::with('assessmentResult')
            ->where(function($query) {
                $query->whereIn('status', ['pending', 'accepted'])
                      ->orWhereNull('status');
            })->orderBy('created_at','desc')->get();
            
        $oldEnrollees = OldStudentEnrollee::where(function($query) {
            $query->whereIn('status', ['pending', 'accepted'])
                  ->orWhereNull('status');
        })->orderBy('created_at','desc')->get();
        
        
        return view('admin_new_enrollees', compact('newEnrollees', 'oldEnrollees'));
    }

    public function declined(Request $request)
    {
        // Show only declined enrollees
        $newEnrollees = NewStudentEnrollee::with('assessmentResult')
            ->where('status', 'declined')
            ->orderBy('status_updated_at','desc')
            ->get();
            
        $oldEnrollees = OldStudentEnrollee::where('status', 'declined')
            ->orderBy('status_updated_at','desc')
            ->get();
        
        return view('admin_declined_enrollees', compact('newEnrollees', 'oldEnrollees'));
    }

   public function newModal($id)
    {
        $enrollee = NewStudentEnrollee::with('assessmentResult')->find($id);
        
        if (!$enrollee) {
            return response()->json([
                'error' => 'Enrollee not found',
                'message' => 'This enrollee may have been moved or deleted.'
            ], 404);
        }
        
        return view('partials.enrollee_info', compact('enrollee'));
    }

    public function oldModal($id)
    {
        $enrollee = OldStudentEnrollee::find($id);
        
        if (!$enrollee) {
            return response()->json([
                'error' => 'Enrollee not found',
                'message' => 'This enrollee may have been moved or deleted.'
            ], 404);
        }
        
        Log::debug('ENROLLEE IN OLD MODAL: ', $enrollee->toArray());
        return view('partials.old_enrollee_info', compact('enrollee'));
    }

    public function destroy(NewStudentEnrollee $enrollee)
    {
        try {
            // Delete associated files
            if ($enrollee->form138_path) {
                Storage::disk('public')->delete($enrollee->form138_path);
            }
            if ($enrollee->payment_receipt_path) {
                Storage::disk('public')->delete($enrollee->payment_receipt_path);
            }
            if ($enrollee->clearance_path) {
                Storage::disk('public')->delete($enrollee->clearance_path);
            }

            // Delete the enrollee record
            $enrollee->delete();
            
            return redirect()->route('admin.enrollees')
                             ->with('success','New student enrollee removed successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting new enrollee: ' . $e->getMessage());
            return redirect()->route('admin.enrollees')
                             ->with('error','Failed to delete enrollee. Please try again.');
        }
    }

    public function destroyOld(OldStudentEnrollee $enrollee)
    {
        try {
            Log::info('Attempting to delete old enrollee: ' . $enrollee->id . ' - ' . $enrollee->display_name);
            
            // Delete associated files (OldStudentEnrollee doesn't have form138_path)
            if ($enrollee->payment_receipt_path) {
                Log::info('Deleting payment receipt: ' . $enrollee->payment_receipt_path);
                Storage::disk('public')->delete($enrollee->payment_receipt_path);
            }
            if ($enrollee->clearance_path) {
                Log::info('Deleting clearance: ' . $enrollee->clearance_path);
                Storage::disk('public')->delete($enrollee->clearance_path);
            }

            // Delete the enrollee record
            Log::info('Deleting enrollee record: ' . $enrollee->id);
            $enrollee->delete();
            
            Log::info('Successfully deleted old enrollee: ' . $enrollee->id);
            return redirect()->route('admin.enrollees')
                             ->with('success','Old student enrollee removed successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting old enrollee: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->route('admin.enrollees')
                             ->with('error','Failed to delete old enrollee. Please try again.');
        }
    }

    public function acceptNew(Request $request, $enrolleeId)
    {
        try {
            Log::info('Accept request received for enrollee ID: ' . $enrolleeId);
            
            // Find the enrollee manually
            $enrollee = NewStudentEnrollee::find($enrolleeId);
            if (!$enrollee) {
                Log::error('Enrollee not found with ID: ' . $enrolleeId);
                return response()->json([
                    'success' => false,
                    'message' => 'Enrollee not found.'
                ], 404);
            }

            Log::info('Enrollee found - Paid status: ' . ($enrollee->paid ? 'true' : 'false'));
            
            // Verify payment before accepting (must be Verified)
            $paymentStatus = $enrollee->payment_status ?? ($enrollee->paid ? 'Verified' : 'Pending Verification');
            if ($paymentStatus !== 'Verified') {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment verification required! Please verify the payment first by clicking the "View" button and updating the payment status to "Verified" before accepting this enrollee.'
                ], 400);
            }

            // Update status to accepted
            $enrollee->update([
                'status' => 'accepted',
                'status_updated_at' => now()
            ]);

            Log::info('Enrollee accepted successfully: ' . $enrolleeId);

            // Create student record in the system
            $result = $this->createStudentFromNewEnrollee($enrollee);

            // Get section info for response
            $sectionInfo = '';
            if (isset($result['section_name'])) {
                $sectionInfo = ' Assigned to: ' . $result['section_name'];
            }

            return response()->json([
                'success' => true,
                'message' => '✅ Enrollee accepted successfully! Student record created with login credentials.' . $sectionInfo,
                'data' => [
                    'student_number' => $result['student_number'] ?? null,
                    'username' => $result['username'] ?? null,
                    'password' => $result['password'] ?? null,
                    'section_name' => $result['section_name'] ?? null,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error accepting new enrollee: ' . $e->getMessage(), [
                'enrollee_id' => $enrolleeId,
                'error_trace' => $e->getTraceAsString()
            ]);
            
            // Provide more specific error messages based on the exception
            $errorMessage = 'An error occurred while accepting the enrollee.';
            if (strpos($e->getMessage(), 'Grade level') !== false) {
                $errorMessage = 'Grade level configuration error. Please contact administrator.';
            } elseif (strpos($e->getMessage(), 'section') !== false) {
                $errorMessage = 'Section assignment error. Please check section configuration.';
            } elseif (strpos($e->getMessage(), 'user') !== false) {
                $errorMessage = 'User account creation error. Please try again.';
            }
            
            return response()->json([
                'success' => false,
                'message' => $errorMessage
            ], 500);
        }
    }

    public function declineNew(Request $request, $enrolleeId)
    {
        try {
            Log::info('Decline request received for enrollee ID: ' . $enrolleeId);
            Log::info('Request data: ' . json_encode($request->all()));
            
            // Find the enrollee manually
            $enrollee = NewStudentEnrollee::find($enrolleeId);
            if (!$enrollee) {
                Log::error('Enrollee not found with ID: ' . $enrolleeId);
                return response()->json([
                    'success' => false,
                    'message' => 'Enrollee not found.'
                ], 404);
            }
            
            Log::info('Enrollee found: ' . json_encode($enrollee->toArray()));
            
            // Check the current record
            $currentRecord = DB::table('new_student_enrollees')->where('id', $enrolleeId)->first();
            Log::info('Current record: ' . json_encode($currentRecord));
            
            $request->validate([
                'decline_reason' => 'required|string',
                'decline_comments' => 'nullable|string'
            ]);

            $declineReason = $request->decline_reason;
            if ($request->decline_comments) {
                $declineReason .= ' - ' . $request->decline_comments;
            }

            // Try direct database update with explicit casting
            $result = DB::table('new_student_enrollees')
                ->where('id', $enrolleeId)
                ->update([
                    'status' => 'declined',
                    'decline_reason' => $declineReason,
                    'status_updated_at' => now()->format('Y-m-d H:i:s')
                ]);

            Log::info('Direct DB update result: ' . $result);
            
            // If direct update fails, try with raw SQL
            if ($result == 0) {
                $rawResult = DB::statement("UPDATE new_student_enrollees SET status = 'declined', decline_reason = ?, status_updated_at = NOW() WHERE id = ?", [$declineReason, $enrolleeId]);
                Log::info('Raw SQL update result: ' . ($rawResult ? 'true' : 'false'));
            }
            
            // Also try model update
            $modelResult = $enrollee->update([
                'status' => 'declined',
                'decline_reason' => $declineReason,
                'status_updated_at' => now()
            ]);

            Log::info('Model update result: ' . ($modelResult ? 'true' : 'false'));
            
            // Refresh the model to get updated data
            $enrollee->refresh();
            Log::info('After refresh - Status: ' . $enrollee->status . ', Decline reason: ' . $enrollee->decline_reason);
            
            // Check if the record was actually updated in the database
            $dbRecord = DB::table('new_student_enrollees')->where('id', $enrolleeId)->first();
            Log::info('DB record status: ' . ($dbRecord->status ?? 'null') . ', decline_reason: ' . ($dbRecord->decline_reason ?? 'null'));

            return response()->json([
                'success' => true,
                'message' => '✅ Enrollee declined successfully.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error declining new enrollee: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while declining the enrollee.'
            ], 500);
        }
    }

    public function acceptOld(Request $request, $enrolleeId)
    {
        try {
            Log::info('Accept request received for old enrollee ID: ' . $enrolleeId);
            
            // Find the enrollee manually
            $enrollee = OldStudentEnrollee::find($enrolleeId);
            if (!$enrollee) {
                Log::error('Old enrollee not found with ID: ' . $enrolleeId);
                return response()->json([
                    'success' => false,
                    'message' => 'Enrollee not found.'
                ], 404);
            }

            Log::info('Old enrollee found - Paid status: ' . ($enrollee->paid ? 'true' : 'false'));
            
            // Verify payment before accepting (must be Verified)
            $paymentStatus = $enrollee->payment_status ?? ($enrollee->paid ? 'Verified' : 'Pending Verification');
            if ($paymentStatus !== 'Verified') {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment verification required! Please verify the payment first by clicking the "View" button and updating the payment status to "Verified" before accepting this enrollee.'
                ], 400);
            }

            // Update status to accepted
            $enrollee->update([
                'status' => 'accepted',
                'status_updated_at' => now()
            ]);

            Log::info('Old enrollee accepted successfully: ' . $enrolleeId);

            // Update existing student record in the system
            $result = $this->updateStudentFromOldEnrollee($enrollee);

            // Get section info for response
            $sectionInfo = '';
            if (isset($result['section_name'])) {
                $sectionInfo = ' Assigned to: ' . $result['section_name'];
            }

            return response()->json([
                'success' => true,
                'message' => '✅ Old enrollee accepted successfully! Student record updated.' . $sectionInfo,
                'data' => [
                    'section_name' => $result['section_name'] ?? null,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error accepting old enrollee: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while accepting the enrollee.'
            ], 500);
        }
    }

    public function declineOld(Request $request, $enrolleeId)
    {
        try {
            Log::info('Decline request received for old enrollee ID: ' . $enrolleeId);
            Log::info('Request data: ' . json_encode($request->all()));
            
            // Find the enrollee manually
            $enrollee = OldStudentEnrollee::find($enrolleeId);
            if (!$enrollee) {
                Log::error('Old enrollee not found with ID: ' . $enrolleeId);
                return response()->json([
                    'success' => false,
                    'message' => 'Enrollee not found.'
                ], 404);
            }
            
            Log::info('Old enrollee found: ' . json_encode($enrollee->toArray()));
            
            $request->validate([
                'decline_reason' => 'required|string',
                'decline_comments' => 'nullable|string'
            ]);

            $declineReason = $request->decline_reason;
            if ($request->decline_comments) {
                $declineReason .= ' - ' . $request->decline_comments;
            }

            $enrollee->update([
                'status' => 'declined',
                'decline_reason' => $declineReason,
                'status_updated_at' => now()
            ]);

            Log::info('Old enrollee declined successfully: ' . $enrolleeId);

            return response()->json([
                'success' => true,
                'message' => '✅ Enrollee declined successfully.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error declining old enrollee: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while declining the enrollee.'
            ], 500);
        }
    }

    public function viewPayment(Request $request, $enrolleeId)
    {
        try {
            Log::info('View payment request received for old enrollee ID: ' . $enrolleeId);
            
            // Find the enrollee
            $enrollee = OldStudentEnrollee::find($enrolleeId);
            if (!$enrollee) {
                Log::error('Old enrollee not found with ID: ' . $enrolleeId);
                return response()->json([
                    'success' => false,
                    'message' => 'Enrollee not found.'
                ], 404);
            }

            Log::info('Payment details retrieved for enrollee: ' . $enrolleeId, [
                'enrollee_id' => $enrollee->id,
                'payment_receipt_path' => $enrollee->payment_receipt_path,
                'paid' => $enrollee->paid,
                'payment_applicant_name' => $enrollee->payment_applicant_name
            ]);

            // Generate full URL for the receipt file
            $receiptUrl = null;
            $fileExists = false;
            if ($enrollee->payment_receipt_path) {
                $receiptUrl = asset('storage/' . $enrollee->payment_receipt_path);
                $filePath = storage_path('app/public/' . $enrollee->payment_receipt_path);
                $fileExists = file_exists($filePath);
                
                Log::info('File check for enrollee: ' . $enrolleeId, [
                    'file_path' => $filePath,
                    'file_exists' => $fileExists,
                    'receipt_url' => $receiptUrl
                ]);
            }

            return response()->json([
                'success' => true,
                'payment' => [
                    'payment_applicant_name' => $enrollee->payment_applicant_name,
                    'payment_reference' => $enrollee->payment_reference,
                    'payment_receipt_path' => $enrollee->payment_receipt_path,
                    'payment_receipt_url' => $receiptUrl,
                    'file_exists' => $fileExists,
                    'paid' => $enrollee->paid,
                    'payment_verified' => $enrollee->payment_verified ?? false
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error viewing payment for old enrollee: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving payment details.'
            ], 500);
        }
    }

    public function verifyPayment(Request $request, $enrolleeId)
    {
        try {
            Log::info('Verify payment request received for old enrollee ID: ' . $enrolleeId);
            
            // Find the enrollee
            $enrollee = OldStudentEnrollee::find($enrolleeId);
            if (!$enrollee) {
                Log::error('Old enrollee not found with ID: ' . $enrolleeId);
                return response()->json([
                    'success' => false,
                    'message' => 'Enrollee not found.'
                ], 404);
            }

            // Check if payment exists
            if (!$enrollee->paid) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot verify payment. No payment found for this enrollee.'
                ], 400);
            }

            // Update payment verification status
            $enrollee->update([
                'payment_verified' => true,
                'payment_verified_at' => now()
            ]);

            Log::info('Payment verified successfully for old enrollee: ' . $enrolleeId);

            return response()->json([
                'success' => true,
                'message' => 'Payment verified successfully.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error verifying payment for old enrollee: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while verifying payment.'
            ], 500);
        }
    }

    public function updatePaymentStatus(Request $request, string $type, int $id)
    {
        // Check if user is admin (middleware already handles authentication)
        if (Auth::user()->user_type !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'payment_status' => 'required|string|in:Pending Verification,Verified,Invalid,Rejected',
        ]);

        $adminName = optional(Auth::user())->username ?? optional(Auth::user())->name ?? 'admin';

        if ($type === 'new') {
            $enrollee = NewStudentEnrollee::findOrFail($id);
        } else {
            $enrollee = OldStudentEnrollee::findOrFail($id);
        }

        $enrollee->payment_status = $validated['payment_status'];
        // Keep backward compatibility with boolean paid/payment_verified if present
        $enrollee->paid = $validated['payment_status'] === 'Verified';
        if (isset($enrollee->payment_verified)) {
            $enrollee->payment_verified = $validated['payment_status'] === 'Verified';
            if ($enrollee->payment_verified) {
                $enrollee->payment_verified_at = now();
            }
        }
        $enrollee->payment_status_changed_at = now();
        $enrollee->payment_status_changed_by = $adminName;
        $enrollee->save();

        return response()->json([
            'success' => true,
            'payment_status' => $enrollee->payment_status,
            'paid' => (bool) $enrollee->paid,
            'changed_at' => optional($enrollee->payment_status_changed_at)->toDateTimeString(),
            'changed_by' => $enrollee->payment_status_changed_by,
        ]);
    }

    /**
     * Create a new student record from accepted new enrollee
     */
    private function createStudentFromNewEnrollee($enrollee)
    {
        try {
            DB::beginTransaction();

            // Create student ID record using deterministic 7-digit number: yy + 5-digit enrollee ID
            $studentNumber = sprintf('%02d%05d', (int) now()->format('y'), (int) $enrollee->id);
            $studentId = \App\Models\StudentId::firstOrCreate([
                'student_number' => $studentNumber
            ]);

            // Determine grade level
            $gradeLevelId = $this->getGradeLevelId($enrollee);
            
            // Determine strand ID if applicable
            $strandId = $this->getStrandId($enrollee->strand);

            // Automatically assign student to appropriate section
            $sectionId = $this->assignSectionToStudent($gradeLevelId, $strandId);

            // Create user account first
            $user = $this->createUserAccount($enrollee, $studentNumber);

            // Create student record with user_id
            $student = \App\Models\Student::create([
                'school_student_id' => $studentNumber,
                'user_id' => $user->user_id, // Set the user_id from created user
                'first_name' => $enrollee->given_name,
                'middle_name' => $enrollee->middle_name,
                'last_name' => $enrollee->surname,
                'suffix' => null,
                'picture' => $enrollee->id_picture_path,
                'gender' => in_array($enrollee->gender, ['male', 'female']) ? $enrollee->gender : 'male',
                'date_of_birth' => $enrollee->dob,
                'contact_number' => $enrollee->contact_no,
                'email' => $enrollee->email,
                'address' => $enrollee->address,
                'grade_level_id' => $gradeLevelId,
                'strand_id' => $strandId,
                'section_id' => $sectionId,
                'status_id' => $this->getEnrolledStatusId(),
                'date_enrolled' => now(),
                'semester' => $enrollee->semester,
                'grade_id' => 1, // Default grade ID
                'schedule_id' => null,
                'documents_id' => null,
                'attendance_report_id' => null,
                'lrn' => $enrollee->lrn,
            ]);

            // Note: student_id field doesn't exist in students table, removed this update

            // Assign default subjects to the student
            $student->assignDefaultSubjects();

            // Get section name for response
            $section = \App\Models\StudentSection::find($sectionId);
            $sectionName = $section ? $section->section_name : 'N/A';

            DB::commit();
            
            Log::info('Student record created successfully for new enrollee: ' . $enrollee->id, [
                'student_number' => $studentNumber,
                'section_id' => $sectionId,
                'section_name' => $sectionName
            ]);
            
            return [
                'student_number' => $studentNumber,
                'username' => $user->username,
                // Return plain password format used; for registrar distribution only
                'password' => strtolower(preg_replace('/[^a-z0-9]/', '', ($enrollee->surname ?? 'student'))) . date('Y', strtotime($enrollee->dob ?? '2000-01-01')),
                'section_name' => $sectionName,
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating student record for new enrollee: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Update existing student record from accepted old enrollee
     */
    private function updateStudentFromOldEnrollee($enrollee)
    {
        try {
            DB::beginTransaction();

            // Find existing student by LRN
            $student = \App\Models\Student::where('lrn', $enrollee->lrn)->first();
            
            if (!$student) {
                // If no existing student found, create a new one
                $this->createStudentFromOldEnrollee($enrollee);
                return;
            }

            // Update existing student record
            $gradeLevelId = $this->getGradeLevelId($enrollee);
            $strandId = $this->getStrandId($enrollee->strand ?? null);
            
            // If grade level changed, need to reassign section
            $needsNewSection = ($student->grade_level_id != $gradeLevelId);
            $oldSectionId = $student->section_id;
            
            if ($needsNewSection) {
                // Assign to new section using first-come-first-serve logic
                $newSectionId = $this->assignSectionToStudent($gradeLevelId, $strandId);
                
                // Decrement old section count if student had a section
                if ($oldSectionId) {
                    $oldSection = \App\Models\StudentSection::find($oldSectionId);
                    if ($oldSection) {
                        $oldSection->decrementStudentCount();
                    }
                }
                
                $student->section_id = $newSectionId;
            }
            
            $student->update([
                'grade_level_id' => $gradeLevelId,
                'strand_id' => $strandId,
                'status_id' => $this->getEnrolledStatusId(),
                'date_enrolled' => now(),
                'semester' => $enrollee->semester,
                'contact_number' => $enrollee->contact_no ?? $student->contact_number,
                'email' => $enrollee->email ?? $student->email,
                'address' => $enrollee->address ?? $student->address,
            ]);

            // Get section name for response
            $section = \App\Models\StudentSection::find($student->section_id);
            $sectionName = $section ? $section->section_name : 'N/A';

            DB::commit();
            
            Log::info('Student record updated successfully for old enrollee: ' . $enrollee->id, [
                'student_id' => $student->student_id,
                'new_grade_level' => $gradeLevelId,
                'section_changed' => $needsNewSection,
                'new_section_id' => $student->section_id,
                'section_name' => $sectionName
            ]);
            
            return [
                'section_name' => $sectionName,
            ];
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating student record for old enrollee: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Create a new student record from accepted old enrollee (fallback)
     */
    private function createStudentFromOldEnrollee($enrollee)
    {
        try {
            DB::beginTransaction();

            // Create student ID record
            $studentId = \App\Models\StudentId::create([
                'student_number' => $enrollee->application_number
            ]);

            // Determine grade level and strand
            $gradeLevelId = $this->getGradeLevelId($enrollee);
            $strandId = $this->getStrandId($enrollee->strand ?? null);
            
            // Automatically assign student to appropriate section
            $sectionId = $this->assignSectionToStudent($gradeLevelId, $strandId);

            // Create user account first
            $user = $this->createUserAccount($enrollee, $enrollee->application_number);

            // Create student record with user_id
            $student = \App\Models\Student::create([
                'school_student_id' => $enrollee->application_number,
                'user_id' => $user->user_id, // Set the user_id from created user
                'first_name' => $enrollee->given_name,
                'middle_name' => $enrollee->middle_name,
                'last_name' => $enrollee->surname,
                'suffix' => null,
                'picture' => null,
                'gender' => 'male', // Default gender
                'date_of_birth' => '2000-01-01', // Default DOB
                'contact_number' => $enrollee->contact_no ?? '0000000000',
                'email' => $enrollee->email ?? 'default@email.com',
                'address' => $enrollee->address ?? 'Default Address',
                'grade_level_id' => $gradeLevelId,
                'strand_id' => $strandId,
                'section_id' => $sectionId,
                'status_id' => $this->getEnrolledStatusId(),
                'date_enrolled' => now(),
                'semester' => $enrollee->semester,
                'grade_id' => 1, // Default grade ID
                'schedule_id' => null,
                'documents_id' => null,
                'attendance_report_id' => null,
                'lrn' => $enrollee->lrn,
            ]);

            // Note: student_id field doesn't exist in students table, removed this update

            // Assign default subjects to the student
            $student->assignDefaultSubjects();

            DB::commit();
            
            Log::info('Student record created successfully for old enrollee: ' . $enrollee->id, [
                'student_id' => $student->student_id,
                'section_id' => $sectionId,
                'grade_level_id' => $gradeLevelId
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating student record for old enrollee: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get grade level ID based on enrollee data
     */
    private function getGradeLevelId($enrollee)
    {
        // Determine grade number first
        $gradeNumber = 7; // default
        
        // For new enrollees, check if they have SHS grade first
        if (isset($enrollee->shs_grade) && $enrollee->shs_grade && is_numeric($enrollee->shs_grade)) {
            $gradeNumber = (int)$enrollee->shs_grade;
        }
        // For new enrollees, check if they have JHS grade
        elseif (isset($enrollee->jhs_grade) && $enrollee->jhs_grade && is_numeric($enrollee->jhs_grade)) {
            $gradeNumber = (int)$enrollee->jhs_grade;
        }
        // For new enrollees, use desired_grade
        elseif (isset($enrollee->desired_grade) && $enrollee->desired_grade && is_numeric($enrollee->desired_grade)) {
            $gradeNumber = (int)$enrollee->desired_grade;
        }
        // For old enrollees, use grade_level_applying
        elseif (isset($enrollee->grade_level_applying) && $enrollee->grade_level_applying && is_numeric($enrollee->grade_level_applying)) {
            $gradeNumber = (int)$enrollee->grade_level_applying;
        }
        
        // Validate grade number is within valid range (7-12)
        if ($gradeNumber < 7 || $gradeNumber > 12) {
            Log::warning('Invalid grade number detected, using default grade 7', [
                'invalid_grade' => $gradeNumber,
                'enrollee_id' => $enrollee->id ?? 'unknown'
            ]);
            $gradeNumber = 7;
        }
        
        // Query database to get actual grade_level_id
        // Try different name formats since grade levels might be stored as "Grade 7" or "7"
        $gradeLevel = \App\Models\GradeLevel::where('name', "Grade $gradeNumber")->first();
        
        if (!$gradeLevel) {
            // Fallback: try with just the number
            $gradeLevel = \App\Models\GradeLevel::where('name', (string)$gradeNumber)->first();
        }
        
        if (!$gradeLevel) {
            Log::error('Grade level not found in database', [
                'grade_number' => $gradeNumber,
                'enrollee_id' => $enrollee->id ?? 'unknown'
            ]);
            // Fallback: try to find any grade 7 as default
            $gradeLevel = \App\Models\GradeLevel::where('name', "Grade 7")->first();
            
            if (!$gradeLevel) {
                Log::critical('No grade levels found in database! This is a critical system error.');
                throw new \Exception('Grade level system not properly configured. Please contact administrator.');
            }
        }
        
        Log::info('Grade level mapping', [
            'grade_number' => $gradeNumber,
            'grade_level_id' => $gradeLevel ? $gradeLevel->grade_level_id : null,
            'enrollee_id' => $enrollee->id ?? 'unknown'
        ]);
        
        return $gradeLevel ? $gradeLevel->grade_level_id : null;
    }

    /**
     * Get strand ID by name with flexible matching
     */
    private function getStrandId($strandName)
    {
        if (!$strandName) {
            return null;
        }
        
        // Ensure strands table has data
        $this->ensureStrandsExist();
        
        // First try exact match
        $strand = \App\Models\Strands::where('name', $strandName)->first();
        if ($strand) {
            return $strand->id;
        }
        
        // If no exact match, try flexible matching for common abbreviations
        $strandMappings = [
            'HE' => 'TVL-HE',
            'ICT' => 'TVL-ICT',
            'STEM' => 'STEM',
            'ABM' => 'ABM',
            'HUMSS' => 'HUMSS',
            'GAS' => 'GAS',
            'TVL' => 'TVL-HE', // Default TVL to HE if just TVL is specified
        ];
        
        $normalizedName = strtoupper(trim($strandName));
        if (isset($strandMappings[$normalizedName])) {
            $strand = \App\Models\Strands::where('name', $strandMappings[$normalizedName])->first();
            if ($strand) {
                return $strand->id;
            }
        }
        
        // If still no match, try partial matching
        $strand = \App\Models\Strands::where('name', 'LIKE', '%' . $normalizedName . '%')->first();
        return $strand ? $strand->id : null;
    }
    
    /**
     * Ensure strands table has the required data
     */
    private function ensureStrandsExist()
    {
        $strandCount = \App\Models\Strands::count();
        
        if ($strandCount == 0) {
            $strands = [
                ['name' => 'STEM', 'no_of_sections' => 2],
                ['name' => 'ABM', 'no_of_sections' => 2],
                ['name' => 'HUMSS', 'no_of_sections' => 2],
                ['name' => 'GAS', 'no_of_sections' => 1],
                ['name' => 'TVL-ICT', 'no_of_sections' => 1],
                ['name' => 'TVL-HE', 'no_of_sections' => 1],
            ];
            
            foreach ($strands as $strand) {
                \App\Models\Strands::create($strand);
            }
            
            Log::info('Created missing strands in database');
        }
    }

    /**
     * Get enrolled status ID
     */
    private function getEnrolledStatusId()
    {
        $status = \App\Models\StudentStatus::where('name', 'Enrolled')->first();
        return $status ? $status->id : 1; // Default to ID 1 if not found
    }

    /**
     * Create a user account for the enrollee
     */
    private function createUserAccount($enrollee, $studentNumber)
    {
        try {
            // Try find by email first, but ONLY if it's a student type user
            $user = null;
            if (!empty($enrollee->email)) {
                $user = User::where('email', $enrollee->email)
                            ->where('user_type', 'student')
                            ->first();
            }

            if (!$user) {
                // Generate username format: lastname.IDnumber
                $lastname = strtolower($enrollee->surname ?? 'student');
                $lastname = preg_replace('/[^a-z0-9]/', '', $lastname); // Remove special characters

                $username = $lastname . '.' . $studentNumber;

                // Ensure username uniqueness
                $originalUsername = $username;
                $counter = 1;
                while (User::where('username', $username)->exists()) {
                    $username = $originalUsername . $counter;
                    $counter++;
                }

                // Generate password format: lastnamebirthyear (e.g., delacruz2000)
                $birthDate = $enrollee->dob ?? '2000-01-01';
                $birthYear = date('Y', strtotime($birthDate));
                $lastnameForPassword = strtolower($enrollee->surname ?? 'student');
                $lastnameForPassword = preg_replace('/[^a-z0-9]/', '', $lastnameForPassword);
                $password = $lastnameForPassword . $birthYear;

                Log::info('Creating student account with credentials', [
                    'enrollee_id' => $enrollee->id,
                    'username' => $username,
                    'password_format' => $lastnameForPassword . $birthYear,
                    'birth_year' => $birthYear
                ]);

                $user = User::create([
                    'name' => trim(($enrollee->given_name ?? '') . ' ' . ($enrollee->surname ?? '')),
                    'username' => $username,
                    'email' => $enrollee->email ?: ($username . '@noemail.local'),
                    'password' => Hash::make($password), // Properly hash the password
                    'user_type' => 'student',
                ]);

                Log::info('User account created successfully', [
                    'user_id' => $user->user_id,
                    'username' => $user->username,
                    'email' => $user->email
                ]);
            } else {
                Log::info('Using existing user account', [
                    'user_id' => $user->user_id,
                    'username' => $user->username,
                    'email' => $user->email
                ]);
            }

            return $user;
        } catch (\Exception $e) {
            Log::error('Error creating user account: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Ensure there is a User account for this student and link it
     */
    private function attachUserAccount(\App\Models\Student $student, $enrollee): void
    {
        try {
            // Try find by email first, but ONLY if it's a student type user
            $user = null;
            if (!empty($student->email)) {
                $user = User::where('email', $student->email)
                            ->where('user_type', 'student')
                            ->first();
            }

            if (!$user) {
                // Generate username format: lastname.IDnumber (use official student_number when available)
                $lastname = strtolower($student->last_name ?? 'student');
                $lastname = preg_replace('/[^a-z0-9]/', '', $lastname); // Remove special characters

                // Use our deterministic student number if available
                $idNumber = optional($student->studentId)->student_number
                    ?? sprintf('%02d%05d', (int) now()->format('y'), (int) ($enrollee->id ?? 1));

                $username = $lastname . '.' . $idNumber;

                // Ensure username uniqueness
                $originalUsername = $username;
                $counter = 1;
                while (User::where('username', $username)->exists()) {
                    $username = $originalUsername . $counter;
                    $counter++;
                }

                // Generate password format: lastnamebirthyear (e.g., delacruz2000)
                $birthDate = $student->date_of_birth ?? '2000-01-01';
                $birthYear = date('Y', strtotime($birthDate));
                $lastnameForPassword = strtolower($student->last_name ?? 'student');
                $lastnameForPassword = preg_replace('/[^a-z0-9]/', '', $lastnameForPassword);
                $password = $lastnameForPassword . $birthYear;

                Log::info('Creating student account with credentials', [
                    'student_id' => $student->student_id,
                    'username' => $username,
                    'password_format' => $lastnameForPassword . $birthYear,
                    'birth_year' => $birthYear
                ]);

                $user = User::create([
                    'name' => trim(($student->first_name ?? '') . ' ' . ($student->last_name ?? '')),
                    'username' => $username,
                    'email' => $student->email ?: ($username . '@noemail.local'),
                    'password' => $password, // Automatically hashed by Laravel
                    'user_type' => 'student',
                ]);

                Log::info('Student account created successfully', [
                    'user_id' => $user->user_id,
                    'username' => $username,
                    'credentials_ready' => true
                ]);
            }

            // Link student to user if not already linked
            if (!$student->user_id) {
                $student->update(['user_id' => $user->user_id]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to attach/create user for student ID ' . $student->student_id . ': ' . $e->getMessage());
        }
    }

    /**
     * Automatically assign a student to an appropriate section
     * Uses strict first-come-first-serve logic with capacity enforcement
     * 
     * @param int $gradeLevelId The grade level ID (7-12)
     * @param int|null $strandId The strand ID (for SHS only)
     * @return int The section ID
     * @throws \Exception if no available section found
     */
    private function assignSectionToStudent($gradeLevelId, $strandId = null)
    {
        try {
            Log::info('🎯 Starting section assignment', [
                'grade_level_id' => $gradeLevelId,
                'strand_id' => $strandId
            ]);
            
            // Use the new first-come-first-serve logic from StudentSection model
            $section = \App\Models\StudentSection::findAvailableSection($gradeLevelId, $strandId);
            
            if (!$section) {
                // Check if all sections are full
                $allFull = \App\Models\StudentSection::allSectionsFull($gradeLevelId, $strandId);
                
                if ($allFull) {
                    $gradeLevel = \App\Models\GradeLevel::find($gradeLevelId);
                    $strand = $strandId ? \App\Models\Strands::find($strandId) : null;
                    
                    $errorMsg = sprintf(
                        "Cannot approve student. All sections for Grade %s%s are full. " .
                        "Please create additional sections before approving more students.",
                        $gradeLevel ? $gradeLevel->name : $gradeLevelId,
                        $strand ? " - {$strand->name}" : ""
                    );
                    
                    Log::error('❌ SECTION CAPACITY EXCEEDED', [
                        'grade_level_id' => $gradeLevelId,
                        'strand_id' => $strandId,
                        'message' => $errorMsg
                    ]);
                    
                    throw new \Exception($errorMsg);
                }
                
                // No sections exist at all
                $gradeLevel = \App\Models\GradeLevel::find($gradeLevelId);
                $strand = $strandId ? \App\Models\Strands::find($strandId) : null;
                
                $errorMsg = sprintf(
                    "Cannot approve student. No pre-made sections found for Grade %s%s. " .
                    "Please create sections in Section Management before approving students.",
                    $gradeLevel ? $gradeLevel->name : $gradeLevelId,
                    $strand ? " - {$strand->name}" : ""
                );
                
                Log::error('❌ NO SECTIONS AVAILABLE', [
                    'grade_level_id' => $gradeLevelId,
                    'strand_id' => $strandId,
                    'message' => $errorMsg
                ]);
                
                throw new \Exception($errorMsg);
            }
            
            // Ensure default classes exist for this section
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
            
            // Increment section count IMMEDIATELY to reserve the spot
            $section->incrementStudentCount();
            
            Log::info('✅ Student assigned to section successfully', [
                'section_id' => $section->id,
                'section_name' => $section->section_name,
                'grade_level_id' => $gradeLevelId,
                'strand_id' => $strandId,
                'current_count' => $section->current_count,
                'max_capacity' => $section->max_capacity,
                'is_full' => $section->is_full
            ]);
            
            return $section->id;

        } catch (\Exception $e) {
            Log::error('Failed to assign section to student', [
                'grade_level_id' => $gradeLevelId,
                'strand_id' => $strandId,
                'error' => $e->getMessage()
            ]);
            
            throw $e;
        }
    }

    /**
     * Create a default section for a grade level
     * 
     * @param int $gradeLevelId The grade level ID (7-12)
     * @param int|null $strandId The strand ID (for SHS only)
     * @param bool $isAdditional Whether this is an additional section (when others are full)
     * @return \App\Models\StudentSection|null The created section or null on failure
     */
    private function createDefaultSection($gradeLevelId, $strandId = null, $isAdditional = false)
    {
        try {
            // Get grade level name for section naming
            $gradeLevel = \App\Models\GradeLevel::find($gradeLevelId);
            if (!$gradeLevel) {
                Log::error('Grade level not found: ' . $gradeLevelId);
                return null;
            }

            // Get strand name for SHS sections
            $strandName = '';
            if ($strandId) {
                $strand = \App\Models\Strands::find($strandId);
                $strandName = $strand ? ' - ' . $strand->name : '';
            }

            // Determine section letter (A, B, C, etc.)
            $existingSections = \App\Models\StudentSection::where('grade_level_id', $gradeLevelId)
                ->when($strandId, function($q) use ($strandId) {
                    return $q->where('strand_id', $strandId);
                })
                ->count();

            $sectionLetter = chr(65 + $existingSections); // A=65, B=66, etc.

            // Create section name: "Grade 11 - STEM - Section A"
            $sectionName = "Grade {$gradeLevel->name}{$strandName} - Section {$sectionLetter}";

            // Create the section
            $section = \App\Models\StudentSection::create([
                'section_name' => $sectionName,
                'grade_level_id' => $gradeLevelId,
                'strand_id' => $strandId
            ]);

            Log::info('✅ AUTO-CREATED SECTION', [
                'section_id' => $section->id,
                'section_name' => $section->section_name,
                'grade_level_id' => $gradeLevelId,
                'grade_level_name' => $gradeLevel->name,
                'strand_id' => $strandId,
                'strand_name' => $strandName,
                'is_additional' => $isAdditional,
                'reason' => $isAdditional ? 'All sections full (25 students each)' : 'No sections existed'
            ]);

            // Create default classes for this section
            $this->createDefaultClassesForSection($section, $gradeLevelId, $strandId);

            return $section;

        } catch (\Exception $e) {
            Log::error('Failed to create default section', [
                'grade_level_id' => $gradeLevelId,
                'strand_id' => $strandId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return null;
        }
    }

    /**
     * Create default classes for a newly created section
     * 
     * @param \App\Models\StudentSection $section The section to create classes for
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

    /**
     * Notify admin about section requirement
     * 
     * @param int $gradeLevelId The grade level that needs a section
     * @param int|null $strandId The strand (for SHS)
     * @param bool $allFull Whether all sections are full
     */
    private function notifyAdminSectionRequired($gradeLevelId, $strandId = null, $allFull = false)
    {
        try {
            $message = $allFull 
                ? "All sections are full for Grade {$gradeLevelId}" . ($strandId ? " ({$strandId})" : "") . ". New section required."
                : "No sections exist for Grade {$gradeLevelId}" . ($strandId ? " ({$strandId})" : "") . ". Section creation required.";

            Log::warning('SECTION MANAGEMENT NOTIFICATION: ' . $message, [
                'grade_level_id' => $gradeLevelId,
                'strand_id' => $strandId,
                'all_sections_full' => $allFull,
                'timestamp' => now()
            ]);

            // TODO: In the future, you could add email notifications to admin
            // Mail::to('admin@school.com')->send(new SectionRequiredNotification($gradeLevelId, $strandId, $allFull));

        } catch (\Exception $e) {
            Log::error('Failed to send section notification', [
                'grade_level_id' => $gradeLevelId,
                'strand_id' => $strandId,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Generate printable PDF of student credentials
     */
    public function generateCredentialsPDF($enrolleeId)
    {
        try {
            $enrollee = NewStudentEnrollee::findOrFail($enrolleeId);
            
            // Find the student
            $student = null;
            if (!empty($enrollee->lrn)) {
                $student = Student::with('user')->where('lrn', $enrollee->lrn)->first();
            }
            if (!$student && !empty($enrollee->email)) {
                $student = Student::with('user')->where('email', $enrollee->email)->first();
            }
            
            if (!$student || !$student->user) {
                return redirect()->back()
                    ->with('error', 'Student account not found. Please ensure the enrollee has been accepted.');
            }

            // Get credentials
            $username = $student->user->username;
            $birthYear = date('Y', strtotime($student->date_of_birth ?? '2000-01-01'));
            $lastnameForPassword = strtolower($student->last_name ?? 'student');
            $lastnameForPassword = preg_replace('/[^a-z0-9]/', '', $lastnameForPassword);
            $password = $lastnameForPassword . $birthYear;

            // Get section name if available
            $section = $student->section_id ? StudentSection::find($student->section_id) : null;
            $sectionName = $section ? $section->section_name : null;

            // Prepare data for PDF
            $student->studentNumber = sprintf('%02d%05d', (int) now()->format('y'), (int) $enrollee->id);
            $student->section_name = $sectionName;

            // Generate PDF with options (disable GD requirement)
            $pdf = Pdf::loadView('pdf.student_credentials', [
                'student' => $student,
                'username' => $username,
                'password' => $password,
            ]);
            
            // Set PDF options to avoid GD requirement
            $pdf->setOptions([
                'isRemoteEnabled' => false,
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => false,
                'isFontSubsettingEnabled' => false,
                'dpi' => 96,
                'defaultMediaType' => 'print',
                'isJavascriptEnabled' => false,
            ]);

            // Return PDF download with a meaningful filename
            $filename = $username . '_credentials_' . now()->format('Y-m-d') . '.pdf';
            return $pdf->download($filename);

        } catch (\Exception $e) {
            Log::error('Error generating credentials PDF: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'enrollee_id' => $enrolleeId
            ]);
            return redirect()->back()
                ->with('error', 'Failed to generate credentials PDF: ' . $e->getMessage());
        }
    }

    /**
     * Send student credentials via email
     */
    public function sendCredentialsEmail($enrolleeId)
    {
        try {
            $enrollee = NewStudentEnrollee::findOrFail($enrolleeId);
            
            // Find the student
            $student = null;
            if (!empty($enrollee->lrn)) {
                $student = Student::with('user')->where('lrn', $enrollee->lrn)->first();
            }
            if (!$student && !empty($enrollee->email)) {
                $student = Student::with('user')->where('email', $enrollee->email)->first();
            }
            
            if (!$student || !$student->user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Student account not found. Please ensure the enrollee has been accepted.'
                ], 404);
            }

            // Get student email
            $email = $student->email ?? $enrollee->email;
            if (empty($email)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Student email not found. Please ensure the student has a valid email address.'
                ], 400);
            }

            // Get credentials
            $username = $student->user->username;
            $birthYear = date('Y', strtotime($student->date_of_birth ?? '2000-01-01'));
            $lastnameForPassword = strtolower($student->last_name ?? 'student');
            $lastnameForPassword = preg_replace('/[^a-z0-9]/', '', $lastnameForPassword);
            $password = $lastnameForPassword . $birthYear;

            // Send email
            Mail::to($email)->send(new StudentCredentialsMail($student, $username, $password));

            Log::info('Student credentials email sent successfully', [
                'enrollee_id' => $enrolleeId,
                'email' => $email,
                'username' => $username
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Credentials sent successfully to ' . $email
            ]);

        } catch (\Exception $e) {
            Log::error('Error sending credentials email: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to send email. Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
