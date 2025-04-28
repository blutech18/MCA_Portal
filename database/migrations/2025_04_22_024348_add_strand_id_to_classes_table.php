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
    Schema::table('classes', function (Blueprint $table) {
        $table->unsignedBigInteger('strand_id')->nullable()->after('grade_level_id');

        $table->foreign('strand_id')->references('id')->on('strands')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('classes', function (Blueprint $table) {
        $table->dropForeign(['strand_id']);
        $table->dropColumn('strand_id');
    });
}

};
