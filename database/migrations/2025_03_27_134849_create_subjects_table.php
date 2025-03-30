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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            // Optionally, if you want to relate subjects to a user:
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('subject');
            $table->string('day');         // e.g., "Monday", "Tuesday", etc.
            $table->time('time');          // Time of the subject
            $table->string('teacher');
            $table->string('image')->nullable();  // Path or URL to an image
            $table->timestamps();

            // If you want to enforce relationship with users table:
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
