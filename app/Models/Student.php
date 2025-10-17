<?php

namespace App\Models;

use App\Models\Strands;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $primaryKey = 'student_id';

    protected $fillable = [
        'school_student_id', 'user_id', 'first_name', 'middle_name', 'last_name', 'suffix', 
        'picture', 'gender', 'date_of_birth', 'contact_number', 'email', 'address', 
        'grade_level_id', 'strand_id', 'section_id', 'status_id', 'date_enrolled',
        'semester', 'grade_id', 'schedule_id', 'documents_id', 'attendance_report_id', 'lrn'
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function getFullNameAttribute()
    {
        return ucwords(trim("{$this->first_name} {$this->middle_name} {$this->last_name} {$this->suffix}"));
    }

    /**
     * Get the standardized display name for the student
     * Format: "Last Name, First Name Middle Name"
     */
    public function getDisplayNameAttribute()
    {
        $name = trim("{$this->last_name}, {$this->first_name}");
        
        if (!empty($this->middle_name)) {
            $name .= " {$this->middle_name}";
        }
        
        if (!empty($this->suffix)) {
            $name .= " {$this->suffix}";
        }
        
        return ucwords($name);
    }

    /**
     * Get the short display name (First Name Last Name)
     * Used for profile displays and cards
     */
    public function getShortNameAttribute()
    {
        $name = trim("{$this->first_name} {$this->last_name}");
        
        if (!empty($this->suffix)) {
            $name .= " {$this->suffix}";
        }
        
        return ucwords($name);
    }
    public function studentID()
    {
        return $this->belongsTo(StudentId::class, 'school_student_id', 'student_number');
    }
    public function gradeLevel()
    {
        return $this->belongsTo(GradeLevel::class, 'grade_level_id','grade_level_id');
    }
    
    public function strand()
    {
        return $this->belongsTo(Strands::class, 'strand_id', 'id');
    }
    
    public function section()
    {
        return $this->belongsTo(StudentSection::class, 'section_id');
    }
        

    public function status()
    {
        return $this->belongsTo(StudentStatus::class, 'status_id');
    }

    public function classes()
    {
        return $this->belongsToMany(
            SchoolClass::class,
            'enrollments',
            'student_id',
            'class_id'
        )
        ->withPivot('enrolled_at')
        ->withTimestamps();
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class,'student_id');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class, 'student_id', 'student_id');
    }

    /**
     * Assign default subjects to a student
     */
    public function assignDefaultSubjects()
    {
        $defaultSubjects = Subject::where('is_default', true)->get();
        
        foreach ($defaultSubjects as $subject) {
            // Check if student already has this subject
            $existingGrade = Grade::where('student_id', $this->student_id)
                ->where('subject_id', $subject->id)
                ->first();
            
            if (!$existingGrade) {
                Grade::create([
                    'student_id' => $this->student_id,
                    'subject_id' => $subject->id,
                    'subject' => $subject->name, // For backward compatibility
                    'first_quarter' => 0,
                    'second_quarter' => 0,
                    'third_quarter' => 0,
                    'fourth_quarter' => 0,
                    'final_grade' => 0,
                ]);
            }
        }
    }

    /**
     * Get assessment result for this student
     * Links through enrollment record using email matching
     */
    public function getAssessmentResult()
    {
        // Try to find assessment result by matching email
        return \App\Models\StrandAssessmentResult::latestForEmailAnyYear($this->email)->first();
    }

    /**
     * Check if student has assessment result
     */
    public function hasAssessmentResult()
    {
        return $this->getAssessmentResult() !== null;
    }

    public function getIsEnrolledAttribute(): bool
    {
        // Check if the student has "Enrolled" status
        if ($this->status && $this->status->name === 'Enrolled') {
            return true;
        }
        
        // Fallback: Check if the student has a valid student number (from student_ids table)
        // AND is present in either enrollee table (approved)
        return $this->studentId && (
            \App\Models\NewStudentEnrollee::where('application_number', $this->studentId->student_number)->exists() ||
            \App\Models\OldStudentEnrollee::where('application_number', $this->studentId->student_number)->exists()
        );
    }

    /**
     * Get the student's adviser display name based on the first instructor
     * teaching any class in the student's current section.
     */
    public function getAdviserNameAttribute(): ?string
    {
        try {
            if (!$this->section_id) {
                return null;
            }
            $instructor = \App\Models\Instructor::whereHas('instructorClasses.class', function($q) {
                    $q->where('section_id', $this->section_id);
                })
                ->orderByDesc('id')
                ->first();

            if (!$instructor) {
                return null;
            }

            $parts = array_filter([
                $instructor->first_name ?? null,
                $instructor->middle_name ?? null,
                $instructor->last_name ?? null,
                $instructor->suffix ?? null,
            ]);
            return count($parts) ? ucwords(trim(implode(' ', $parts))) : null;
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Find student by LRN
     */
    public static function findByLRN($lrn)
    {
        return self::where('lrn', $lrn)->first();
    }


    /*

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }

    public function documents()
    {
        return $this->belongsTo(Document::class, 'documents_id');
    }

    public function attendanceReport()
    {
        return $this->belongsTo(AttendanceReport::class, 'attendance_report_id');
    }*/

}
