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
        Schema::create('new_student_enrollees', function (Blueprint $table) {
            $table->id();
            $table->string('semester');
            $table->string('lrn')->nullable();
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('extension_name')->nullable();
            $table->date('dob');
            $table->string('gender');
            $table->string('pob');
            $table->string('address');
            $table->string('mobile');
            $table->string('email')->unique();
            $table->string('mother_name');
            $table->string('father_name');
            $table->string('guardian_name')->nullable();
            $table->string('relationship')->nullable();
            $table->string('guardian_contact')->nullable();
            $table->string('guardian_email')->nullable();
            $table->string('last_school');
            $table->string('school_address');
            $table->string('grade_completed');
            $table->string('sy_completed');
            $table->string('form138_path'); // for uploaded file
            $table->string('desired_grade');
            $table->string('preferred_strand')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('new_student_enrollees');
    }
};
