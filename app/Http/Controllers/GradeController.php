<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    public function index()
    {
        $studentId = Auth::id();
        $grades = Grade::where('student_id', $studentId)->get();
        return view('report_card', compact('grades'));
    }
}
