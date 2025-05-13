<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::all();
        return view('admin_subjects', compact('subjects'));
    }

    // Store a new subject
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
        ]);

        Subject::create([
            'name' => $validated['name'],
            'code' => $validated['code'],
        ]);

        return redirect()->route('admin.subjects')->with('success', 'Subject added successfully!');
    }

    // in SubjectController.php

public function destroy($id)
{
    Log::debug('SubjectController@destroy called with id', ['id' => $id]);

    // force a real lookup
    $subject = Subject::findOrFail($id);
    Log::debug('Subject found', ['subject' => $subject->toArray()]);

    $deleted = $subject->delete();
    Log::debug('Subject delete() returned', ['deleted' => $deleted]);

    return redirect()
        ->route('admin.subjects')
        ->with('success', 'Subject deleted successfully!');
}


}
