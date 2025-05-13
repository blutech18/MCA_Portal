<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $primaryKey = 'schedule_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'instructor_class_id',
        'day_of_week',
        'start_time',
        'end_time',
        'room',
    ];
    
    public function instructorClass()
    {
        return $this->belongsTo(InstructorClass::class, 'instructor_class_id');
    }

    public function schoolClass()
    {
        // Goes: schedules.instructor_class_id → instructor_classes.id
        // then instructor_classes.class_id → classes.id
        return $this->hasOneThrough(
            \App\Models\SchoolClass::class,
            \App\Models\InstructorClass::class,
            'id',                     // FK on InstructorClass (its PK)
            'id',                     // FK on SchoolClass (its PK)
            'instructor_class_id',    // local key on Schedule
            'class_id'                // local key on InstructorClass
        );
    }
}

