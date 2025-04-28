<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstructorId extends Model
{
    protected $table = 'instructor_ids';
    protected $primaryKey = 'id';
    protected $fillable = ['instructor_number'];

    public function instructor()
    {
        return $this->hasOne(Instructor::class, 'instructor_school_id');
    }
}

