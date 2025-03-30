<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'user_id', 'subject', 'day', 'time', 'teacher', 'image'
    ];
}
