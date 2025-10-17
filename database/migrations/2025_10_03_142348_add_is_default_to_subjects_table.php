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
        Schema::table('subjects', function (Blueprint $table) {
            $table->boolean('is_default')->default(false)->after('code');
        });

        // Mark existing core subjects as default
        DB::table('subjects')->whereIn('name', ['Mathematics', 'English', 'Science', 'Filipino', 'Social Studies'])
            ->update(['is_default' => true]);

        // Add missing core subjects
        $coreSubjects = [
            ['name' => 'Araling Panlipunan', 'code' => 'AP-101', 'subject' => 'Araling Panlipunan', 'is_default' => true],
            ['name' => 'MAPEH', 'code' => 'MAPEH-101', 'subject' => 'MAPEH', 'is_default' => true],
            ['name' => 'TLE', 'code' => 'TLE-101', 'subject' => 'TLE', 'is_default' => true],
        ];

        foreach ($coreSubjects as $subject) {
            DB::table('subjects')->insert(array_merge($subject, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropColumn('is_default');
        });

        // Remove the added core subjects
        DB::table('subjects')->whereIn('name', ['Araling Panlipunan', 'MAPEH', 'TLE'])->delete();
    }
};