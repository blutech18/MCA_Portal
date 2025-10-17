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
        Schema::table('new_student_enrollees', function (Blueprint $table) {
            // Check if columns exist before adding them
            $columns = DB::select("SHOW COLUMNS FROM new_student_enrollees");
            $columnNames = array_column($columns, 'Field');
            
            if (!in_array('payment_applicant_name', $columnNames)) {
                $table->string('payment_applicant_name')->nullable()->after('id_picture_path');
            }
            if (!in_array('payment_reference', $columnNames)) {
                $table->string('payment_reference')->nullable()->after('payment_applicant_name');
            }
            if (!in_array('payment_receipt_path', $columnNames)) {
                $table->string('payment_receipt_path')->nullable()->after('payment_reference');
            }
            if (!in_array('paid', $columnNames)) {
                $table->boolean('paid')->default(false)->after('payment_receipt_path');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('new_student_enrollees', function (Blueprint $table) {
            //
        });
    }
};
