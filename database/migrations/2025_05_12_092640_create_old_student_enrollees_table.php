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
        Schema::create('old_student_enrollees', function (Blueprint $table) {
            $table->id();

            // Step 1: Pre-Registration
            $table->enum('semester', ['1st','2nd']);
            $table->string('surname');
            $table->string('given_name');
            $table->string('middle_name');
            $table->string('lrn');
            $table->string('student_id');
            $table->year('applying_year');

            // Terms acceptance (store as JSON of accepted keys)
            $table->json('terms_accepted');

            // Step 2: Payment
            $table->string('payment_applicant_name')->nullable();
            $table->string('payment_reference')->nullable();
            $table->string('payment_receipt_path')->nullable();
            $table->boolean('paid')->default(false);

            // Step 3: Clearances (e.g. proof of good standing, etc.)
            // adjust fields as needed
            $table->string('clearance_path')->nullable();

            // Step 4: Confirmation
            $table->string('application_number')->unique()->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('old_student_enrollees');
    }
};
