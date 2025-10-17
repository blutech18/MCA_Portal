<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('grades')) {
            Schema::table('grades', function (Blueprint $table) {
                if (!Schema::hasColumn('grades', 'class_id')) {
                    $table->unsignedBigInteger('class_id')->nullable()->after('student_id');
                }
                if (!Schema::hasColumn('grades', 'subject_id')) {
                    $table->unsignedBigInteger('subject_id')->nullable()->after('class_id');
                }
            });

            Schema::table('grades', function (Blueprint $table) {
                // Add FKs if possible
                if (Schema::hasTable('classes') && Schema::hasColumn('grades', 'class_id')) {
                    try {
                        $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
                    } catch (\Throwable $e) {
                        // ignore if FK already exists
                    }
                }
                if (Schema::hasTable('subjects') && Schema::hasColumn('grades', 'subject_id')) {
                    try {
                        $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
                    } catch (\Throwable $e) {
                        // ignore if FK already exists
                    }
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('grades')) {
            Schema::table('grades', function (Blueprint $table) {
                try { $table->dropForeign(['class_id']); } catch (\Throwable $e) {}
                try { $table->dropForeign(['subject_id']); } catch (\Throwable $e) {}
                if (Schema::hasColumn('grades', 'subject_id')) { $table->dropColumn('subject_id'); }
                if (Schema::hasColumn('grades', 'class_id')) { $table->dropColumn('class_id'); }
            });
        }
    }
};


