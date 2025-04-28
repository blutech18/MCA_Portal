<?php

namespace App\Models;

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
        return $this->belongsTo(Strand::class, 'strand_id', 'id');
    }

    public function classes()
    {
        return $this->hasMany(SchoolClass::class, 'section_id');
    }
}
