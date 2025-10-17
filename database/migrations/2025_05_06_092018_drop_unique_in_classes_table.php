<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('classes', function (Blueprint $table) {
            // Check if foreign key exists before dropping
            $foreignKeys = DB::select("SELECT CONSTRAINT_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE TABLE_NAME = 'classes' AND COLUMN_NAME = 'section_id' AND CONSTRAINT_NAME LIKE '%foreign%'");
            if (!empty($foreignKeys)) {
                $table->dropForeign(['section_id']);
            }
            
            // Check if unique index exists before dropping
            $uniqueKeys = DB::select("SELECT CONSTRAINT_NAME FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS WHERE TABLE_NAME = 'classes' AND CONSTRAINT_NAME = 'classes_section_id_unique'");
            if (!empty($uniqueKeys)) {
                $table->dropUnique('classes_section_id_unique');
            }
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
