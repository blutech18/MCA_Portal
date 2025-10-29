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
        Schema::table('strands', function (Blueprint $table) {
            if (!Schema::hasColumn('strands', 'capacity')) {
                $table->unsignedInteger('capacity')->default(40)->after('no_of_sections');
            }
            if (!Schema::hasColumn('strands', 'enrolled_count')) {
                $table->unsignedInteger('enrolled_count')->default(0)->after('capacity');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('strands', function (Blueprint $table) {
            if (Schema::hasColumn('strands', 'enrolled_count')) {
                $table->dropColumn('enrolled_count');
            }
            if (Schema::hasColumn('strands', 'capacity')) {
                $table->dropColumn('capacity');
            }
        });
    }
};


