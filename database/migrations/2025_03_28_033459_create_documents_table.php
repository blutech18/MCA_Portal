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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // foreign key to users table
            $table->string('document_type');       // e.g., "Form 138", "PSA"
            $table->enum('submitted', ['yes', 'no'])->default('no');
            $table->enum('submitted_online', ['yes', 'no'])->default('no');
            $table->enum('submitted_face_to_face', ['yes', 'no'])->default('no');
            $table->string('document_file')->nullable(); // file path for uploaded file
            $table->timestamps();

            // Optionally add a foreign key constraint if needed:
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
