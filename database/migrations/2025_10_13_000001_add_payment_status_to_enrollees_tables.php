<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // New student enrollees
        Schema::table('new_student_enrollees', function (Blueprint $table) {
            if (!Schema::hasColumn('new_student_enrollees', 'payment_status')) {
                $table->string('payment_status')->default('Pending Verification')->after('paid');
            }
            if (!Schema::hasColumn('new_student_enrollees', 'payment_status_changed_at')) {
                $table->timestamp('payment_status_changed_at')->nullable()->after('payment_status');
            }
            if (!Schema::hasColumn('new_student_enrollees', 'payment_status_changed_by')) {
                $table->string('payment_status_changed_by')->nullable()->after('payment_status_changed_at');
            }
        });

        // Old student enrollees
        Schema::table('old_student_enrollees', function (Blueprint $table) {
            if (!Schema::hasColumn('old_student_enrollees', 'payment_status')) {
                $table->string('payment_status')->default('Pending Verification')->after('paid');
            }
            if (!Schema::hasColumn('old_student_enrollees', 'payment_status_changed_at')) {
                $table->timestamp('payment_status_changed_at')->nullable()->after('payment_status');
            }
            if (!Schema::hasColumn('old_student_enrollees', 'payment_status_changed_by')) {
                $table->string('payment_status_changed_by')->nullable()->after('payment_status_changed_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('new_student_enrollees', function (Blueprint $table) {
            if (Schema::hasColumn('new_student_enrollees', 'payment_status')) {
                $table->dropColumn('payment_status');
            }
            if (Schema::hasColumn('new_student_enrollees', 'payment_status_changed_at')) {
                $table->dropColumn('payment_status_changed_at');
            }
            if (Schema::hasColumn('new_student_enrollees', 'payment_status_changed_by')) {
                $table->dropColumn('payment_status_changed_by');
            }
        });

        Schema::table('old_student_enrollees', function (Blueprint $table) {
            if (Schema::hasColumn('old_student_enrollees', 'payment_status')) {
                $table->dropColumn('payment_status');
            }
            if (Schema::hasColumn('old_student_enrollees', 'payment_status_changed_at')) {
                $table->dropColumn('payment_status_changed_at');
            }
            if (Schema::hasColumn('old_student_enrollees', 'payment_status_changed_by')) {
                $table->dropColumn('payment_status_changed_by');
            }
        });
    }
};


