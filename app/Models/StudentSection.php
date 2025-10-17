<?php

namespace App\Models;

use App\Models\Strands;
use Illuminate\Database\Eloquent\Model;

class StudentSection extends Model
{
    protected $table = 'section';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable = [
        'section_name',
        'grade_level_id',  // integer 7–12
        'strand_id',    // nullable for grades 7–10
        'max_capacity',
        'current_count',
        'section_priority',
        'is_active',
        'is_full',
        'section_filled_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_full' => 'boolean',
        'section_filled_at' => 'datetime',
    ];

    public function courses()
    {
        return $this->belongsToMany(
            SchoolClass::class,
            'course_section',
            'section_id',
            'course_id'
        )->withTimestamps();
    }

    public function gradeLevel()
    {
        return $this->belongsTo(GradeLevel::class, 'grade_level_id', 'grade_level_id');
    }

    // Define the relationship to Strand
    public function strand()
    {
        return $this->belongsTo(Strands::class, 'strand_id', 'id');
    }

    public function classes()
    {
        return $this->hasMany(SchoolClass::class, 'section_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'section_id');
    }

    /**
     * Boot method to handle model events
     */
    protected static function boot()
    {
        parent::boot();

        // Automatically create default classes when a section is created
        static::created(function ($section) {
            $section->createDefaultClasses();
        });
    }

    /**
     * Create default classes for this section
     */
    public function createDefaultClasses()
    {
        try {
            // Get default subjects
            $defaultSubjects = \App\Models\Subject::where('is_default', true)->get();
            
            if ($defaultSubjects->isEmpty()) {
                \Log::warning('No default subjects found for section', [
                    'section_id' => $this->id,
                    'grade_level_id' => $this->grade_level_id
                ]);
                return;
            }

            $createdClasses = [];

            foreach ($defaultSubjects as $subject) {
                // Create class name: "Subject Name - Section Name"
                $className = $subject->name . ' - ' . $this->section_name;
                
                $class = \App\Models\SchoolClass::create([
                    'name' => $className,
                    'code' => strtoupper(substr($subject->name, 0, 3)) . '-' . $this->id,
                    'subject_id' => $subject->id,
                    'grade_level_id' => $this->grade_level_id,
                    'strand_id' => $this->strand_id,
                    'section_id' => $this->id,
                    'semester' => '1st',
                    'room' => 'TBA'
                ]);

                $createdClasses[] = [
                    'class_id' => $class->id,
                    'class_name' => $className,
                    'subject_name' => $subject->name
                ];
            }

            \Log::info('✅ AUTO-CREATED CLASSES FOR SECTION', [
                'section_id' => $this->id,
                'section_name' => $this->section_name,
                'grade_level_id' => $this->grade_level_id,
                'strand_id' => $this->strand_id,
                'classes_created' => count($createdClasses),
                'classes' => $createdClasses
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to create default classes for section', [
                'section_id' => $this->id,
                'section_name' => $this->section_name,
                'grade_level_id' => $this->grade_level_id,
                'strand_id' => $this->strand_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Get current student count for this section
     */
    public function getCurrentStudentCount(): int
    {
        return $this->students()->count();
    }

    /**
     * Check if section has available capacity
     */
    public function hasAvailableCapacity(): bool
    {
        return $this->is_active && !$this->is_full && $this->current_count < $this->max_capacity;
    }

    /**
     * Get available capacity
     */
    public function getAvailableCapacity(): int
    {
        return max(0, $this->max_capacity - $this->current_count);
    }

    /**
     * Get fill percentage
     */
    public function getFillPercentage(): float
    {
        if ($this->max_capacity == 0) {
            return 0;
        }
        return round(($this->current_count / $this->max_capacity) * 100, 2);
    }

    /**
     * Increment student count and check if section is full
     */
    public function incrementStudentCount(): void
    {
        $wasNotFull = !$this->is_full;
        $this->current_count++;
        
        if ($this->current_count >= $this->max_capacity) {
            $this->is_full = true;
            $this->section_filled_at = now();
        }
        
        $this->save();
        
        \Log::info('Section student count incremented', [
            'section_id' => $this->id,
            'section_name' => $this->section_name,
            'current_count' => $this->current_count,
            'max_capacity' => $this->max_capacity,
            'is_full' => $this->is_full
        ]);
        
        // Trigger notifications if section just became full
        if ($this->is_full && $wasNotFull) {
            $this->triggerCapacityAlerts();
        }
    }

    /**
     * Decrement student count (for removals/transfers)
     */
    public function decrementStudentCount(): void
    {
        if ($this->current_count > 0) {
            $this->current_count--;
            
            if ($this->is_full && $this->current_count < $this->max_capacity) {
                $this->is_full = false;
                $this->section_filled_at = null;
            }
            
            $this->save();
            
            \Log::info('Section student count decremented', [
                'section_id' => $this->id,
                'section_name' => $this->section_name,
                'current_count' => $this->current_count,
                'max_capacity' => $this->max_capacity,
                'is_full' => $this->is_full
            ]);
        }
    }

    /**
     * Sync current count with actual student count in database
     */
    public function syncStudentCount(): void
    {
        $actualCount = $this->getCurrentStudentCount();
        $this->current_count = $actualCount;
        $this->is_full = ($actualCount >= $this->max_capacity);
        
        if ($this->is_full && !$this->section_filled_at) {
            $this->section_filled_at = now();
        } elseif (!$this->is_full) {
            $this->section_filled_at = null;
        }
        
        $this->save();
    }

    /**
     * Find next available section for a grade level and strand
     * Uses first-come-first-serve logic based on section priority
     */
    public static function findAvailableSection(int $gradeLevelId, ?int $strandId = null): ?self
    {
        $query = self::where('grade_level_id', $gradeLevelId)
            ->where('is_active', true)
            ->where('is_full', false)
            ->where('current_count', '<', \DB::raw('max_capacity'))
            ->orderBy('section_priority', 'asc')
            ->orderBy('id', 'asc');
        
        // For SHS (grades 11-12), also filter by strand
        if ($gradeLevelId >= 11 && $strandId) {
            $query->where('strand_id', $strandId);
        }
        
        return $query->first();
    }

    /**
     * Get all sections for a grade level and strand with capacity info
     */
    public static function getSectionsWithCapacity(int $gradeLevelId, ?int $strandId = null)
    {
        $query = self::where('grade_level_id', $gradeLevelId)
            ->orderBy('section_priority', 'asc')
            ->orderBy('id', 'asc');
        
        if ($gradeLevelId >= 11 && $strandId) {
            $query->where('strand_id', $strandId);
        }
        
        return $query->get();
    }

    /**
     * Check if all sections for a grade/strand are full
     */
    public static function allSectionsFull(int $gradeLevelId, ?int $strandId = null): bool
    {
        $query = self::where('grade_level_id', $gradeLevelId)
            ->where('is_active', true);
        
        if ($gradeLevelId >= 11 && $strandId) {
            $query->where('strand_id', $strandId);
        }
        
        $totalSections = $query->count();
        $fullSections = (clone $query)->where('is_full', true)->count();
        
        return $totalSections > 0 && $totalSections === $fullSections;
    }
    
    /**
     * Trigger capacity alerts when section becomes full
     */
    protected function triggerCapacityAlerts(): void
    {
        try {
            // Get all admin users to notify
            $admins = \App\Models\User::where('user_type', 'admin')->get();
            
            // Send section full notification
            foreach ($admins as $admin) {
                $admin->notify(new \App\Notifications\SectionCapacityAlert($this, 'section_full'));
            }
            
            \Log::info('Section full notification sent', [
                'section_id' => $this->id,
                'section_name' => $this->section_name,
                'current_count' => $this->current_count,
                'max_capacity' => $this->max_capacity
            ]);
            
            // Check if ALL sections for this grade/strand are now full
            if (self::allSectionsFull($this->grade_level_id, $this->strand_id)) {
                $this->triggerAllSectionsFullAlert();
            }
        } catch (\Exception $e) {
            \Log::error('Failed to send section capacity alert', [
                'section_id' => $this->id,
                'error' => $e->getMessage()
            ]);
        }
    }
    
    /**
     * Trigger alert when all sections for a grade/strand are full
     */
    protected function triggerAllSectionsFullAlert(): void
    {
        try {
            $sections = self::getSectionsWithCapacity($this->grade_level_id, $this->strand_id);
            $totalCapacity = $sections->sum('max_capacity');
            $totalStudents = $sections->sum('current_count');
            
            $admins = \App\Models\User::where('user_type', 'admin')->get();
            
            foreach ($admins as $admin) {
                $admin->notify(new \App\Notifications\SectionCapacityAlert(
                    $this,
                    'all_sections_full',
                    [
                        'total_capacity' => $totalCapacity,
                        'total_students' => $totalStudents,
                        'total_sections' => $sections->count()
                    ]
                ));
            }
            
            \Log::warning('⚠️ ALL SECTIONS FULL ALERT TRIGGERED', [
                'grade_level_id' => $this->grade_level_id,
                'strand_id' => $this->strand_id,
                'total_sections' => $sections->count(),
                'total_students' => $totalStudents,
                'total_capacity' => $totalCapacity
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to send all sections full alert', [
                'grade_level_id' => $this->grade_level_id,
                'strand_id' => $this->strand_id,
                'error' => $e->getMessage()
            ]);
        }
    }
    
    /**
     * Get capacity statistics for a grade level/strand
     */
    public static function getCapacityStats(int $gradeLevelId, ?int $strandId = null): array
    {
        $sections = self::getSectionsWithCapacity($gradeLevelId, $strandId);
        
        $totalSections = $sections->count();
        $fullSections = $sections->where('is_full', true)->count();
        $totalCapacity = $sections->sum('max_capacity');
        $totalStudents = $sections->sum('current_count');
        $availableSeats = $totalCapacity - $totalStudents;
        $fillPercentage = $totalCapacity > 0 ? round(($totalStudents / $totalCapacity) * 100, 2) : 0;
        
        return [
            'total_sections' => $totalSections,
            'full_sections' => $fullSections,
            'available_sections' => $totalSections - $fullSections,
            'total_capacity' => $totalCapacity,
            'total_students' => $totalStudents,
            'available_seats' => $availableSeats,
            'fill_percentage' => $fillPercentage,
            'all_full' => self::allSectionsFull($gradeLevelId, $strandId),
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
