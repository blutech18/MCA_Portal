<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewStudentEnrollee extends Model
{
    protected $fillable = [
        'semester', 'lrn', 'last_name', 'first_name', 'middle_name', 'extension_name', 'dob', 'gender', 'pob',
        'address', 'mobile', 'email', 'mother_name', 'father_name', 'guardian_name', 'relationship',
        'guardian_contact', 'guardian_email', 'last_school', 'school_address', 'grade_completed',
        'sy_completed', 'form138_path', 'desired_grade', 'preferred_strand'
    ];
    
}
