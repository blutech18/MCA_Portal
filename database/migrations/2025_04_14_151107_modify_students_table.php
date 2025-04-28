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
        Schema::table('students', function(Blueprint $table){
            $table->dropColumn('school_student_id');

            $table->unsignedBigInteger('student_school_id')->index();
            $table->foreign('student_school_id')->references('id')->on('student_id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
