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
        Schema::create('archived_attendance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('archived_student_id');
            $table->string('academic_year');
            $table->date('date');
            $table->enum('status', ['present', 'absent', 'late', 'excused']);
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('archived_attendance');
    }
};