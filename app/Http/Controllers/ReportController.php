<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Student;
use App\Models\NewStudentEnrollee;
use App\Models\OldStudentEnrollee;
use App\Models\Document;
use App\Models\User;

class ReportController extends Controller
{
    public function enrollmentReport(Request $request, string $type, string $id)
    {
        // type: new|old|student; id refers to enrollee id or student_id
        $data = [
            'studentId'      => null,
            'lrn'            => null,
            'fullName'       => null,
            'gradeLevel'     => null,
            'section'        => null,
            'enrolledAt'     => null,
            'schoolYear'     => null,
            'contactNumber'  => null,
            'paymentStatus'  => null,
            'enrolleeType'   => $type,
        ];

        if ($type === 'student') {
            $student = Student::with(['gradeLevel','section'])->where('student_id', $id)->firstOrFail();
            $data['studentId']     = $student->studentId->student_number ?? $student->school_student_id ?? $student->student_id;
            $data['lrn']           = $student->lrn;
            $data['fullName']      = trim("{$student->first_name} {$student->last_name}");
            $data['gradeLevel']    = $student->gradeLevel->name ?? null;
            $data['section']       = $student->section->section_name ?? null;
            $data['enrolledAt']    = $student->date_enrolled;
            $data['schoolYear']    = \App\Models\AcademicYear::getCurrentAcademicYear()?->year_name;
            $data['contactNumber'] = $student->contact_number;
            $data['paymentStatus'] = 'Verified';
        } elseif ($type === 'new') {
            $enrollee = NewStudentEnrollee::findOrFail($id);
            
            // Generate student ID
            $studentNumber = sprintf('%02d%05d', (int) now()->format('y'), (int) $enrollee->id);
            
            $data['studentId']     = $enrollee->application_number ?? $studentNumber;
            $data['lrn']           = $enrollee->lrn;
            $data['fullName']      = trim("{$enrollee->given_name} {$enrollee->surname}");
            $data['surname']       = $enrollee->surname; // For filename generation
            
            // Determine grade level
            $gradeLevel = '';
            if ($enrollee->jhs_grade) {
                $gradeLevel = "Grade {$enrollee->jhs_grade} (JHS)";
            } elseif ($enrollee->shs_grade) {
                $strand = $enrollee->strand;
                $gradeLevel = "Grade {$enrollee->shs_grade} - {$strand} (SHS)";
            } else {
                $gradeLevel = $enrollee->grade_level ?? 'N/A';
            }
            
            $data['gradeLevel']    = $gradeLevel;
            $data['section']       = null;
            $data['enrolledAt']    = $enrollee->created_at;
            $data['schoolYear']    = \App\Models\AcademicYear::getCurrentAcademicYear()?->year_name;
            $data['contactNumber'] = $enrollee->contact_no;
            $data['paymentStatus'] = $enrollee->payment_status ?? ($enrollee->paid ? 'Verified' : 'Pending');
        } else { // old
            $enrollee = OldStudentEnrollee::findOrFail($id);
            $data['studentId']     = $enrollee->application_number;
            $data['lrn']           = $enrollee->lrn;
            $data['fullName']      = trim("{$enrollee->given_name} {$enrollee->surname}");
            $data['gradeLevel']    = $enrollee->grade_level;
            $data['section']       = null;
            $data['enrolledAt']    = $enrollee->created_at;
            $data['schoolYear']    = \App\Models\AcademicYear::getCurrentAcademicYear()?->year_name;
            $data['contactNumber'] = $enrollee->contact_no;
            $data['paymentStatus'] = $enrollee->payment_status ?? ($enrollee->paid ? 'Verified' : 'Pending');
        }

        // Check if PDF format is requested
        if ($request->has('format') && $request->get('format') === 'pdf') {
            return $this->generatePDF($data, $type, $id);
        }

        // Render Blade to HTML for PDF-like print
        return view('reports.enrollment_summary', $data);
    }

