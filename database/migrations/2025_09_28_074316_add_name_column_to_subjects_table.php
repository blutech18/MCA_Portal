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
            // Add 'name' column if it doesn't exist
            if (!Schema::hasColumn('subjects', 'name')) {
                $table->string('name')->after('id');
            }
            
            // Add 'code' column if it doesn't exist
            if (!Schema::hasColumn('subjects', 'code')) {
                $table->string('code')->unique()->after('name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            if (Schema::hasColumn('subjects', 'name')) {
                $table->dropColumn('name');
            }
            if (Schema::hasColumn('subjects', 'code')) {
                $table->dropColumn('code');
            }
        });
    }
};