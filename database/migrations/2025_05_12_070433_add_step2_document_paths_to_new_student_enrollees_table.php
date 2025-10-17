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
            
            if (!in_array('report_card_path', $columnNames)) {
                $table->string('report_card_path')->nullable()->after('preferred_strand');
            }
            if (!in_array('good_moral_path', $columnNames)) {
                $table->string('good_moral_path')->nullable()->after('report_card_path');
            }
            if (!in_array('birth_certificate_path', $columnNames)) {
                $table->string('birth_certificate_path')->nullable()->after('good_moral_path');
            }
            if (!in_array('id_picture_path', $columnNames)) {
                $table->string('id_picture_path')->nullable()->after('birth_certificate_path');
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
