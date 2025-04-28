<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            // Modify the existing school_student_id column
            $table->unsignedBigInteger('school_student_id')->change();

            // Add the foreign key constraint
            $table->foreign('school_student_id')
                  ->references('id')->on('student_id')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            // Drop the foreign key constraint and column type change
            $table->dropForeign(['school_student_id']);
            $table->bigInteger('school_student_id')->change();
        });
    }
};
