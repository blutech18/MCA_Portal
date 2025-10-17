<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewStudentEnrollee extends Model
{
    protected $table = 'new_student_enrollees';
    protected $fillable = [
        'strand','shs_grade','jhs_grade','semester',
        'surname','given_name','middle_name','lrn',
        'contact_no','email','address','living_with',
        'dob','birthplace','gender','religion','nationality',
        'former_school','previous_grade','last_school_year',
        'school_type','school_address','reason_transfer',
        'working_student','intend_working_student','siblings',
        'club_member','club_name',
        'father_name','father_occupation','father_contact_no','father_email',
        'mother_name','mother_occupation','mother_contact_no','mother_email',
        'guardian_name','guardian_occupation','guardian_contact_no','guardian_email',
        'medical_history','allergy_specify','others_specify','report_card_path',
        'good_moral_path',
        'birth_certificate_path',
        'id_picture_path',
        'payment_applicant_name', 'payment_reference', 'payment_receipt_path', 'paid',
        'payment_status', 'payment_status_changed_at', 'payment_status_changed_by',
        'application_number',
        'status', 'decline_reason', 'status_updated_at',
        // Required fields that were missing
        'last_name', 'first_name', 'pob', 'mobile', 'last_school', 'grade_completed', 
        'sy_completed', 'form138_path', 'desired_grade'
    ];

    protected $casts = [
        'paid' => 'boolean',
        'working_student' => 'boolean',
        'intend_working_student' => 'boolean',
        'club_member' => 'boolean',
        'status_updated_at' => 'datetime',
        'payment_status_changed_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->payment_status)) {
                $model->payment_status = 'Pending Verification';
            }
        });
    }

     public function getIsEnrolledAttribute(): bool
    {
        // we assume that once approved, school_student_id in students
        // matches this enrollee's application_number
        return Student::whereHas('studentId', function($q){
            $q->where('student_number', $this->application_number);
        })->exists();
    }

    /**
     * Get the standardized display name for the enrollee
     * Format: "Surname, Given Name Middle Name"
     */
    public function getDisplayNameAttribute()
    {
        $name = trim("{$this->surname}, {$this->given_name}");
        
        if (!empty($this->middle_name)) {
            $name .= " {$this->middle_name}";
        }
        
        return ucwords($name);
    }

    /**
     * Get the short display name (Given Name Surname)
     * Used for profile displays and cards
     */
    public function getShortNameAttribute()
    {
        return ucwords(trim("{$this->given_name} {$this->surname}"));
    }

    /**
     * Relationship to StrandAssessmentResult
     */
    public function assessmentResult()
    {
        return $this->hasOne(StrandAssessmentResult::class, 'enrollment_id');
    }
    
}
