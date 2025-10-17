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
        Schema::table('section', function (Blueprint $table) {
            // Add capacity management fields
            $table->integer('max_capacity')->default(25)->after('strand_id');
            $table->integer('current_count')->default(0)->after('max_capacity');
            $table->integer('section_priority')->default(1)->after('current_count');
            $table->boolean('is_active')->default(true)->after('section_priority');
            $table->boolean('is_full')->default(false)->after('is_active');
            $table->timestamp('section_filled_at')->nullable()->after('is_full');
            
            // Add indexes for performance
            $table->index('section_priority');
            $table->index('is_active');
            $table->index('is_full');
            $table->index(['grade_level_id', 'strand_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('section', function (Blueprint $table) {
            $table->dropIndex(['section_priority']);
            $table->dropIndex(['is_active']);
            $table->dropIndex(['is_full']);
            $table->dropIndex(['grade_level_id', 'strand_id', 'is_active']);
            
            $table->dropColumn([
                'max_capacity',
                'current_count',
                'section_priority',
                'is_active',
                'is_full',
                'section_filled_at'
            ]);
        });
    }
};
