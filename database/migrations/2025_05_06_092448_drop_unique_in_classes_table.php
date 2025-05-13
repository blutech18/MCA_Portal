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
            $table->dropForeign(['section_id']);
            $table->dropUnique('classes_section_id_unique');
            // re-add the FK if you still want referential integrity
            $table->foreign('section_id')
                  ->references('id')
                  ->on('section')
                  ->onDelete('cascade');
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
