<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassAnnouncement extends Model
{
    protected $fillable = ['class_name', 'title', 'message', 'file_path'];
}
