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
        Schema::table('classes', function (Blueprint $table) {
            // Add 'section_id' column if it doesn't exist
            if (!Schema::hasColumn('classes', 'section_id')) {
                $table->unsignedBigInteger('section_id')->nullable()->after('grade_level_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classes', function (Blueprint $table) {
            if (Schema::hasColumn('classes', 'section_id')) {
                $table->dropColumn('section_id');
            }
        });
    }
};