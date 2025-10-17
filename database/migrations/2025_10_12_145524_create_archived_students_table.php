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
        Schema::create('archived_students', function (Blueprint $table) {
            $table->id();
            $table->string('academic_year'); // e.g., "2024-2025"
            $table->unsignedBigInteger('original_student_id'); // Reference to students table
            
            // Student Personal Information (snapshot)
            $table->string('school_student_id');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('suffix')->nullable();
            $table->string('lrn')->nullable();
            $table->string('email')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('address')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            
            // Academic Information (snapshot)
            $table->integer('grade_level_id');
            $table->string('grade_level_name');
            $table->unsignedBigInteger('section_id')->nullable();
            $table->string('section_name')->nullable();
            $table->unsignedBigInteger('strand_id')->nullable();
            $table->string('strand_name')->nullable();
            $table->string('status')->nullable();
            $table->date('date_enrolled')->nullable();
            
            // Archive Metadata
            $table->timestamp('archived_at');
            $table->unsignedBigInteger('archived_by'); // admin user_id
            $table->timestamps();
            
            // Indexes
            $table->index('academic_year');
            $table->index('original_student_id');
            $table->index(['academic_year', 'grade_level_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archived_students');
    }
};