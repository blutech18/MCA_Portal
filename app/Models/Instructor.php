<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    protected $primaryKey = 'instructor_id';

    public function getRouteKeyName()
    {
        return 'instructor_id';
    }
    protected $fillable = [
      'user_id',
      'instructor_school_id',
      'first_name',
      'middle_name',
      'last_name',
      'suffix',
      'picture',
      'gender',
      'date_of_birth',
      'contact_number',
      'email',
      'address',
      'job_start_date',
      'status',
      'advisory_section_id'
    ];

    public function schoolId()
    {
        return $this->belongsTo(InstructorId::class, 'instructor_school_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    public function classes()
    {
        return $this->belongsToMany(
            SchoolClass::class,            // assume your class model
            'instructor_classes',         // pivot table
            'instructor_id',              // this table’s FK
            'class_id'                    // other table’s FK
        )->withTimestamps(); 
                    // pulls in assigned_at as created_at
    }

    public function schedules()
    {
        return $this->hasManyThrough(
            Schedule::class,
            InstructorClass::class,       // pivot model
            'instructor_id',              // pivot→instructor_id
            'instructor_class_id',        // schedule→instructor_class_id
            'instructor_id',              // local PK
            'id'                          // pivot PK
        );
    }

    public function instructorClasses()
    {
        return $this->hasMany(InstructorClass::class, 'instructor_id', 'instructor_id')
                    ->with(['class.gradeLevel','class.strand','class.section']);
    }

    public function advisorySection()
    {
        return $this->belongsTo(StudentSection::class, 'advisory_section_id', 'id')
                    ->with(['gradeLevel', 'strand']);
    }

    /**
     * Get the full name of the instructor
     * Format: "First Name Middle Name Last Name Suffix"
     */
    public function getFullNameAttribute()
    {
        return ucwords(trim("{$this->first_name} {$this->middle_name} {$this->last_name} {$this->suffix}"));
    }

    /**
     * Get the standardized display name for the instructor
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

}


