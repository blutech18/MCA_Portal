<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassAnnouncement extends Model
{
    protected $table = 'class_announcements';

    protected $fillable = [
        'class_name',
        'title',
        'message',
        'file_path',
    ];
}
