<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OldStudentEnrollee extends Model
{
    protected $table = 'old_student_enrollees';

    protected $fillable = [
        // Step 1
        'semester',
        'surname', 'given_name', 'middle_name', 'lrn',
        'student_id', 'grade_level_applying', 'terms_accepted',

        // Step 2
        'payment_applicant_name', 'payment_reference',
        'payment_receipt_path', 'paid',

        // Step 3
        'clearance_path',

        // Step 4
        'application_number',
    ];

    // Cast JSON column
    protected $casts = [
        'terms_accepted' => 'array',
        'paid'           => 'boolean',
    ];

     public function getIsEnrolledAttribute(): bool
    {
        // we assume that once approved, student_school_id in students
        // matches this enrollee’s application_number
        return Student::whereHas('studentId', function($q){
            $q->where('student_number', $this->application_number);
        })->exists();
    }
}
