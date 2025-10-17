<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StrandAssessmentResult extends Model
{
    use HasFactory;

    protected $table = 'strand_assessment_results';

    protected $fillable = [
        'email',
        'academic_year_id',
        'recommended_strand',
        'scores',
        'total_questions',
        'completed_at',
        'is_used',
        'enrollment_id'
    ];

    protected $casts = [
        'scores' => 'array',
        'is_used' => 'boolean',
        'completed_at' => 'datetime',
        'academic_year_id' => 'integer'
    ];

    /**
     * Relationship to NewStudentEnrollee
     */
    public function enrollment()
    {
        return $this->belongsTo(NewStudentEnrollee::class, 'enrollment_id');
    }

    /**
     * Relationship to AcademicYear
     */
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }

    /**
     * Scope to get latest result for a specific email in current academic year
     */
    public function scopeLatestForEmail($query, $email)
    {
        $currentAcademicYear = AcademicYear::getCurrent();
        
        return $query->where('email', $email)
                    ->where('academic_year_id', $currentAcademicYear?->id)
                    ->orderBy('completed_at', 'desc');
    }

    /**
     * Scope to get latest result for a specific email in any academic year
     */
    public function scopeLatestForEmailAnyYear($query, $email)
    {
        return $query->where('email', $email)
                    ->orderBy('completed_at', 'desc');
    }

    /**
     * Scope to get results for current academic year only
     */
    public function scopeForCurrentAcademicYear($query)
    {
        $currentAcademicYear = AcademicYear::getCurrent();
        
        return $query->where('academic_year_id', $currentAcademicYear?->id);
    }

    /**
     * Get the score percentage for a specific strand
     */
    public function getScorePercentage($strand = null)
    {
        if (!$strand) {
            $strand = $this->recommended_strand;
        }

        $score = $this->scores[$strand] ?? 0;
        return ($score / $this->total_questions) * 100;
    }

    /**
     * Get all strand scores as percentages
     */
    public function getAllScorePercentages()
    {
        $percentages = [];
        foreach ($this->scores as $strand => $score) {
            $percentages[$strand] = ($score / $this->total_questions) * 100;
        }
        return $percentages;
    }

    /**
     * Get top 3 strands by score
     */
    public function getTopThreeStrands()
    {
        $scores = $this->scores;
        arsort($scores);
        return array_slice($scores, 0, 3, true);
    }

    /**
     * Check if assessment is valid for current academic year
     */
    public function isValidForCurrentAcademicYear()
    {
        $currentAcademicYear = AcademicYear::getCurrent();
        return $this->academic_year_id === $currentAcademicYear?->id;
    }

    /**
     * Get assessment result for email in current academic year
     */
    public static function getValidAssessmentForEmail($email)
    {
        $currentAcademicYear = AcademicYear::getCurrent();
        
        return static::where('email', $email)
                    ->where('academic_year_id', $currentAcademicYear?->id)
                    ->orderBy('completed_at', 'desc')
                    ->first();
    }

    /**
     * Check if email has valid assessment for current academic year
     */
    public static function hasValidAssessmentForEmail($email)
    {
        return static::getValidAssessmentForEmail($email) !== null;
    }
}