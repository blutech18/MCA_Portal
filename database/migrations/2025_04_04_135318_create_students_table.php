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
        Schema::create('students', function (Blueprint $table) {
            $table->id('student_id');//Primary Key Auto increment
            $table->string('school_student_id', 50)->unique(); //school id number
            $table->unsignedBigInteger('user_id');//FK users table

            //Profile
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('suffix')->nullable();
            $table->string('picture')->nullable();//can be filepath or blob

            $table->enum('gender',['male','female']);
            $table->date('date_of_birth');

            //Contact Info
            $table->string('contact_number');
            $table->string('email')->nullable();
            $table->string('address');

            //Academic info and realtions to other tables
            $table->unsignedBigInteger('grade_level_id');
            $table->unsignedBigInteger('strand_id')->nullable();
            $table->unsignedBigInteger('section_id')->nullable();
            $table->unsignedBigInteger('status_id');
            $table->date('date_enrolled')->nullable();
            $table->string('semester')->nullable();
            $table->unsignedBigInteger('grade_id');
            $table->unsignedBigInteger('schedule_id')->nullable();
            $table->unsignedBigInteger('documents_id')->nullable();
            $table->unsignedBigInteger('attendance_report_id')->nullable();

            $table->timestamps();

            //FK constraints
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('grade_level_id')->references('grade_level_id')->on('grade_levels')->onDelete('cascade');
            $table->foreign('strand_id')->references('strand_id')->on('strands')->onDelete('set null');
            $table->foreign('section_id')->references('section_id')->on('sections')->onDelete('set null');
            $table->foreign('status_id')->references('student_status_id')->on('student_status')->onDelete('cascade');
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
        Schema::dropIfExists('students');
    }
};
