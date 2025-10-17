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
        Schema::table('new_student_enrollees', function (Blueprint $table) {
            $table->integer('shs_grade')->nullable()->after('strand');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('new_student_enrollees', function (Blueprint $table) {
            $table->dropColumn('shs_grade');
        });
    }
};
