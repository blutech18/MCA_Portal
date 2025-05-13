<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('old_student_enrollees', function (Blueprint $table) {
             $table->dropColumn('grade_level_applying');
        });
        Schema::table('old_student_enrollees', function (Blueprint $table) {
            // Re-add as tiny integer
            $table->unsignedTinyInteger('grade_level_applying')
                  ->nullable()
                  ->after('student_id')
                  ->comment('Grade level the student is applying for (7–12)');
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
            // Re-add as YEAR(4)
            $table->year('grade_level_applying')
                  ->nullable()
                  ->after('student_id');
        });
    }
};
