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
            // STEP 1
            $table->string('strand')->nullable();
            $table->string('semester')->nullable();
            // Profile
            $table->string('surname');
            $table->string('given_name');
            $table->string('middle_name');
            $table->string('lrn');
            $table->string('contact_no');
            $table->string('email')->nullable();
            $table->string('address');
            $table->string('living_with');
            $table->date('dob');
            $table->string('birthplace');
            $table->string('gender');
            $table->string('religion');
            $table->string('nationality');
            // Former School
            $table->string('former_school');
            $table->string('previous_grade');
            $table->string('last_school_year');
            $table->enum('school_type',['Private','Public','Homeschool']);
            $table->string('school_address');
            $table->string('reason_transfer');
            // SHS-only
            $table->boolean('working_student')->default(false);
            $table->boolean('intend_working_student')->default(false);
            $table->unsignedInteger('siblings')->nullable();
            $table->boolean('club_member')->default(false);
            $table->string('club_name')->nullable();
            // Family
            $table->string('father_name');
            $table->string('father_occupation');
            $table->string('father_contact_no');
            $table->string('father_email');
            $table->string('mother_name');
            $table->string('mother_occupation');
            $table->string('mother_contact_no');
            $table->string('mother_email');
            $table->string('guardian_name');
            $table->string('guardian_occupation');
            $table->string('guardian_contact_no');
            $table->string('guardian_email');
            // Medical
            $table->json('medical_history')->nullable();
            $table->string('allergy_specify')->nullable();
            $table->string('others_specify')->nullable();
            // Application
            $table->string('application_number')->unique()->nullable();
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
