<?php

namespace App\Http\Controllers;

use App\Models\StudentSection;
use App\Models\GradeLevel;
use App\Models\Strands;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SectionManagementController extends Controller
{
    /**
     * Display section management dashboard
     */
    public function index(Request $request)
    {
        $gradeLevels = GradeLevel::orderBy('name')->get();
        $strands = Strands::all();
        
        // Get filter parameters
        $filterGrade = $request->input('grade_level_id');
        $filterStrand = $request->input('strand_id');
        $filterStatus = $request->input('status');
        
        // Build query
        $query = StudentSection::with(['gradeLevel', 'strand'])
            ->withCount('students');
        
        if ($filterGrade) {
            $query->where('grade_level_id', $filterGrade);
        }
        
        if ($filterStrand) {
            $query->where('strand_id', $filterStrand);
        }
        
        if ($filterStatus === 'full') {
            $query->where('is_full', true);
        } elseif ($filterStatus === 'available') {
            $query->where('is_full', false)->where('is_active', true);
        } elseif ($filterStatus === 'inactive') {
            $query->where('is_active', false);
        }
        
        $sections = $query->orderBy('grade_level_id')
            ->orderBy('strand_id')
            ->orderBy('section_priority')
            ->get();
        
        // Get statistics
        $stats = $this->getSectionStatistics();
        
        return view('admin.section_management', compact('sections', 'gradeLevels', 'strands', 'stats'));
    }
    
    /**
     * Get section statistics
     */
    private function getSectionStatistics()
    {
        return [
            'total_sections' => StudentSection::count(),
            'active_sections' => StudentSection::where('is_active', true)->count(),
            'full_sections' => StudentSection::where('is_full', true)->count(),
            'total_students' => Student::whereNotNull('section_id')->count(),
            'available_capacity' => StudentSection::where('is_active', true)
                ->where('is_full', false)
                ->sum(DB::raw('max_capacity - current_count')),
        ];
    }
    
    /**
     * Create new section (or bulk create)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'grade_level_id' => 'required|exists:grade_levels,grade_level_id',
            'strand_id' => 'nullable|exists:strands,id',
            'section_name' => 'required_without:bulk_create|string|max:255',
            'section_priority' => 'required_without:bulk_create|integer|min:1',
            'max_capacity' => 'required|integer|min:1|max:50',
            'bulk_create' => 'nullable|boolean',
            'bulk_count' => 'required_if:bulk_create,true|integer|min:1|max:10',
        ]);
        
        try {
            DB::beginTransaction();
            
            if ($request->bulk_create) {
                // Bulk create sections
                $sections = $this->bulkCreateSections(
                    $validated['grade_level_id'],
                    $validated['strand_id'] ?? null,
                    $validated['bulk_count'],
                    $validated['max_capacity']
                );
                
                DB::commit();
                
                return response()->json([
                    'success' => true,
                    'message' => count($sections) . ' sections created successfully.',
                    'sections' => $sections
                ]);
            } else {
                // Create single section
                $section = $this->createSection(
                    $validated['grade_level_id'],
                    $validated['strand_id'] ?? null,
                    $validated['section_name'],
                    $validated['section_priority'],
                    $validated['max_capacity']
                );
                
                DB::commit();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Section created successfully.',
                    'section' => $section
                ]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating section: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create section: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Bulk create sections
     */
    private function bulkCreateSections($gradeLevelId, $strandId, $count, $maxCapacity)
    {
        $gradeLevel = GradeLevel::find($gradeLevelId);
        $strand = $strandId ? Strands::find($strandId) : null;
        
        $existingSections = StudentSection::where('grade_level_id', $gradeLevelId)
            ->when($strandId, function($q) use ($strandId) {
                return $q->where('strand_id', $strandId);
            })
            ->count();
        
        $sections = [];
        
        for ($i = 0; $i < $count; $i++) {
            $priority = $existingSections + $i + 1;
            $sectionName = $this->generateSectionName($gradeLevel, $strand, $priority);
            
            $section = $this->createSection(
                $gradeLevelId,
                $strandId,
                $sectionName,
                $priority,
                $maxCapacity
            );
            
            $sections[] = $section;
        }
        
        return $sections;
    }
    
    /**
     * Generate section name
     */
    private function generateSectionName($gradeLevel, $strand, $priority)
    {
        $name = "Grade " . $gradeLevel->name;
        
        if ($strand) {
            $name .= " - " . $strand->name;
        }
        
        $name .= " - Section " . $priority;
        
        return $name;
    }
    
    /**
     * Create a single section
     */
    private function createSection($gradeLevelId, $strandId, $sectionName, $priority, $maxCapacity)
    {
        $section = StudentSection::create([
            'section_name' => $sectionName,
            'grade_level_id' => $gradeLevelId,
            'strand_id' => $strandId,
            'max_capacity' => $maxCapacity,
            'current_count' => 0,
            'section_priority' => $priority,
            'is_active' => true,
            'is_full' => false,
        ]);
        
        Log::info('Section created', [
            'section_id' => $section->id,
            'section_name' => $section->section_name,
            'grade_level_id' => $gradeLevelId,
            'strand_id' => $strandId,
            'priority' => $priority,
            'max_capacity' => $maxCapacity
        ]);
        
        return $section;
    }
    
    /**
     * Update section
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'section_name' => 'required|string|max:255',
            'section_priority' => 'required|integer|min:1',
            'max_capacity' => 'required|integer|min:1|max:50',
            'is_active' => 'required|boolean',
        ]);
        
        try {
            $section = StudentSection::findOrFail($id);
            
            // Check if reducing capacity below current count
            if ($validated['max_capacity'] < $section->current_count) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot set capacity below current student count (' . $section->current_count . ' students).'
                ], 400);
            }
            
            $section->update($validated);
            
            // Recalculate is_full status
            $section->is_full = ($section->current_count >= $section->max_capacity);
            $section->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Section updated successfully.',
                'section' => $section
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating section: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update section: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Delete section (only if empty)
     */
    public function destroy($id)
    {
        try {
            $section = StudentSection::findOrFail($id);
            
            if ($section->current_count > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete section with enrolled students. Please transfer students first.'
                ], 400);
            }
            
            $sectionName = $section->section_name;
            $section->delete();
            
            Log::info('Section deleted', [
                'section_id' => $id,
                'section_name' => $sectionName
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Section deleted successfully.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting section: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete section: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Sync all section counts with actual student counts
     */
    public function syncAllCounts()
    {
        try {
            $sections = StudentSection::all();
            $syncedCount = 0;
            
            foreach ($sections as $section) {
                $section->syncStudentCount();
                $syncedCount++;
            }
            
            return response()->json([
                'success' => true,
                'message' => $syncedCount . ' sections synchronized successfully.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error syncing section counts: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to sync section counts: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get section details with student list
     */
    public function show($id)
    {
        try {
            $section = StudentSection::with(['gradeLevel', 'strand', 'students'])
                ->withCount('students')
                ->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'section' => $section
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching section details: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Section not found.'
            ], 404);
        }
    }
    
    /**
     * Get capacity report
     */
    public function getCapacityReport()
    {
        try {
            $report = [];
            
            $gradeLevels = GradeLevel::all();
            
            foreach ($gradeLevels as $gradeLevel) {
                $gradeLevelId = $gradeLevel->grade_level_id;
                
                // For JHS (grades 7-10)
                if ($gradeLevelId < 11) {
                    $sections = StudentSection::where('grade_level_id', $gradeLevelId)
                        ->where('is_active', true)
                        ->get();
                    
                    $report[] = [
                        'grade_level' => $gradeLevel->name,
                        'strand' => null,
                        'total_sections' => $sections->count(),
                        'full_sections' => $sections->where('is_full', true)->count(),
                        'total_capacity' => $sections->sum('max_capacity'),
                        'current_count' => $sections->sum('current_count'),
                        'available_capacity' => $sections->sum(function($s) {
                            return $s->max_capacity - $s->current_count;
                        }),
                        'fill_percentage' => $sections->sum('max_capacity') > 0 
                            ? round(($sections->sum('current_count') / $sections->sum('max_capacity')) * 100, 2)
                            : 0,
                        'all_full' => StudentSection::allSectionsFull($gradeLevelId, null),
                        'sections' => $sections->map(function($section) {
                            return [
                                'id' => $section->id,
                                'name' => $section->section_name,
                                'current_count' => $section->current_count,
                                'max_capacity' => $section->max_capacity,
                                'is_full' => $section->is_full,
                                'fill_percentage' => $section->getFillPercentage(),
                                'available_capacity' => $section->getAvailableCapacity(),
                            ];
                        })
                    ];
                } else {
                    // For SHS (grades 11-12), report by strand
                    $strands = Strands::all();
                    
                    foreach ($strands as $strand) {
                        $sections = StudentSection::where('grade_level_id', $gradeLevelId)
                            ->where('strand_id', $strand->id)
                            ->where('is_active', true)
                            ->get();
                        
                        if ($sections->count() > 0) {
                            $report[] = [
                                'grade_level' => $gradeLevel->name,
                                'strand' => $strand->name,
                                'total_sections' => $sections->count(),
                                'full_sections' => $sections->where('is_full', true)->count(),
                                'total_capacity' => $sections->sum('max_capacity'),
                                'current_count' => $sections->sum('current_count'),
                                'available_capacity' => $sections->sum(function($s) {
                                    return $s->max_capacity - $s->current_count;
                                }),
                                'fill_percentage' => $sections->sum('max_capacity') > 0 
                                    ? round(($sections->sum('current_count') / $sections->sum('max_capacity')) * 100, 2)
                                    : 0,
                                'all_full' => StudentSection::allSectionsFull($gradeLevelId, $strand->id),
                                'sections' => $sections->map(function($section) {
                                    return [
                                        'id' => $section->id,
                                        'name' => $section->section_name,
                                        'current_count' => $section->current_count,
                                        'max_capacity' => $section->max_capacity,
                                        'is_full' => $section->is_full,
                                        'fill_percentage' => $section->getFillPercentage(),
                                        'available_capacity' => $section->getAvailableCapacity(),
                                    ];
                                })
                            ];
                        }
                    }
                }
            }
            
            return response()->json([
                'success' => true,
                'report' => $report
            ]);
        } catch (\Exception $e) {
            Log::error('Error generating capacity report: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate report: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Transfer student to different section
     */
    public function transferStudent(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,student_id',
            'new_section_id' => 'required|exists:section,id',
        ]);
        
        try {
            DB::beginTransaction();
            
            $student = Student::findOrFail($validated['student_id']);
            $oldSectionId = $student->section_id;
            $newSection = StudentSection::findOrFail($validated['new_section_id']);
            
            // Check if new section has capacity
            if (!$newSection->hasAvailableCapacity()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Target section is full.'
                ], 400);
            }
            
            // Update student section
            $student->section_id = $newSection->id;
            $student->save();
            
            // Update section counts
            if ($oldSectionId) {
                $oldSection = StudentSection::find($oldSectionId);
                if ($oldSection) {
                    $oldSection->decrementStudentCount();
                }
            }
            
            $newSection->incrementStudentCount();
            
            DB::commit();
            
            Log::info('Student transferred between sections', [
                'student_id' => $student->student_id,
                'old_section_id' => $oldSectionId,
                'new_section_id' => $newSection->id
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Student transferred successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error transferring student: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to transfer student: ' . $e->getMessage()
            ], 500);
        }
    }
}
