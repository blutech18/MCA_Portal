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
        Schema::table('grades', function (Blueprint $table) {
            
            // Use the decimal type instead of unsignedDecimal
            $table->decimal('first_quarter', 5, 2)->nullable()->after('class_id');
            $table->decimal('second_quarter', 5, 2)->nullable()->after('first_quarter');
            $table->decimal('third_quarter', 5, 2)->nullable()->after('second_quarter');
            $table->decimal('fourth_quarter', 5, 2)->nullable()->after('third_quarter');
            $table->decimal('final_grade', 5, 2)->nullable()->after('fourth_quarter');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grades', function (Blueprint $table) {
            //
        });
    }
};
