<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function index()
    {
        // Fetch subjects for the logged-in user
        $userId = Auth::id();
        $subjects = Subject::where('user_id', $userId)->get();

        // Pass data to view. If there are no subjects, the collection will be empty.
        return view('subjects', compact('subjects'));
    }
}
