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
        Schema::table('attendance', function (Blueprint $table) {
            $table->foreign('student_id')
                  ->references('student_id')->on('students')
                  ->cascadeOnDelete();

            // instructor_classes has id as PK:
            $table->foreign('instructor_class_id')
                  ->references('id')->on('instructor_classes')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendance', function (Blueprint $table) {
            //
        });
    }
};
