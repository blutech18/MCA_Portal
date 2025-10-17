<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchivedStudent extends Model
{
    protected $fillable = [
        'academic_year', 'original_student_id', 'school_student_id',
        'first_name', 'middle_name', 'last_name', 'suffix', 'lrn',
        'email', 'contact_number', 'address', 'date_of_birth', 'gender',
        'grade_level_id', 'grade_level_name', 'section_id', 'section_name',
        'strand_id', 'strand_name', 'status', 'date_enrolled',
        'archived_at', 'archived_by'
    ];
    
    protected $casts = [
        'date_of_birth' => 'date',
        'date_enrolled' => 'date',
        'archived_at' => 'datetime',
    ];
    
    public function grades() {
        return $this->hasMany(ArchivedGrade::class);
    }
    
    public function attendance() {
        return $this->hasMany(ArchivedAttendance::class);
    }
    
    public function archivedBy() {
        return $this->belongsTo(User::class, 'archived_by');
    }
    
    /**
     * Get the full name of the archived student
     */
    public function getFullNameAttribute()
    {
        return ucwords(trim("{$this->first_name} {$this->middle_name} {$this->last_name} {$this->suffix}"));
    }

    /**
     * Get the standardized display name for the archived student
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
     */
    public function getShortNameAttribute()
    {
        $name = trim("{$this->first_name} {$this->last_name}");
        
        if (!empty($this->suffix)) {
            $name .= " {$this->suffix}";
        }
        
        return ucwords($name);
    }
}