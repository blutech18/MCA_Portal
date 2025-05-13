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
            $table->string('report_card_path')->nullable()->after('others_specify');
            $table->string('good_moral_path')->nullable()->after('report_card_path');
            $table->string('birth_certificate_path')->nullable()->after('good_moral_path');
            $table->string('id_picture_path')->nullable()->after('birth_certificate_path');
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
