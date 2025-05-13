<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\OldStudentEnrollee;
use App\Mail\EnrollmentConfirmation;
use Illuminate\Support\Facades\Mail;

class OldEnrollmentController extends Controller
{
    public function showStep1()
    {
        return view('old_step1');
    }

    /** Step 1: handle pre-registration POST */
    public function postStep1(Request $request)
    {
        $data = $request->validate([
            'semester'              => 'required|in:1st,2nd',
            'surname'               => 'required|string',
            'givenName'             => 'required|string',
            'middleName'            => 'required|string',
            'lrn'                   => 'required|string',
            'studentId'             => 'required|string',
            'gradeLevelApplying'    => 'required|integer|min:7|max:12',
            'terms'                 => 'required|array',
            'terms.*'               => 'in:completeness,abide,consequences,responsible,updated,aware',
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

        session(['old_enrollee_id' => $enrollee->id]);

        return redirect()->route('enroll.old.step2');
    }

    /** Step 2: show payment form */
    public function showStep2()
    {
        $enrollee = OldStudentEnrollee::findOrFail(
            session('old_enrollee_id')
        );
        return view('old_step2', compact('enrollee'));
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
}
