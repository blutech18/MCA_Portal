<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    protected $table = 'classes';   // if your model is not named "Class"
    protected $fillable = [
        'name', 'code', 'subject_id', 'grade_level_id', 'strand_id', 'section_id', 'semester', 'room',
    ];
    
    /**
     * Belongs to a specific StudentSection.
     */
    public function section()
    {
        return $this->belongsTo(StudentSection::class, 'section_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function gradeLevel()
    {
        return $this->belongsTo(GradeLevel::class, 'grade_level_id', 'grade_level_id');
    }

    public function strand()
    {
        return $this->belongsTo(Strand::class);
    }


    public function instructors()
    {
        // pivot table: instructor_classes
        return $this->belongsToMany(
            Instructor::class,
            'instructor_classes',
            'class_id',
            'instructor_id'
        )->withTimestamps();
    }

    public function schedules()
    {
        // indirect via pivot
        return $this->hasManyThrough(
            Schedule::class,
            InstructorClass::class,
            'class_id',           // pivot FK
            'instructor_class_id',// schedule FK
            'id',                 // this model PK
            'id'                  // pivot PK
        );
    }

    public function students()
    {
        return $this->belongsToMany(
            Student::class,
            'enrollments',
            'class_id',
            'student_id'
        )
        ->withPivot('enrolled_at')
        ->withTimestamps();
    }

    public function sections()
    {
        return $this->belongsToMany(
            StudentSection::class,
            'course_section',   // pivot table
            'course_id',        // this model’s FK
            'section_id'        // the other model’s FK
        )->withTimestamps();
    }
}
