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
        Schema::create('archived_grades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('archived_student_id');
            $table->string('academic_year');
            $table->unsignedBigInteger('subject_id');
            $table->string('subject_name');
            $table->string('subject_code')->nullable();
            $table->decimal('first_quarter', 5, 2)->nullable();
            $table->decimal('second_quarter', 5, 2)->nullable();
            $table->decimal('third_quarter', 5, 2)->nullable();
            $table->decimal('fourth_quarter', 5, 2)->nullable();
            $table->decimal('final_grade', 5, 2)->nullable();
            $table->timestamps();
            
            $table->foreign('archived_student_id')->references('id')->on('archived_students')->onDelete('cascade');
            $table->index(['archived_student_id', 'academic_year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archived_grades');
    }
};