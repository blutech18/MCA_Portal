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
        // Update strands table to reflect correct number of sections
        DB::table('strands')->where('name', 'TVL-ICT')->update(['no_of_sections' => 6]);
        DB::table('strands')->where('name', 'TVL-HE')->update(['no_of_sections' => 6]);

        // Check if sections already exist before inserting
        $ictSections = [
            // Grade 11 - ICT Strand
            ['section_name' => '11 – Del Pilar', 'grade_level_id' => 11, 'strand_id' => 5, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 1, 'is_active' => true, 'is_full' => false, 'created_at' => now(), 'updated_at' => now()],
            ['section_name' => '11 – Bonifacio', 'grade_level_id' => 11, 'strand_id' => 5, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 2, 'is_active' => true, 'is_full' => false, 'created_at' => now(), 'updated_at' => now()],
            ['section_name' => '11 – Luna', 'grade_level_id' => 11, 'strand_id' => 5, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 3, 'is_active' => true, 'is_full' => false, 'created_at' => now(), 'updated_at' => now()],
            
            // Grade 12 - ICT Strand
            ['section_name' => '12 – Rizal', 'grade_level_id' => 12, 'strand_id' => 5, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 1, 'is_active' => true, 'is_full' => false, 'created_at' => now(), 'updated_at' => now()],
            ['section_name' => '12 – Jacinto', 'grade_level_id' => 12, 'strand_id' => 5, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 2, 'is_active' => true, 'is_full' => false, 'created_at' => now(), 'updated_at' => now()],
            ['section_name' => '12 – Mabini', 'grade_level_id' => 12, 'strand_id' => 5, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 3, 'is_active' => true, 'is_full' => false, 'created_at' => now(), 'updated_at' => now()],
        ];

        $heSections = [
            // Grade 11 - HE Strand
            ['section_name' => '11 – Aguinaldo', 'grade_level_id' => 11, 'strand_id' => 6, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 1, 'is_active' => true, 'is_full' => false, 'created_at' => now(), 'updated_at' => now()],
            ['section_name' => '11 – Melchora', 'grade_level_id' => 11, 'strand_id' => 6, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 2, 'is_active' => true, 'is_full' => false, 'created_at' => now(), 'updated_at' => now()],
            ['section_name' => '11 – Pardo', 'grade_level_id' => 11, 'strand_id' => 6, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 3, 'is_active' => true, 'is_full' => false, 'created_at' => now(), 'updated_at' => now()],
            
            // Grade 12 - HE Strand
            ['section_name' => '12 – Gabriela', 'grade_level_id' => 12, 'strand_id' => 6, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 1, 'is_active' => true, 'is_full' => false, 'created_at' => now(), 'updated_at' => now()],
            ['section_name' => '12 – Gregoria', 'grade_level_id' => 12, 'strand_id' => 6, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 2, 'is_active' => true, 'is_full' => false, 'created_at' => now(), 'updated_at' => now()],
            ['section_name' => '12 – Teresa', 'grade_level_id' => 12, 'strand_id' => 6, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 3, 'is_active' => true, 'is_full' => false, 'created_at' => now(), 'updated_at' => now()],
        ];

        // Insert ICT sections if they don't exist
        foreach ($ictSections as $section) {
            $exists = DB::table('section')
                ->where('section_name', $section['section_name'])
                ->where('grade_level_id', $section['grade_level_id'])
                ->where('strand_id', $section['strand_id'])
                ->exists();
            
            if (!$exists) {
                DB::table('section')->insert($section);
            }
        }

        // Insert HE sections if they don't exist
        foreach ($heSections as $section) {
            $exists = DB::table('section')
                ->where('section_name', $section['section_name'])
                ->where('grade_level_id', $section['grade_level_id'])
                ->where('strand_id', $section['strand_id'])
                ->exists();
            
            if (!$exists) {
                DB::table('section')->insert($section);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Delete ICT sections
        DB::table('section')
            ->where('strand_id', 5)
            ->whereIn('section_name', [
                '11 – Del Pilar',
                '11 – Bonifacio',
                '11 – Luna',
                '12 – Rizal',
                '12 – Jacinto',
                '12 – Mabini'
            ])
            ->delete();

        // Delete HE sections
        DB::table('section')
            ->where('strand_id', 6)
            ->whereIn('section_name', [
                '11 – Aguinaldo',
                '11 – Melchora',
                '11 – Pardo',
                '12 – Gabriela',
                '12 – Gregoria',
                '12 – Teresa'
            ])
            ->delete();

        // Revert strand section counts
        DB::table('strands')->where('name', 'TVL-ICT')->update(['no_of_sections' => 1]);
        DB::table('strands')->where('name', 'TVL-HE')->update(['no_of_sections' => 1]);
    }
};
