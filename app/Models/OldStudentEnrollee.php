<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OldStudentEnrollee extends Model
{
    protected $table = 'old_student_enrollees';
    
    // Ensure we use the correct primary key for route model binding
    protected $primaryKey = 'id';

    protected $fillable = [
        // Step 1
        'semester',
        'surname', 'given_name', 'middle_name', 'lrn',
        'student_id', 'grade_level_applying', 'terms_accepted',

        // Step 2
        'payment_applicant_name', 'payment_reference',
        'payment_receipt_path', 'paid', 'payment_verified', 'payment_verified_at',
        'payment_status', 'payment_status_changed_at', 'payment_status_changed_by',

        // Step 3
        'clearance_path', 'registrar_cleared', 'accounting_cleared', 
        'library_cleared', 'discipline_cleared', 'guidance_cleared',

        // Step 4
        'application_number',
        'status', 'decline_reason', 'status_updated_at',
    ];

    // Cast JSON column
    protected $casts = [
        'terms_accepted' => 'array',
        'paid'           => 'boolean',
        'payment_verified' => 'boolean',
        'payment_verified_at' => 'datetime',
        'status_updated_at' => 'datetime',
        'payment_status_changed_at' => 'datetime',
        'registrar_cleared' => 'boolean',
        'accounting_cleared' => 'boolean',
        'library_cleared' => 'boolean',
        'discipline_cleared' => 'boolean',
        'guidance_cleared' => 'boolean',
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
}
