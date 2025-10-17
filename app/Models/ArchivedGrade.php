<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchivedGrade extends Model
{
    protected $fillable = [
        'archived_student_id', 'academic_year', 'subject_id', 'subject_name', 'subject_code',
        'first_quarter', 'second_quarter', 'third_quarter', 'fourth_quarter', 'final_grade'
    ];
    
    protected $casts = [
        'first_quarter' => 'decimal:2',
        'second_quarter' => 'decimal:2',
        'third_quarter' => 'decimal:2',
        'fourth_quarter' => 'decimal:2',
        'final_grade' => 'decimal:2',
    ];
    
    public function archivedStudent() {
        return $this->belongsTo(ArchivedStudent::class);
    }
}