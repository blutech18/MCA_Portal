<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\NewStudentEnrollee;
use App\Models\OldStudentEnrollee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class StudentDocumentController extends Controller
{
    public function index()
    {
        // 1. Get the logged‑in student record (with the studentID relation)
        $student = Student::with('studentID')
            ->where('user_id', Auth::id())
            ->first();

        Log::info('Student Documents - Debug Info', [
            'user_id' => Auth::id(),
            'student_found' => $student ? 'yes' : 'no',
            'student_id' => $student?->student_id ?? 'N/A',
        ]);

        $authUser = Auth::user();
        if (!$student) {
            Log::warning('Student Documents - No student record found, will try user-based fallbacks', [
                'user_id' => $authUser?->user_id,
                'username' => $authUser?->username,
                'email' => $authUser?->email,
            ]);
        }

        // 2. Find their enrollee record by application_number
        // The application_number is stored in school_student_id field
        $applicationNumber = $student?->school_student_id;
        $studentNumber = optional($student?->studentID)->student_number;
        
        Log::info('Student Documents - Looking for enrollee', [
            'application_number' => $applicationNumber,
            'student_number' => $studentNumber,
            'school_student_id' => $student?->school_student_id,
        ]);
        
        // Try to find in new student enrollees first using application_number
        $newEnrollee = null;
        if (!empty($applicationNumber)) {
            $newEnrollee = NewStudentEnrollee::where('application_number', $applicationNumber)->first();
            Log::info('Searching by application_number', [
                'application_number' => $applicationNumber,
                'found' => $newEnrollee ? 'yes' : 'no'
            ]);
        }
        
        // Also try by student_number if different from application_number
        if (!$newEnrollee && $studentNumber && $studentNumber !== $applicationNumber) {
            $newEnrollee = NewStudentEnrollee::where('application_number', $studentNumber)->first();
            Log::info('Searching by student_number', [
                'student_number' => $studentNumber,
                'found' => $newEnrollee ? 'yes' : 'no'
            ]);
        }
        
        // CRITICAL FIX: Try to find enrollee by matching the generated student number pattern
        // New enrollees get student numbers in format: yy + 5-digit enrollee ID (e.g., 2500123)
        if (!$newEnrollee && $applicationNumber && strlen($applicationNumber) === 7 && is_numeric($applicationNumber)) {
            // Extract the enrollee ID from the student number (last 5 digits)
            $enrolleeId = (int) substr($applicationNumber, 2);
            $newEnrollee = NewStudentEnrollee::find($enrolleeId);
            Log::info('Searching by extracted enrollee ID from student number', [
                'student_number' => $applicationNumber,
                'extracted_enrollee_id' => $enrolleeId,
                'found' => $newEnrollee ? 'yes' : 'no'
            ]);
        }
        
        // Try by LRN if available
        if (!$newEnrollee && $student?->lrn) {
            $newEnrollee = NewStudentEnrollee::where('lrn', $student->lrn)
                ->orderBy('updated_at', 'desc')
                ->first();
            Log::info('Searching by LRN', [
                'lrn' => $student->lrn,
                'found' => $newEnrollee ? 'yes' : 'no'
            ]);
        }
        
        // Fallbacks if not found: try by student email OR auth user email
        if (!$newEnrollee && ($student?->email || $authUser?->email)) {
            $emailToUse = $student?->email ?: $authUser?->email;
            $newEnrollee = NewStudentEnrollee::where('email', $emailToUse)
                ->orderBy('updated_at', 'desc')
                ->first();
            Log::info('Searching by email', [
                'email' => $emailToUse,
                'found' => $newEnrollee ? 'yes' : 'no'
            ]);
        }
        
        // Fallback by name (student name or auth user name split) + optional DOB
        if (!$newEnrollee) {
            $surname = $student?->last_name;
            $given   = $student?->first_name;
            $dob     = $student?->date_of_birth;
            if ((!$surname || !$given) && $authUser?->name) {
                $parts = preg_split('/\s+/', trim($authUser->name));
                $given = $given ?: ($parts[0] ?? null);
                $surname = $surname ?: (count($parts) > 1 ? end($parts) : null);
            }
            if ($surname && $given) {
                $q = NewStudentEnrollee::where('surname', $surname)
                    ->where('given_name', $given)
                    ->where('status', 'accepted') // Only get accepted enrollees
                    ->orderBy('updated_at', 'desc');
                if ($dob) {
                    $q->whereDate('dob', $dob);
                }
                $newEnrollee = $q->first();
                Log::info('Searching by name', [
                    'surname' => $surname,
                    'given_name' => $given,
                    'found' => $newEnrollee ? 'yes' : 'no'
                ]);
            }
        }
        
        // Last resort: Try to find ANY accepted enrollee with matching email
        if (!$newEnrollee && $student?->email) {
            $newEnrollee = NewStudentEnrollee::where('email', $student->email)
                ->where('status', 'accepted')
                ->whereNotNull('form138_path') // Has at least one document
                ->orderBy('updated_at', 'desc')
                ->first();
            Log::info('Last resort search by email with documents', [
                'email' => $student->email,
                'found' => $newEnrollee ? 'yes' : 'no'
            ]);
        }
        
        // If not found, try old student enrollees
        $oldEnrollee = null;
        if (!empty($applicationNumber)) {
            $oldEnrollee = OldStudentEnrollee::where('application_number', $applicationNumber)->first();
        }
        
        // Try by LRN for old enrollees too
        if (!$oldEnrollee && $student?->lrn) {
            $oldEnrollee = OldStudentEnrollee::where('lrn', $student->lrn)
                ->orderBy('updated_at', 'desc')
                ->first();
        }
        
        Log::info('Student Documents - Enrollee Records', [
            'new_enrollee_found' => $newEnrollee ? 'yes' : 'no',
            'old_enrollee_found' => $oldEnrollee ? 'yes' : 'no',
        ]);

        // 3. Prepare the documents array
        $documents = collect();

        // Process New Student Enrollee Documents
        if ($newEnrollee) {
            $mapping = [
                'form138_path'           => ['name'=>'Form 138 (Report Card)','type'=>'Academic Record', 'category'=>'academic'],
                'report_card_path'       => ['name'=>'Transcript of Records','type'=>'Academic Record', 'category'=>'academic'],
                'good_moral_path'        => ['name'=>'Certificate of Good Moral','type'=>'Administrative', 'category'=>'administrative'],
                'birth_certificate_path' => ['name'=>'Birth Certificate (PSA)','type'=>'Legal Document', 'category'=>'legal'],
                'id_picture_path'        => ['name'=>'ID Picture','type'=>'Identification', 'category'=>'identification'],
                'payment_receipt_path'   => ['name'=>'Payment Receipt','type'=>'Payment Proof', 'category'=>'payment'],
            ];

            foreach ($mapping as $field => $meta) {
                if ($path = $newEnrollee->$field) {
                    try {
                        // Clean the path - remove any leading slashes or 'storage/' prefix
                        $cleanPath = ltrim($path, '/');
                        $cleanPath = preg_replace('/^storage\//', '', $cleanPath);
                        
                        $exists   = Storage::disk('public')->exists($cleanPath);
                        $uploaded = optional($newEnrollee->updated_at)->format('F d, Y') ?: '';
                        $sizeMb   = '—';
                        
                        if ($exists) {
                            $sizeBytes = Storage::disk('public')->size($cleanPath);
                            $sizeMb    = number_format($sizeBytes / 1024 / 1024, 2) . ' MB';
                        }

                        // Generate proper URL using asset() for better compatibility
                        // Ensure the path starts with the correct storage directory
                        $docUrl = asset('storage/' . $cleanPath);
                        
                        $documents->push([
                            'icon'     => $this->getFileIcon($path),
                            'status'   => 'status-verified',
                            'name'     => $meta['name'],
                            'type'     => $meta['type'],
                            'category' => $meta['category'],
                            'uploaded' => $uploaded,
                            'size'     => $sizeMb,
                            'url'      => $docUrl,
                            'exists'   => $exists,
                            'path'     => $cleanPath,
                        ]);
                        
                        Log::info("Document processed", [
                            'field' => $field,
                            'original_path' => $path,
                            'clean_path' => $cleanPath,
                            'exists' => $exists,
                            'url' => $docUrl
                        ]);
                    } catch (\Exception $e) {
                        Log::warning("Failed to process document: {$field}", [
                            'path' => $path,
                            'error' => $e->getMessage()
                        ]);
                    }
                }
            }
        }

        // Process Old Student Enrollee Documents
        if ($oldEnrollee) {
            $oldMapping = [
                'clearance_path'         => ['name'=>'Clearance Document','type'=>'Administrative', 'category'=>'administrative'],
                'payment_receipt_path'   => ['name'=>'Payment Receipt','type'=>'Payment Proof', 'category'=>'payment'],
            ];

            foreach ($oldMapping as $field => $meta) {
                if ($path = $oldEnrollee->$field) {
                    try {
                        // Clean the path - remove any leading slashes or 'storage/' prefix
                        $cleanPath = ltrim($path, '/');
                        $cleanPath = preg_replace('/^storage\//', '', $cleanPath);
                        
                        $exists = Storage::disk('public')->exists($cleanPath);
                        $uploaded = optional($oldEnrollee->updated_at)->format('F d, Y') ?: '';
                        $sizeMb = '—';
                        
                        if ($exists) {
                            $sizeBytes = Storage::disk('public')->size($cleanPath);
                            $sizeMb = number_format($sizeBytes / 1024 / 1024, 2) . ' MB';
                        }
                        
                        // Generate proper URL using asset() for better compatibility
                        $docUrl = asset('storage/' . $cleanPath);

                        $documents->push([
                            'icon'     => $this->getFileIcon($path),
                            'status'   => 'status-verified',
                            'name'     => $meta['name'],
                            'type'     => $meta['type'],
                            'category' => $meta['category'],
                            'uploaded' => $uploaded,
                            'size'     => $sizeMb,
                            'url'      => $docUrl,
                            'exists'   => $exists,
                            'path'     => $cleanPath,
                        ]);
                        
                        Log::info("Old enrollee document processed", [
                            'field' => $field,
                            'original_path' => $path,
                            'clean_path' => $cleanPath,
                            'exists' => $exists,
                            'url' => $docUrl
                        ]);
                    } catch (\Exception $e) {
                        Log::warning("Failed to process old student document: {$field}", [
                            'path' => $path,
                            'error' => $e->getMessage()
                        ]);
                    }
                }
            }
        }

        // Sort documents by category and name
        $documents = $documents->sortBy([
            ['category', 'asc'],
            ['name', 'asc'],
        ]);

        Log::info('Student Documents - Final Result', [
            'documents_count' => $documents->count(),
            'document_names' => $documents->pluck('name')->toArray(),
        ]);

        // 4. Return to your student_documents view
        return view('student_documents', compact('student', 'documents'));
    }

    /**
     * Get appropriate icon based on file extension
     */
    private function getFileIcon($path)
    {
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        
        return match($extension) {
            'pdf' => 'fa-file-pdf',
            'jpg', 'jpeg', 'png', 'gif' => 'fa-file-image',
            'doc', 'docx' => 'fa-file-word',
            'xls', 'xlsx' => 'fa-file-excel',
            default => 'fa-file-alt',
        };
    }
}
