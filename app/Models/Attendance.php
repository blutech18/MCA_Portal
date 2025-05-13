<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendance';
    
    protected $fillable = [
        'student_id','instructor_class_id','date','status'
      ];
  
      public function student()
      {
          return $this->belongsTo(Student::class);
      }
  
      public function instructorClass()
      {
          return $this->belongsTo(InstructorClass::class);
      }
}