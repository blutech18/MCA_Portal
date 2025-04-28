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
            // Only if you REALLY need to rename (case sensitivity)
            $table->renameColumn('Section_id', 'section_id');
        
            // Ensure it's nullable if using onDelete('set null')
            $table->unsignedBigInteger('section_id')->nullable()->change();
        
            // Add FK
            $table->foreign('section_id')->references('section_id')->on('sections')->onDelete('set null');
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
