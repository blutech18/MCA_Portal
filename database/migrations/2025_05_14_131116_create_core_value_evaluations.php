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
        if (!Schema::hasTable('core_value_evaluations')) {
            Schema::create('core_value_evaluations', function (Blueprint $table) {
             $table->id();
            $table->foreignId('student_id')->constrained('students','student_id')->cascadeOnDelete();
            $table->foreignId('core_value_id')->constrained('core_values')->cascadeOnDelete();
           $table->decimal('score', 5, 2)->unsigned();
            $table->timestamps();

            $table->unique(['student_id','core_value_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('core_value_evaluations');
    }
};
