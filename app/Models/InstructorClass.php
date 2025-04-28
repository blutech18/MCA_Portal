<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstructorClass extends Model
{
    protected $table = 'instructor_classes';
    public $timestamps = true;  

    protected $fillable = [
      'instructor_id',
      'class_id',
      'assigned_at',  // or rename this to created_at if you’d rather let timestamps do it
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'instructor_class_id', 'id');
    }
    public function class()
  {
      // pivot.class_id → classes.id
      return $this->belongsTo(SchoolClass::class, 'class_id', 'id');
  }
}
