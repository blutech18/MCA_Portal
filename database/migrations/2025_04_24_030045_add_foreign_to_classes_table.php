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
            $table->foreign('section_id')
            ->references('id')
            ->on('section')
            ->onDelete('cascade');

      // 2) Make section_id unique
      //    If you also have a class_id in that table
      //    and want each (class, section) only once, use:
      //      $table->unique(['class_id','section_id']);
            $table->unique('section_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classes', function (Blueprint $table) {
            //
        });
    }
};
