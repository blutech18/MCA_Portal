<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    protected $fillable = [
        'year_name', 'start_date', 'end_date', 'is_current', 'is_archived'
    ];
    
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
        'is_archived' => 'boolean',
    ];
    
    /**
     * Get the current academic year
     */
    public static function getCurrent()
    {
        return self::where('is_current', true)->first();
    }
    
    /**
     * Get the current academic year (alias for getCurrent)
     */
    public static function getCurrentAcademicYear()
    {
        return self::getCurrent();
    }
    
    /**
     * Get or create the current academic year
     */
    public static function getOrCreateCurrentAcademicYear()
    {
        $current = self::getCurrent();
        
        if (!$current) {
            // Create default academic years if none exist
            self::createDefaultYears();
            
            // Try to get current again after creating defaults
            $current = self::getCurrent();
            
            // If still no current year, create one for the current calendar year
            if (!$current) {
                $currentYear = date('Y');
                $yearName = "{$currentYear}-" . ($currentYear + 1);
                
                $current = self::create([
                    'year_name' => $yearName,
                    'start_date' => "{$currentYear}-06-01",
                    'end_date' => ($currentYear + 1) . "-05-31",
                    'is_current' => true,
                    'is_archived' => false,
                ]);
            }
        }
        
        return $current;
    }
    
    /**
     * Set this academic year as current
     */
    public function setCurrent()
    {
        // Remove current flag from all years
        self::where('is_current', true)->update(['is_current' => false]);
        
        // Set this year as current
        $this->update(['is_current' => true]);
    }
    
    /**
     * Get available academic years for dropdown
     */
    public static function getAvailableYears()
    {
        return self::orderBy('start_date', 'desc')->get();
    }
    
    /**
     * Create default academic years (2018-present)
     */
    public static function createDefaultYears()
    {
        $currentYear = date('Y');
        $startYear = 2018;
        
        for ($year = $startYear; $year <= $currentYear + 1; $year++) {
            $yearName = "{$year}-" . ($year + 1);
            
            if (!self::where('year_name', $yearName)->exists()) {
                self::create([
                    'year_name' => $yearName,
                    'start_date' => "{$year}-06-01",
                    'end_date' => ($year + 1) . "-05-31",
                    'is_current' => ($year == $currentYear),
                    'is_archived' => ($year < $currentYear),
                ]);
            }
        }
    }
}