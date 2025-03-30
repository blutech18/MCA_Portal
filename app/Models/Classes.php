<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    public function users()
    {
        return $this->hasMany(\App\Models\User::class, 'class_id');
    }
}
