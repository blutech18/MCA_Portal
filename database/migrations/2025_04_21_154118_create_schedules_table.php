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
        Schema::create('schedules', function (Blueprint $table) {
            // This makes "schedule_id" instead of "id"
            $table->id('schedule_id');  

            // now you can safely refer AFTER schedule_id
            $table->foreignId('instructor_class_id')
                ->constrained('instructor_classes', 'id')
                ->cascadeOnDelete();

            $table->enum('day_of_week', [
                'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'
            ]);
            $table->time('start_time');
            $table->time('end_time');
            $table->string('room')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
