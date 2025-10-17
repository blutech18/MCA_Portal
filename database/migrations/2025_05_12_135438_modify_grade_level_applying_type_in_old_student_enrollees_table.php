<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check what columns exist in the table
        $columns = DB::select("SHOW COLUMNS FROM old_student_enrollees");
        $columnNames = array_column($columns, 'Field');
        
        Schema::table('old_student_enrollees', function (Blueprint $table) use ($columnNames) {
            // Drop applying_year if it exists
            if (in_array('applying_year', $columnNames)) {
                $table->dropColumn('applying_year');
            }
            // Drop grade_level_applying if it exists (in case of re-run)
            if (in_array('grade_level_applying', $columnNames)) {
                $table->dropColumn('grade_level_applying');
            }
        });
        
        Schema::table('old_student_enrollees', function (Blueprint $table) use ($columnNames) {
            // Add new grade_level_applying column as tiny integer if it doesn't exist
            if (!in_array('grade_level_applying', $columnNames)) {
                $table->unsignedTinyInteger('grade_level_applying')
                      ->nullable()
                      ->comment('Grade level the student is applying for (7–12)');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('old_student_enrollees', function (Blueprint $table) {
            // Drop the tinyint column
            $table->dropColumn('grade_level_applying');
        });

        Schema::table('old_student_enrollees', function (Blueprint $table) {
            // Re-add as YEAR(4) (restore original applying_year column)
            $table->year('applying_year')
                  ->nullable()
                  ->after('student_id');
        });
    }
};
