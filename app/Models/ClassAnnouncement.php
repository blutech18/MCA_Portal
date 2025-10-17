<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ClassAnnouncement extends Model
{
    protected $table = 'class_announcements';

    protected $fillable = [
        'class_name',
        'title',
        'message',
        'file_path',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationship to SchoolClass via class_name
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_name', 'name');
    }

    // Accessor for file URL
    public function getFileUrlAttribute()
    {
        if ($this->file_path && Storage::disk('public')->exists($this->file_path)) {
            return Storage::url($this->file_path);
        }
        return null;
    }

    // Accessor for file name
    public function getFileNameAttribute()
    {
        if ($this->file_path) {
            return basename($this->file_path);
        }
        return null;
    }

    // Check if file exists
    public function getFileExistsAttribute()
    {
        return $this->file_path && Storage::disk('public')->exists($this->file_path);
    }
}
