<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('attendance')) {
            Schema::create('attendance', function (Blueprint $table) {
                $table->id('attendance_id');
                $table->unsignedBigInteger('instructor_class_id');
                $table->date('date');
                $table->timestamps();
                $table->index(['instructor_class_id', 'date']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance');
    }
};


