<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $primaryKey = 'student_id';

    protected $fillable = [
        'student_school_id', 'user_id', 'first_name', 'middle_name', 'last_name', 'suffix', 
        'picture', 'gender', 'date_of_birth', 'contact_number', 'email', 'address', 
        'grade_level_id', 'strand_id', 'section_id', 'status_id', 'date_enrolled',
        'semester', 'grade_id', 'schedule_id', 'documents_id', 'attendance_report_id'
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function getFullNameAttribute()
    {
        return ucwords(trim("{$this->first_name} {$this->middle_name} {$this->last_name} {$this->suffix}"));
    }
    public function studentID()
    {
        return $this->belongsTo(StudentId::class, 'student_school_id');
    }
    public function gradeLevel()
    {
        return $this->belongsTo(GradeLevel::class, 'grade_level_id','grade_level_id');
    }
    
    public function strand()
    {
        return $this->belongsTo(Strands::class, 'strand_id'); 
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

    public function getIsEnrolledAttribute(): bool
    {
        // Check if the student has a valid student number (from student_ids table)
        // AND is present in either enrollee table (approved)
        return $this->studentId && (
            \App\Models\NewStudentEnrollee::where('application_number', $this->studentId->student_number)->exists() ||
            \App\Models\OldStudentEnrollee::where('application_number', $this->studentId->student_number)->exists()
        );
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
