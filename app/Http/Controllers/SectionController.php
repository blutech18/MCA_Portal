<?php

namespace App\Http\Controllers;

use App\Models\Strand;
use App\Models\Student;
use App\Models\GradeLevel;
use Illuminate\Http\Request;
use App\Models\StudentSection;
use Illuminate\Support\Facades\Log;

class SectionController extends Controller
{
    public function getSections(Request $request)
    {
        $sections = StudentSection::where('grade_level_id', $request->grade_level_id)
                           ->where('strand_id', $request->strand_id)
                           ->get();
                           
        return response()->json($sections);
    }
    public function storeSection(Request $request)
    {
        $validated = $request->validate([
            'grade_level_id' => 'required|exists:grade_levels,grade_level_id',
            'section_name' => 'required|string|max:255',
            'strand_id' => 'nullable|exists:strands,id',
        ]);

        StudentSection::create($validated);

        return redirect()->back()->with('success', 'Section added successfully!');
    }


}
