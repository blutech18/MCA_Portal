<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function store(Request $request)
    {
        // Validate form inputs
        $request->validate([
            'semester' => 'required',
            'grade' => 'required',
            'status' => 'required',
            'strand' => 'required',
            'first_name' => 'required|string|max:50',
            'middle_name' => 'nullable|string|max:50',
            'last_name' => 'required|string|max:50',
            'gender' => 'required',
            'dob_month' => 'required|numeric',
            'dob_day' => 'required|numeric',
            'dob_year' => 'required|numeric',
            'contact' => 'required|string|max:20',
            'email' => 'required|email|unique:enrollments,email',
        ]);

        // Convert Date of Birth to proper format
        $dob = "{$request->dob_year}-{$request->dob_month}-{$request->dob_day}";

        // Insert data into the database
        Enrollment::create([
            'semester' => $request->semester,
            'grade_level' => $request->grade,
            'status' => $request->status,
            'strand' => $request->strand,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'dob' => $dob,
            'contact' => $request->contact,
            'email' => $request->email,
        ]);

        return redirect()->route('enrollment.success')->with('success', 'Enrollment successful!');
    }
}
