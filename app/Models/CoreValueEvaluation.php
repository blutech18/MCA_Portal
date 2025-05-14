<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoreValueEvaluation extends Model
{
    protected $fillable = ['student_id','core_value_id','score'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    public function coreValue()
    {
        return $this->belongsTo(CoreValue::class);
    }
}