    /**
     * Generate PDF enrollment form and store it in documents
     */
    private function generatePDF($data, $type, $id)
    {
        try {
            Log::info('Attempting to generate PDF', [
                'type' => $type,
                'id' => $id,
                'data' => $data
            ]);
            
            // Generate PDF using DomPDF with simplified template
            $pdf = Pdf::loadView('reports.enrollment_pdf', $data);
            $pdf->setPaper('A4', 'portrait');
            
            // Configure DomPDF options to avoid GD requirement
            $pdf->setOptions([
                'enable_remote' => false,
                'dpi' => 96,
            ]);
            
            // Generate filename using student's surname
            $surname = $data['surname'] ?? '';
            if (empty($surname)) {
                // Fallback to extracting from full name if surname not available
                $fullName = $data['fullName'] ?? 'enrollment';
                $nameParts = explode(',', $fullName);
                $surname = trim($nameParts[0]);
                if (empty($surname)) {
                    $nameParts = explode(' ', $fullName);
                    $surname = $nameParts[count($nameParts) - 1]; // Get last name
                }
            }
            $surnameClean = preg_replace('/[^a-zA-Z0-9]/', '', $surname); // Remove special chars
            $filename = 'Enrollment_' . ucfirst($surnameClean) . '_' . now()->format('Ymd') . '.pdf';
            
            // Generate PDF output
            $pdfOutput = $pdf->output();
            
            Log::info('PDF generated successfully', [
                'filename' => $filename
            ]);
            
            // Try to store PDF in storage (optional, for logging purposes)
            // Don't let storage errors block the download
            try {
                $pdfPath = 'enrollment_forms/' . $filename;
                Storage::disk('public')->put($pdfPath, $pdfOutput);
                
                // Store document record if user exists
                $this->storeEnrollmentDocument($type, $id, $pdfPath, $data);
            } catch (\Exception $e) {
                Log::warning('Could not store PDF in storage', ['error' => $e->getMessage()]);
                // Continue anyway - PDF can still be downloaded
            }
            
            // Return PDF for download
            return response($pdfOutput, 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
                
        } catch (\Exception $e) {
            Log::error('Failed to generate enrollment PDF', [
                'type' => $type,
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Try to generate a simpler PDF or show error
            try {
                // Try to load the simplified PDF view
                $simplePdf = Pdf::loadView('reports.enrollment_pdf', $data);
                $simplePdf->setPaper('A4', 'portrait');
                $filename = 'Enrollment_' . $id . '_' . now()->format('Ymd') . '.pdf';
                
                return response($simplePdf->output(), 200)
                    ->header('Content-Type', 'application/pdf')
                    ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
                    ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                    ->header('Pragma', 'no-cache')
                    ->header('Expires', '0');
            } catch (\Exception $e2) {
                // Return JSON error instead of trying to generate another PDF
                Log::error('All PDF generation attempts failed', [
                    'original_error' => $e->getMessage(),
                    'fallback_error' => $e2->getMessage()
                ]);
                
                return response()->json([
                    'error' => 'Unable to generate PDF. Please contact the administrator.',
                    'details' => 'PDF generation failed. Please try again later or contact support.'
                ], 500);
            }
        }
    }

    /**
     * Store enrollment document in the documents table
     */
    private function storeEnrollmentDocument($type, $id, $pdfPath, $data)
    {
        try {
            $userId = null;
            
            // Find the associated user
            if ($type === 'student') {
                $student = Student::findOrFail($id);
                $userId = $student->user_id;
            } elseif ($type === 'new') {
                $enrollee = NewStudentEnrollee::findOrFail($id);
                // Try to find user by email
                if ($enrollee->email) {
                    $user = User::where('email', $enrollee->email)->first();
                    $userId = $user?->id;
                }
            } else { // old
                $enrollee = OldStudentEnrollee::findOrFail($id);
                // Try to find user by email
                if ($enrollee->email) {
                    $user = User::where('email', $enrollee->email)->first();
                    $userId = $user?->id;
                }
            }
            
            if ($userId) {
                // Store document record
                Document::create([
                    'user_id' => $userId,
                    'document_type' => 'Enrollment Form',
                    'submitted' => 'yes',
                    'submitted_online' => 'yes',
                    'submitted_face_to_face' => 'no',
                    'document_file' => $pdfPath,
                ]);
                
                Log::info('Enrollment document stored successfully', [
                    'user_id' => $userId,
                    'document_type' => 'Enrollment Form',
                    'file_path' => $pdfPath
                ]);
            } else {
                Log::warning('Could not find user for enrollment document storage', [
                    'type' => $type,
                    'id' => $id
                ]);
            }
            
        } catch (\Exception $e) {
            Log::error('Failed to store enrollment document', [
                'type' => $type,
                'id' => $id,
                'error' => $e->getMessage()
            ]);
        }
    }
}


