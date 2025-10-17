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
        Schema::table('enrollments', function (Blueprint $table) {
            // Add missing columns first
            $table->unsignedBigInteger('student_id')->nullable();
            $table->unsignedBigInteger('class_id')->nullable();
            
            // Then add foreign keys
            $table->foreign('student_id')
                  ->references('student_id')
                  ->on('students')
                  ->cascadeOnDelete();

            $table->foreign('class_id')
                  ->references('id')
                  ->on('classes')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            //
        });
    }
};
