<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'student_id','class_id','subject_id','subject',
        'first_quarter','second_quarter','third_quarter','fourth_quarter','final_grade'
      ];
  
      // Cast to hide the old 'subject' string column when accessing relationships
      protected $hidden = [];

      public function student() { return $this->belongsTo(Student::class,'student_id'); }
      public function schoolClass() { return $this->belongsTo(SchoolClass::class,'class_id'); }
      
      // Relationship to subjects table via subject_id
      public function subjectRelation() { return $this->belongsTo(Subject::class,'subject_id'); }
      
      // Alias for easier access - use different name to avoid conflict with 'subject' column
      public function subjectModel() { return $this->belongsTo(Subject::class,'subject_id'); }
      
      // Accessor for backward compatibility with old 'subject' string column
      public function getSubjectNameAttribute()
      {
          // If subject_id exists, return the related subject name
          if ($this->subject_id && $this->relationLoaded('subjectModel')) {
              return $this->subjectModel->name;
          }
          
          // Otherwise return the string value (old data)
          return $this->attributes['subject'] ?? null;
      }
}
