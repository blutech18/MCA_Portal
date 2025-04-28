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
        Schema::table('students_tables', function (Blueprint $table) {
            
            // Add the foreign key constraint
            $table->foreign('school_student_id')
                  ->references('id')->on('student_id')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students_tables', function (Blueprint $table) {
            //
        });
    }
};
