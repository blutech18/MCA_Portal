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
        Schema::table('strand_assessment_results', function (Blueprint $table) {
            $table->unsignedBigInteger('academic_year_id')->nullable()->after('email');
            $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('set null');
            $table->index(['email', 'academic_year_id', 'completed_at'], 'sar_email_year_completed_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('strand_assessment_results', function (Blueprint $table) {
            $table->dropForeign(['academic_year_id']);
            $table->dropIndex('sar_email_year_completed_idx');
            $table->dropColumn('academic_year_id');
        });
    }
};