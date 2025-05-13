<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewStudentEnrollee;
use App\Models\OldStudentEnrollee;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AdminNewEnrolleeController extends Controller
{
    public function index(Request $request)
    {
        $newEnrollees = NewStudentEnrollee::orderBy('created_at','desc')->get();
        $oldEnrollees = OldStudentEnrollee::orderBy('created_at','desc')->get();
        
        return view('admin_new_enrollees', compact('newEnrollees', 'oldEnrollees'));
    }

   public function newModal($id)
    {
        $enrollee = NewStudentEnrollee::findOrFail($id);
        return view('partials.enrollee_info', compact('enrollee'));
    }

    public function oldModal($id)
    {
        $enrollee = OldStudentEnrollee::findOrFail($id);
        Log::debug('ENROLLEE IN OLD MODAL: ', $enrollee->toArray());
        return view('partials.old_enrollee_info', compact('enrollee'));
    }

    public function destroy(NewStudentEnrollee $enrollee)
    {
        if ($enrollee->form138_path) {
            Storage::disk('public')->delete($enrollee->form138_path);
        }

        $enrollee->delete();
        return redirect()->route('admin.enrollees')
                         ->with('success','Enrollee removed successfully.');
    }

    public function destroyOld(OldStudentEnrollee $enrollee)
    {
        if ($enrollee->form138_path) {
            Storage::disk('public')->delete($enrollee->form138_path);
        }

        $enrollee->delete();
        return redirect()->route('admin.enrollees')
                        ->with('success','Old enrollee removed successfully.');
    }
}
