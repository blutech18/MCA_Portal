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
        Schema::table('old_student_enrollees', function (Blueprint $table) {
            $table->boolean('registrar_cleared')->default(false)->after('payment_verified_at');
            $table->boolean('accounting_cleared')->default(false)->after('registrar_cleared');
            $table->boolean('library_cleared')->default(false)->after('accounting_cleared');
            $table->boolean('discipline_cleared')->default(false)->after('library_cleared');
            $table->boolean('guidance_cleared')->default(false)->after('discipline_cleared');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('old_student_enrollees', function (Blueprint $table) {
            $table->dropColumn(['registrar_cleared', 'accounting_cleared', 'library_cleared', 'discipline_cleared', 'guidance_cleared']);
        });
    }
};
