<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        
    


        // Rename the primary key column from 'id' to 'user_id'
        // (This uses a raw SQL statement; it works with MySQL)
        DB::statement("ALTER TABLE users CHANGE id user_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rename 'user_id' back to 'id'
        DB::statement("ALTER TABLE users CHANGE user_id id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT");

        // Drop the 'username' column
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
        });

        // Re-add the 'email' column as unique
        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->unique()->after('id');
        });
    }
};
