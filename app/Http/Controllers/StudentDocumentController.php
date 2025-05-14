<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\NewStudentEnrollee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentDocumentController extends Controller
{
    public function index()
    {
        // 1. Get the logged‑in student record (with the studentID relation)
        $student = Student::with('studentID')
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // 2. Find their enrollee record by application_number
        $applicationNumber = optional($student->studentID)->student_number;
        $enrollee = NewStudentEnrollee::where('application_number', $applicationNumber)
            ->first();

        // 3. Prepare the documents array
        $documents = collect();

        if ($enrollee) {
            $mapping = [
                'report_card_path'       => ['name'=>'Transcript of Records','type'=>'Academic Record'],
                'good_moral_path'        => ['name'=>'Certificate of Good Moral','type'=>'Administrative'],
                'birth_certificate_path' => ['name'=>'Birth Certificate','type'=>'Legal'],
                'id_picture_path'        => ['name'=>'ID Picture','type'=>'Identification'],
                'payment_receipt_path'   => ['name'=>'Payment Receipt','type'=>'Payment Proof'],
            ];

            foreach ($mapping as $field => $meta) {
                if ($path = $enrollee->$field) {
                    $uploadedAt = $enrollee->updated_at->format('F d, Y');
                    $sizeBytes  = Storage::disk('public')->size($path);
                    $sizeMb     = number_format($sizeBytes / 1024 / 1024, 2) . ' MB';

                    $documents->push([
                        'icon'     => Str::endsWith($path, '.pdf') ? 'fa-file-pdf' : 'fa-file-alt',
                        'status'   => 'status-verified',
                        'name'     => $meta['name'],
                        'type'     => $meta['type'],
                        'uploaded' => $uploadedAt,
                        'size'     => $sizeMb,
                        'url'       => Storage::url($path),
                    ]);
                }
            }
        }

        // 4. Return to your student_documents view
        return view('student_documents', compact('documents'));
    }
}
