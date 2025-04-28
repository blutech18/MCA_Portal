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
        Schema::table('students', function (Blueprint $table) {
            // First, drop the existing foreign key and column (if it exists)
            $table->dropForeign(['Section_id']); // use the original name here
            $table->dropColumn('Section_id');
        });
        
        Schema::table('students', function (Blueprint $table) {
            // Now, re-add it with lowercase name and FK constraint
            $table->unsignedBigInteger('section_id')->nullable();
        
            $table->foreign('section_id')
                  ->references('section_id')
                  ->on('sections')
                  ->onDelete('set null');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
