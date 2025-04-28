<?php

namespace App\Http\Controllers;

use App\Models\Strand;
use App\Models\Subject;
use App\Models\GradeLevel;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    
    public function index()
    {
        $courses = SchoolClass::with(['subject', 'gradeLevel', 'strand','section'])->get();
        $subjects = Subject::all();
        $gradeLevels = GradeLevel::all();
        $strands = Strand::all();

        return view('admin_courses', compact('courses', 'subjects', 'gradeLevels', 'strands'));
    }

    public function create()
    {
        $subjects = Subject::all();
        $gradeLevels = GradeLevel::all();
        $strands = Strand::all();

        return view('admin_courses', compact('subjects', 'gradeLevels', 'strands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'subject_id' => 'required|exists:subjects,id',
            'grade_level_id' => 'required|exists:grade_level,grade_level_id',
            'strand_id' => ['nullable', 'required_if:grade_level_id,>=11', 'exists:strands,id'],
            'semester' => ['nullable', 'required_if:grade_level_id,>=11', 'in:1st,2nd'],
            'section_id'      => 'nullable|exists:section,id',
            'room' => 'nullable|string|max:50',
        ]);
        
    
        // The model is SchoolClass
        try {
            SchoolClass::create([
                'name' => $validated['name'],
                'code' => $validated['code'],
                'subject_id' => $validated['subject_id'],
                'grade_level_id' => $validated['grade_level_id'],
                'strand_id' => $validated['strand_id'] ?? null,
                'section_id' => $validated['section_id'] ?? null,
                'semester' => $validated['semester'],
                'room' => $validated['room'],
            ]);
        } catch (\Exception $e) {
            dd('Error saving:', $e->getMessage());
        }
        
    
        return redirect()->back()->with('success', 'Course added successfully.');
    }

    public function edit($id)
    {
        $course = SchoolClass::findOrFail($id);
        $subjects = Subject::all();
        $gradeLevels = GradeLevel::all();
        $strands = Strand::all();

        return view('admin_courses_edit', compact('course', 'subjects', 'gradeLevels', 'strands'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'subject_id' => 'required|exists:subjects,id',
            'grade_level_id' => 'required|exists:grade_level,grade_level_id',
            'strand_id' => 'nullable|exists:strands,id',
            'section_name' => 'nullable|string|max:100',
            'semester' => 'nullable|in:1st,2nd',
            'room' => 'nullable|string|max:50',
        ]);

        $course = SchoolClass::findOrFail($id);
        $course->update($validated);

        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy($id)
    {
        $course = SchoolClass::findOrFail($id);
        $course->delete();

        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully.');
    }



}
