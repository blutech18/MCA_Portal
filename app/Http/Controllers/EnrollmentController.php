<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;
use App\Models\NewStudentEnrollee;

class EnrollmentController extends Controller
{
    
    public function store(Request $request)
    {
        $request->validate([
            'semester' => 'required',
            'last_name' => 'required|string|max:50',
            'first_name' => 'required|string|max:50',
            'middle_name' => 'nullable|string|max:50',
            'extension_name' => 'nullable|string|max:10',
            'dob_month' => 'required|numeric',
            'dob_day' => 'required|numeric',
            'dob_year' => 'required|numeric',
            'gender' => 'required',
            'pob' => 'required|string',
            'address' => 'required|string',
            'mobile' => 'required|string|max:20',
            'email' => 'required|email|unique:new_student_enrollees,email',
            'mother_name' => 'required|string',
            'father_name' => 'required|string',
            'guardian_name' => 'nullable|string',
            'relationship' => 'nullable|string',
            'guardian_contact' => 'nullable|string',
            'guardian_email' => 'nullable|email',
            'last_school' => 'required|string',
            'school_address' => 'required|string',
            'grade_completed' => 'required',
            'sy_completed' => 'required|string',
            'form138' => 'required|file|mimes:pdf,jpg,png|max:2048',
            'desired_grade' => 'required',
            'preferred_strand' => 'nullable|string',
        ]);

        $dob = "{$request->dob_year}-{$request->dob_month}-{$request->dob_day}";

        // Store file
        $filePath = $request->file('form138')->store('form138_uploads', 'public');

        NewStudentEnrollee::create([
            'semester' => $request->semester,
            'lrn' => $request->lrn,
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'extension_name' => $request->extension_name,
            'dob' => $dob,
            'gender' => $request->gender,
            'pob' => $request->pob,
            'address' => $request->address,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'mother_name' => $request->mother_name,
            'father_name' => $request->father_name,
            'guardian_name' => $request->guardian_name,
            'relationship' => $request->relationship,
            'guardian_contact' => $request->guardian_contact,
            'guardian_email' => $request->guardian_email,
            'last_school' => $request->last_school,
            'school_address' => $request->school_address,
            'grade_completed' => $request->grade_completed,
            'sy_completed' => $request->sy_completed,
            'form138_path' => $filePath,
            'desired_grade' => $request->desired_grade,
            'preferred_strand' => $request->preferred_strand,
        ]);

        return redirect()->route('enrollment.success')->with('success', 'Enrollment submitted successfully.');
    }
}
