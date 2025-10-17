<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchivedAttendance extends Model
{
    protected $table = 'archived_attendance';
    
    protected $fillable = [
        'archived_student_id', 'academic_year', 'date', 'status', 'remarks'
    ];
    
    protected $casts = [
        'date' => 'date',
    ];
    
    public function archivedStudent() {
        return $this->belongsTo(ArchivedStudent::class);
    }
}