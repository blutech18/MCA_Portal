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
        Schema::table('student_ids', function (Blueprint $table) {
            $table->unique('student_number');
        });
    }

    public function down(): void
    {
        Schema::table('student_ids', function (Blueprint $table) {
            $table->dropUnique(['student_number']);
        });
    }

};
