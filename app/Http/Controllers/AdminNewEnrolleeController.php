<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewStudentEnrollee;
use Illuminate\Support\Facades\Storage;

class AdminNewEnrolleeController extends Controller
{
    public function index(Request $request)
    {
        $enrollees = NewStudentEnrollee::orderBy('created_at','desc')->get();
        return view('admin_new_enrollees', compact('enrollees'));
    }

    // Show details for one enrollee
    public function show(NewStudentEnrollee $enrollee)
    {
        return view('admin_enrollee_show', compact('enrollee'));
    }

    // Delete an enrollee
    public function destroy(NewStudentEnrollee $enrollee)
    {
        // Remove uploaded form138 file
        if ($enrollee->form138_path) {
            Storage::disk('public')->delete($enrollee->form138_path);
        }

        $enrollee->delete();
        return redirect()->route('admin.enrollees')
                         ->with('success','Enrollee removed successfully.');
    }
}
