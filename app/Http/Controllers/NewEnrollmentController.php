<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\NewStudentEnrollee;
use Illuminate\Support\Facades\Log;
use App\Mail\EnrollmentConfirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class NewEnrollmentController extends Controller
{
    public function showStep1()
    {
        return view('new_step1');
    }

    public function postStep1(Request $request)
    {

        $data = $request->validate([
        'strand'                  => 'nullable|string|in:ABM,GAS,STEM,HUMSS,HE,ICT',
        'semester'                => 'nullable|string|in:1st,2nd',
        'surname'                 => 'required|string',
        'givenName'               => 'required|string',
        'middleName'              => 'required|string',
        'lrn'                     => 'required|string',
        'contactNo'               => 'required|string',
        'email'                   => 'nullable|email',
        'address'                 => 'required|string',
        'livingWith'              => 'required|string',
        'dob'                     => 'required|date',
        'birthplace'              => 'required|string',
        'gender'                  => 'required|string',
        'religion'                => 'required|string',
        'nationality'             => 'required|string',
        'formerSchool'            => 'required|string',
        'previousGrade'           => 'required|string',
        'lastSchoolYear'          => 'required|string',
        'schoolType'              => 'required|in:Private,Public,Homeschool',
        'schoolAddress'           => 'required|string',
        'reasonTransfer'          => 'required|string',
        'workingStudent'          => 'nullable|in:Yes,No',
        'intendWorkingStudent'    => 'nullable|in:Yes,No',
        'siblings'                => 'nullable|integer',
        'clubMember'              => 'nullable|in:Yes,No',
        'clubName'                => 'nullable|string',
        'fatherName'              => 'required|string',
        'fatherOccupation'        => 'required|string',
        'fatherContact'           => 'required|string',
        'fatherEmail'             => 'required|email',
        'motherName'              => 'required|string',
        'motherOccupation'        => 'required|string',
        'motherContact'           => 'required|string',
        'motherEmail'             => 'required|email',
        'guardianName'            => 'required|string',
        'guardianOccupation'      => 'required|string',
        'guardianContact'         => 'required|string',
        'guardianEmail'           => 'required|email',
        'medicalHistory'          => 'nullable|array',
        'allergySpecify'          => 'nullable|string',
        'othersSpecify'           => 'nullable|string',
        ]);
        


        $enrollee = NewStudentEnrollee::create([
            'strand'                 => $data['strand'] ?? null,
            'semester'               => $data['semester'] ?? null,
            'surname'                => $data['surname'],
            'given_name'             => $data['givenName'],
            'middle_name'            => $data['middleName'],
            'lrn'                    => $data['lrn'],
            'contact_no'             => $data['contactNo'],
            'email'                  => $data['email'] ?? null,
            'address'                => $data['address'],
            'living_with'            => $data['livingWith'],
            'dob'                    => $data['dob'],
            'birthplace'             => $data['birthplace'],
            'gender'                 => $data['gender'],
            'religion'               => $data['religion'],
            'nationality'            => $data['nationality'],
            'former_school'          => $data['formerSchool'],
            'previous_grade'         => $data['previousGrade'],
            'last_school_year'       => $data['lastSchoolYear'],
            'school_type'            => $data['schoolType'],
            'school_address'         => $data['schoolAddress'],
            'reason_transfer'        => $data['reasonTransfer'],
            'working_student'        => $request->boolean('workingStudent'),
            'intend_working_student' => $request->boolean('intendWorkingStudent'),
            'siblings'               => $data['siblings'] ?? null,
            'club_member'            => $request->boolean('clubMember'),
            'club_name'              => $data['clubName'] ?? null,
            'father_name'            => $data['fatherName'],
            'father_occupation'      => $data['fatherOccupation'],
            'father_contact_no'      => $data['fatherContact'],
            'father_email'           => $data['fatherEmail'],
            'mother_name'            => $data['motherName'],
            'mother_occupation'      => $data['motherOccupation'],
            'mother_contact_no'      => $data['motherContact'],
            'mother_email'           => $data['motherEmail'],
            'guardian_name'          => $data['guardianName'],
            'guardian_occupation'    => $data['guardianOccupation'],
            'guardian_contact_no'    => $data['guardianContact'],
            'guardian_email'         => $data['guardianEmail'],
            'medical_history'        => json_encode($data['medicalHistory'] ?? []),
            'allergy_specify'        => $data['allergySpecify'] ?? null,
            'others_specify'         => $data['othersSpecify'] ?? null,
        ]);

        session(['new_enrollee_id' => $enrollee->id]);
        return redirect()->route('enroll.new.step2');
    }

    public function showStep2()
    {
        $enrollee = NewStudentEnrollee::findOrFail(
            session('new_enrollee_id')
        );
        return view('new_step2', compact('enrollee'));
    }

    /** Handle the upload and update the existing record */
    public function postStep2(Request $request)
    {
        // 1) fetch the existing enrollee
        $enrollee = NewStudentEnrollee::findOrFail(
            session('new_enrollee_id')
        );

        // 2) validate incoming files
        $files = $request->validate([
            'reportCard'       => 'required|file|mimes:pdf,jpg,jpeg,png',
            'goodMoral'        => 'required|file|mimes:pdf,jpg,jpeg,png',
            'birthCertificate' => 'required|file|mimes:pdf,jpg,jpeg,png',
            'idPicture'        => 'required|file|mimes:jpg,jpeg,png',
        ]);

        // 3) store each file and update its path on the model
        $enrollee->report_card_path       =
            $request->file('reportCard')
                    ->store('enroll/docs','public');

        $enrollee->good_moral_path        =
            $request->file('goodMoral')
                    ->store('enroll/docs','public');

        $enrollee->birth_certificate_path =
            $request->file('birthCertificate')
                    ->store('enroll/docs','public');

        $enrollee->id_picture_path        =
            $request->file('idPicture')
                    ->store('enroll/docs','public');

        // 4) save the updated record
        $enrollee->save();

        // 5) redirect to Step 3
        return redirect()->route('enroll.new.step3');
    }
    public function showStep3()
    {
        $enrollee = NewStudentEnrollee::findOrFail(session('new_enrollee_id'));
        return view('new_step3', compact('enrollee'));
    }

    public function postStep3(Request $request)
    {
        $enrollee = NewStudentEnrollee::findOrFail(session('new_enrollee_id'));

        $request->validate([
            'fullName'      => 'required|string',
            'paymentRef'    => 'required|string',
            'receiptUpload' => 'required|file|mimes:jpg,jpeg,png,pdf',
        ]);

        $enrollee->payment_applicant_name = $request->input('fullName');
        $enrollee->payment_reference      = $request->input('paymentRef');
        $enrollee->payment_receipt_path   = $request->file('receiptUpload')
                                                ->store('enroll/payments','public');
        $enrollee->paid                   = true;
        $enrollee->save();

        return redirect()->route('enroll.new.step4');
    }

    public function showStep4()
    {
        $enrollee = NewStudentEnrollee::findOrFail(
            session('new_enrollee_id')
        );

        // Generate & save application_number if not already
        if (! $enrollee->application_number) {
            $year = now()->year;
            // Make sure it's unique
            do {
                $rand = strtoupper(Str::random(4));
                $appNum = "MCA-{$year}-{$rand}";
            } while (NewStudentEnrollee::where('application_number', $appNum)->exists());

            $enrollee->application_number = $appNum;
            $enrollee->save();
        }

        // Send confirmation email
        if ($enrollee->email) {
            Mail::to($enrollee->email)
                ->send(new EnrollmentConfirmation($enrollee));
        }

        // Pass enrollee to the view
        return view('new_step4', compact('enrollee'));
    }
}
