<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OldStudentEnrollee;

class AdminOldEnrolleeController extends Controller
{
    public function index()
    {
        // fetch newest first
        $oldEnrollees  = OldStudentEnrollee::orderBy('created_at','desc')->get();
        return view('admin_old_enrollees', compact('oldEnrollees'));
    }

    public function modal($id)
    {
        $enrollee = OldStudentEnrollee::findOrFail($id);
        // return just the modal partial
        return view('partials.old_enrollee_info', compact('enrollee'));
    }

    public function destroy(OldStudentEnrollee $enrollee)
    {
        // if you upload docs, delete here...
        $enrollee->delete();
        return redirect()->route('admin.old.enrollees')
                         ->with('success','Old-student enrollee removed.');
    }
}
