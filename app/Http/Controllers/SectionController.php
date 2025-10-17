<?php

namespace App\Http\Controllers;

use App\Models\Strands;
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

        $section = StudentSection::create($validated);

        // Create default classes for this section
        $this->createDefaultClassesForSection($section, $validated['grade_level_id'], $validated['strand_id']);

        return redirect()->back()->with('success', 'Section added successfully!');
    }

    /**
     * Create default classes for a newly created section
     * 
     * @param \App\Models\StudentSection $section The section to create classes for
     * @param int $gradeLevelId The grade level ID
     * @param int|null $strandId The strand ID (for SHS)
     */
    private function createDefaultClassesForSection($section, $gradeLevelId, $strandId = null)
    {
        try {
            // Get default subjects for this grade level
            $defaultSubjects = \App\Models\Subject::where('is_default', true)->get();
            
            if ($defaultSubjects->isEmpty()) {
                Log::warning('No default subjects found for section', [
                    'section_id' => $section->id,
                    'grade_level_id' => $gradeLevelId
                ]);
                return;
            }

            $createdClasses = [];

            foreach ($defaultSubjects as $subject) {
                // Create class name: "Subject Name - Section Name"
                $className = $subject->name . ' - ' . $section->section_name;
                
                $class = \App\Models\SchoolClass::create([
                    'name' => $className,
                    'code' => strtoupper(substr($subject->name, 0, 3)) . '-' . $section->id,
                    'subject_id' => $subject->id,
                    'grade_level_id' => $gradeLevelId,
                    'strand_id' => $strandId,
                    'section_id' => $section->id,
                    'semester' => '1st',
                    'room' => 'TBA'
                ]);

                $createdClasses[] = [
                    'class_id' => $class->id,
                    'class_name' => $className,
                    'subject_name' => $subject->name
                ];
            }

            Log::info('✅ AUTO-CREATED CLASSES FOR SECTION', [
                'section_id' => $section->id,
                'section_name' => $section->section_name,
                'grade_level_id' => $gradeLevelId,
                'strand_id' => $strandId,
                'classes_created' => count($createdClasses),
                'classes' => $createdClasses
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to create default classes for section', [
                'section_id' => $section->id,
                'grade_level_id' => $gradeLevelId,
                'strand_id' => $strandId,
                'error' => $e->getMessage()
            ]);
        }
    }


}
