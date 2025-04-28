<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'student_id','class_id','subject_id',
        'first_quarter','second_quarter','third_quarter','fourth_quarter','final_grade'
      ];
  
      public function student() { return $this->belongsTo(Student::class,'student_id'); }
      public function schoolClass() { return $this->belongsTo(SchoolClass::class,'class_id'); }
      public function subject() { return $this->belongsTo(Subject::class,'subject_id'); }
}
