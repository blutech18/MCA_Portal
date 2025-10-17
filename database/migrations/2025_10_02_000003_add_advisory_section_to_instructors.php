<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('instructors') && !Schema::hasColumn('instructors', 'advisory_section_id')) {
            Schema::table('instructors', function (Blueprint $table) {
                $table->unsignedBigInteger('advisory_section_id')->nullable()->after('status');
                
                // Add foreign key if section table exists
                if (Schema::hasTable('section')) {
                    try {
                        $table->foreign('advisory_section_id')
                              ->references('id')
                              ->on('section')
                              ->onDelete('set null');
                    } catch (\Throwable $e) {
                        // Ignore if FK already exists
                    }
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('instructors') && Schema::hasColumn('instructors', 'advisory_section_id')) {
            Schema::table('instructors', function (Blueprint $table) {
                try {
                    $table->dropForeign(['advisory_section_id']);
                } catch (\Throwable $e) {
                    // Ignore if FK doesn't exist
                }
                $table->dropColumn('advisory_section_id');
            });
        }
    }
};

