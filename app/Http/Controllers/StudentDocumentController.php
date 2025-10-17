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
        }
        // Fallbacks if not found: try by student email OR auth user email
        if (!$newEnrollee && ($student?->email || $authUser?->email)) {
            $emailToUse = $student?->email ?: $authUser?->email;
            $newEnrollee = NewStudentEnrollee::where('email', $emailToUse)
                ->orderBy('updated_at', 'desc')
                ->first();
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
                    ->orderBy('updated_at', 'desc');
                if ($dob) {
                    $q->whereDate('dob', $dob);
                }
                $newEnrollee = $q->first();
            }
        }
        
        // If not found, try old student enrollees
        $oldEnrollee = OldStudentEnrollee::where('application_number', $applicationNumber)->first();
        
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
                        $exists   = Storage::disk('public')->exists($path);
                        $uploaded = optional($newEnrollee->updated_at)->format('F d, Y') ?: '';
                        $sizeMb   = '—';
                        if ($exists) {
                            $sizeBytes = Storage::disk('public')->size($path);
                            $sizeMb    = number_format($sizeBytes / 1024 / 1024, 2) . ' MB';
                        }

                        $documents->push([
                            'icon'     => $this->getFileIcon($path),
                            'status'   => 'status-verified',
                            'name'     => $meta['name'],
                            'type'     => $meta['type'],
                            'category' => $meta['category'],
                            'uploaded' => $uploaded,
                            'size'     => $sizeMb,
                            'url'      => $exists ? Storage::url($path) : asset('storage/' . ltrim($path, '/')),
                            'exists'   => $exists,
                            'path'     => $path,
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
                        if (Storage::disk('public')->exists($path)) {
                            $uploadedAt = $oldEnrollee->updated_at->format('F d, Y');
                            $sizeBytes  = Storage::disk('public')->size($path);
                            $sizeMb     = number_format($sizeBytes / 1024 / 1024, 2) . ' MB';

                        $documents->push([
                                'icon'     => $this->getFileIcon($path),
                                'status'   => 'status-verified',
                                'name'     => $meta['name'],
                                'type'     => $meta['type'],
                                'category' => $meta['category'],
                                'uploaded' => $uploadedAt,
                                'size'     => $sizeMb,
                            'url'      => Storage::url($path),
                            'exists'   => true,
                                'path'     => $path,
                            ]);
                        }
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
