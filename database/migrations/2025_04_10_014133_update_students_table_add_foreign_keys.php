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
        Schema::table('students',function(Blueprint $table){
            
            $table->renameColumn('section','Section_id');
            $table->renameColumn('status','status_id');

            $table->unsignedBigInteger('grade_id')->nullable()->after('status_id');
            $table->unsignedBigInteger('schedule_id')->nullable()->after('grade_id');
            $table->unsignedBigInteger('documents_id')->nullable()->after('schedule_id');
            $table->unsignedBigInteger('attendance_report_id')->nullable()->after('documents_id');

            $table->foreign('grade_level_id')->references('grade_level_id')->on('grade_levels')->onDelete('cascade');
            $table->foreign('strand_id')->references('strand_id')->on('strands')->onDelete('set null');
            $table->foreign('section_id')->references('section_id')->on('sections')->onDelete('set null');
            $table->foreign('status_id')->references('student_status_id')->on('student_status')->onDelete('set null');
            $table->foreign('grade_id')->references('grade_id')->on('grades')->onDelete('cascade');
            $table->foreign('schedule_id')->references('schedule_id')->on('schedules')->onDelete('set null');
            $table->foreign('documents_id')->references('documents_id')->on('documents')->onDelete('set null');
            $table->foreign('attendance_report_id')->references('attendance_report_id')->on('attendance_reports')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
