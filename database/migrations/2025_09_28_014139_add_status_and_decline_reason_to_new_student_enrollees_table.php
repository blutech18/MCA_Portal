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
        Schema::table('new_student_enrollees', function (Blueprint $table) {
            $table->enum('status', ['pending', 'accepted', 'declined'])->default('pending')->after('id');
            $table->text('decline_reason')->nullable()->after('status');
            $table->timestamp('status_updated_at')->nullable()->after('decline_reason');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('new_student_enrollees', function (Blueprint $table) {
            $table->dropColumn(['status', 'decline_reason', 'status_updated_at']);
        });
    }
};