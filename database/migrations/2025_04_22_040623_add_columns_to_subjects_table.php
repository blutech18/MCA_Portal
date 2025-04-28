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
        Schema::table('subjects', function (Blueprint $table) {
            Schema::table('subjects', function (Blueprint $table) {
                // Add 'name' and 'code' columns
                $table->string('name')->after('id');  // Add a 'name' column (string type)
                $table->string('code')->after('name');  // Add a 'code' column (string type)
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            //
        });
    }
};
