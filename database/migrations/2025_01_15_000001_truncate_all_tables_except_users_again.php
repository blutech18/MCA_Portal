<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Disable foreign key checks temporarily
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // List of all tables to truncate (excluding users and system tables)
        $tablesToTruncate = [
            'password_reset_tokens',
            'sessions',
            'cache',
            'cache_locks',
            'jobs',
            'job_batches',
            'failed_jobs',
            
            // Core application tables
            'students',
            'instructors',
            'grades',
            'enrollments',
            'subjects',
            'documents',
            'class_announcements',
            'classes',
            'strands',
            'student_ids',
            'instructor_ids',
            'sections',
            'instructor_classes',
            'schedules',
            'grade_levels',
            'student_status',
            'attendance',
            'new_student_enrollees',
            'old_student_enrollees',
            'core_values',
            'core_value_evaluations',
            'student_id',
            'strand_assessment_results',
            
            // Archive tables
            'archived_students',
            'archived_grades',
            'archived_attendance',
            'academic_years',
            'archive_logs',
            
            // Additional tables that might exist
            'enrollment_fees',
        ];

        // Truncate each table
        foreach ($tablesToTruncate as $table) {
            if (Schema::hasTable($table)) {
                DB::statement("TRUNCATE TABLE `{$table}`");
                echo "Truncated table: {$table}\n";
            }
        }
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        echo "All tables truncated successfully (except users table)\n";
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration cannot be reversed as truncating removes all data
        echo "Warning: This migration cannot be reversed. Data has been permanently deleted.\n";
    }
};
