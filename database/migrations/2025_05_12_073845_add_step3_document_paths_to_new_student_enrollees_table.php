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
            //
            $table->string('payment_applicant_name')
                  ->nullable()
                  ->after('id_picture_path');

            // the payment reference number
            $table->string('payment_reference')
                  ->nullable()
                  ->after('payment_applicant_name');

            // where we’ll store the uploaded receipt
            $table->string('payment_receipt_path')
                  ->nullable()
                  ->after('payment_reference');

            // optional: mark that payment step has been completed
            $table->boolean('paid')
                  ->default(false)
                  ->after('payment_receipt_path');
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
