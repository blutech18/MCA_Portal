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
        Schema::create('strand_assessment_results', function (Blueprint $table) {
            $table->id();
            $table->string('email')->index();
            $table->string('recommended_strand'); // STEM, ABM, GAS, HUMSS, ICT, HE
            $table->json('scores'); // Stores all strand scores
            $table->integer('total_questions')->default(25);
            $table->timestamp('completed_at');
            $table->boolean('is_used')->default(false); // Tracks if used in enrollment
            $table->unsignedBigInteger('enrollment_id')->nullable(); // Foreign key to new_student_enrollees
            $table->timestamps();

            // Indexes for performance
            $table->index(['email', 'completed_at']);
            $table->foreign('enrollment_id')->references('id')->on('new_student_enrollees')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('strand_assessment_results');
    }
};