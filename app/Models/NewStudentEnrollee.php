<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewStudentEnrollee extends Model
{
    protected $table = 'new_student_enrollees';
    protected $fillable = [
        'strand','semester',
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
        'application_number',
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
