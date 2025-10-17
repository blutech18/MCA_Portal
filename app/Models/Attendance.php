<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendance';
    
    protected $primaryKey = 'attendance_id';
    
    protected $fillable = [
        'student_id','instructor_class_id','date','status','time_in','time_out'
    ];
  
      public function student()
      {
          return $this->belongsTo(Student::class, 'student_id', 'student_id');
      }
  
      public function instructorClass()
      {
          return $this->belongsTo(InstructorClass::class);
      }
}