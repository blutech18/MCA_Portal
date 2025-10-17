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
        Schema::create('section', function (Blueprint $table) {
            $table->id();
            $table->string('section_name');
            $table->integer('grade_level_id'); // 7-12
            $table->unsignedBigInteger('strand_id')->nullable(); // nullable for grades 7-10
            $table->timestamps();
            
            // Add indexes for better performance
            $table->index('grade_level_id');
            $table->index('strand_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section');
    }
};
