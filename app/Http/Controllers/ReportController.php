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
            $data['studentId']     = $enrollee->application_number;
            $data['lrn']           = $enrollee->lrn;
            $data['fullName']      = trim("{$enrollee->given_name} {$enrollee->surname}");
            $data['gradeLevel']    = $enrollee->grade_level;
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
            // Check if GD extension is available
            if (!extension_loaded('gd')) {
                Log::warning('GD extension not available for PDF generation', [
                    'type' => $type,
                    'id' => $id
                ]);
                
                // Return HTML view instead of PDF
                return response()->view('reports.enrollment_summary', $data, 200, [
                    'Content-Type' => 'text/html',
                    'Cache-Control' => 'no-cache, no-store, must-revalidate',
                    'Pragma' => 'no-cache',
                    'Expires' => '0'
                ]);
            }
            
            // Generate PDF using DomPDF
            $pdf = Pdf::loadView('reports.enrollment_summary', $data);
            $pdf->setPaper('A4', 'portrait');
            
            // Generate filename
            $filename = 'enrollment_form_' . $type . '_' . $id . '_' . now()->format('Y_m_d_H_i_s') . '.pdf';
            
            // Store PDF in storage
            $pdfPath = 'enrollment_forms/' . $filename;
            Storage::disk('public')->put($pdfPath, $pdf->output());
            
            // Store document record if user exists
            $this->storeEnrollmentDocument($type, $id, $pdfPath, $data);
            
            // Return PDF for download
            return response($pdf->output(), 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
                
        } catch (\Exception $e) {
            Log::error('Failed to generate enrollment PDF', [
                'type' => $type,
                'id' => $id,
                'error' => $e->getMessage()
            ]);
            
            // Return HTML view as fallback
            return response()->view('reports.enrollment_summary', $data, 200, [
                'Content-Type' => 'text/html',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0'
            ]);
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


