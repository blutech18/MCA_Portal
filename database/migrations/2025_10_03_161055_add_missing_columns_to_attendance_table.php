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
            // Add missing columns
            $table->unsignedBigInteger('student_id')->after('instructor_class_id');
            $table->enum('status', ['present', 'absent', 'late'])->after('date');
            $table->time('time_in')->nullable()->after('status');
            $table->time('time_out')->nullable()->after('time_in');
            
            // Add indexes for better performance
            $table->index(['student_id', 'date']);
            $table->index(['instructor_class_id', 'student_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendance', function (Blueprint $table) {
            $table->dropIndex(['student_id', 'date']);
            $table->dropIndex(['instructor_class_id', 'student_id', 'date']);
            $table->dropColumn(['student_id', 'status', 'time_in', 'time_out']);
        });
    }
};