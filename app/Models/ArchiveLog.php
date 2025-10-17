<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchiveLog extends Model
{
    protected $fillable = [
        'academic_year', 'action', 'students_count', 'performed_by', 'notes'
    ];
    
    public function performedBy() {
        return $this->belongsTo(User::class, 'performed_by');
    }
    
    /**
     * Log an archive action
     */
    public static function logAction($academicYear, $action, $studentsCount = null, $notes = null)
    {
        return self::create([
            'academic_year' => $academicYear,
            'action' => $action,
            'students_count' => $studentsCount,
            'performed_by' => auth()->id(),
            'notes' => $notes,
        ]);
    }
}