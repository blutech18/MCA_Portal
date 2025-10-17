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
        Schema::create('archive_logs', function (Blueprint $table) {
            $table->id();
            $table->string('academic_year');
            $table->string('action'); // 'archive_year', 'restore_student', 'export_data'
            $table->integer('students_count')->nullable();
            $table->unsignedBigInteger('performed_by'); // admin user_id
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('academic_year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archive_logs');
    }
};