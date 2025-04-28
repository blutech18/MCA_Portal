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
        Schema::create('instructors', function (Blueprint $table) {
            $table->id('instructor_id');

            // Foreign key to users table (assuming users.user_id is the PK)
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');

            // Foreign key to instructor_ids table
            $table->foreignId('instructor_school_id')->constrained('instructor_ids', 'id')->onDelete('cascade');

            // Personal details
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('suffix')->nullable();
            $table->string('picture')->nullable(); // Use BLOB if storing binary
            $table->enum('gender', ['male', 'female', 'other']);
            $table->date('date_of_birth')->nullable();

            // Contact & job details
            $table->string('contact_number')->nullable();
            $table->string('email')->unique();
            $table->string('address')->nullable();
            $table->date('job_start_date')->nullable();
            $table->enum('status', ['active', 'on leave', 'retired', 'terminated'])->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instructors');
    }
};
