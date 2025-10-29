<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = [
            // Grade 7 (no strand)
            ['section_name' => '7 - Newton', 'grade_level_id' => 7, 'strand_id' => null, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 1, 'is_active' => true, 'is_full' => false],
            ['section_name' => '7 - Curie', 'grade_level_id' => 7, 'strand_id' => null, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 2, 'is_active' => true, 'is_full' => false],
            ['section_name' => '7 - Darwin', 'grade_level_id' => 7, 'strand_id' => null, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 3, 'is_active' => true, 'is_full' => false],

            // Grade 8 (no strand)
            ['section_name' => '8 - Einstein', 'grade_level_id' => 8, 'strand_id' => null, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 1, 'is_active' => true, 'is_full' => false],
            ['section_name' => '8 - Faraday', 'grade_level_id' => 8, 'strand_id' => null, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 2, 'is_active' => true, 'is_full' => false],
            ['section_name' => '8 - Pasteur', 'grade_level_id' => 8, 'strand_id' => null, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 3, 'is_active' => true, 'is_full' => false],

            // Grade 9 (no strand)
            ['section_name' => '9 - Galileo', 'grade_level_id' => 9, 'strand_id' => null, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 1, 'is_active' => true, 'is_full' => false],
            ['section_name' => '9 - Mendel', 'grade_level_id' => 9, 'strand_id' => null, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 2, 'is_active' => true, 'is_full' => false],
            ['section_name' => '9 - Tesla', 'grade_level_id' => 9, 'strand_id' => null, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 3, 'is_active' => true, 'is_full' => false],

            // Grade 10 (no strand)
            ['section_name' => '10 - Hawking', 'grade_level_id' => 10, 'strand_id' => null, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 1, 'is_active' => true, 'is_full' => false],
            ['section_name' => '10 - Rosalind', 'grade_level_id' => 10, 'strand_id' => null, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 2, 'is_active' => true, 'is_full' => false],
            ['section_name' => '10 - Edison', 'grade_level_id' => 10, 'strand_id' => null, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 3, 'is_active' => true, 'is_full' => false],

            // Grade 11 - STEM Strand
            ['section_name' => '11 - Daisy', 'grade_level_id' => 11, 'strand_id' => 1, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 1, 'is_active' => true, 'is_full' => false],
            ['section_name' => '11 - Iris', 'grade_level_id' => 11, 'strand_id' => 1, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 2, 'is_active' => true, 'is_full' => false],
            ['section_name' => '11 - Orchid', 'grade_level_id' => 11, 'strand_id' => 1, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 3, 'is_active' => true, 'is_full' => false],

            // Grade 12 - STEM Strand
            ['section_name' => '12 - Sunflower', 'grade_level_id' => 12, 'strand_id' => 1, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 1, 'is_active' => true, 'is_full' => false],
            ['section_name' => '12 - Magnolia', 'grade_level_id' => 12, 'strand_id' => 1, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 2, 'is_active' => true, 'is_full' => false],
            ['section_name' => '12 - Lily', 'grade_level_id' => 12, 'strand_id' => 1, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 3, 'is_active' => true, 'is_full' => false],

            // Grade 11 - ABM Strand
            ['section_name' => '11 - Tulip', 'grade_level_id' => 11, 'strand_id' => 2, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 1, 'is_active' => true, 'is_full' => false],
            ['section_name' => '11 - Camellia', 'grade_level_id' => 11, 'strand_id' => 2, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 2, 'is_active' => true, 'is_full' => false],
            ['section_name' => '11 - Peony', 'grade_level_id' => 11, 'strand_id' => 2, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 3, 'is_active' => true, 'is_full' => false],

            // Grade 12 - ABM Strand
            ['section_name' => '12 - Rose', 'grade_level_id' => 12, 'strand_id' => 2, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 1, 'is_active' => true, 'is_full' => false],
            ['section_name' => '12 - Marigold', 'grade_level_id' => 12, 'strand_id' => 2, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 2, 'is_active' => true, 'is_full' => false],
            ['section_name' => '12 - Dahlia', 'grade_level_id' => 12, 'strand_id' => 2, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 3, 'is_active' => true, 'is_full' => false],

            // Grade 11 - HUMSS Strand
            ['section_name' => '11 - Jasmine', 'grade_level_id' => 11, 'strand_id' => 3, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 1, 'is_active' => true, 'is_full' => false],
            ['section_name' => '11 - Azalea', 'grade_level_id' => 11, 'strand_id' => 3, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 2, 'is_active' => true, 'is_full' => false],
            ['section_name' => '11 - Gardenia', 'grade_level_id' => 11, 'strand_id' => 3, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 3, 'is_active' => true, 'is_full' => false],

            // Grade 12 - HUMSS Strand
            ['section_name' => '12 - Lavender', 'grade_level_id' => 12, 'strand_id' => 3, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 1, 'is_active' => true, 'is_full' => false],
            ['section_name' => '12 - Chrysanthemum', 'grade_level_id' => 12, 'strand_id' => 3, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 2, 'is_active' => true, 'is_full' => false],
            ['section_name' => '12 - Hibiscus', 'grade_level_id' => 12, 'strand_id' => 3, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 3, 'is_active' => true, 'is_full' => false],

            // Grade 11 - TVL Strand
            ['section_name' => '11 - Carnation', 'grade_level_id' => 11, 'strand_id' => 4, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 1, 'is_active' => true, 'is_full' => false],
            ['section_name' => '11 - Zinnia', 'grade_level_id' => 11, 'strand_id' => 4, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 2, 'is_active' => true, 'is_full' => false],
            ['section_name' => '11 - Poppy', 'grade_level_id' => 11, 'strand_id' => 4, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 3, 'is_active' => true, 'is_full' => false],

            // Grade 12 - GAS Strand
            ['section_name' => '12 - Lotus', 'grade_level_id' => 12, 'strand_id' => 4, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 1, 'is_active' => true, 'is_full' => false],
            ['section_name' => '12 - Aster', 'grade_level_id' => 12, 'strand_id' => 4, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 2, 'is_active' => true, 'is_full' => false],
            ['section_name' => '12 - Bluebell', 'grade_level_id' => 12, 'strand_id' => 4, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 3, 'is_active' => true, 'is_full' => false],

            // Grade 11 - ICT Strand (TVL-ICT, strand_id = 5)
            ['section_name' => '11 – Del Pilar', 'grade_level_id' => 11, 'strand_id' => 5, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 1, 'is_active' => true, 'is_full' => false],
            ['section_name' => '11 – Bonifacio', 'grade_level_id' => 11, 'strand_id' => 5, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 2, 'is_active' => true, 'is_full' => false],
            ['section_name' => '11 – Luna', 'grade_level_id' => 11, 'strand_id' => 5, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 3, 'is_active' => true, 'is_full' => false],

            // Grade 12 - ICT Strand (TVL-ICT, strand_id = 5)
            ['section_name' => '12 – Rizal', 'grade_level_id' => 12, 'strand_id' => 5, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 1, 'is_active' => true, 'is_full' => false],
            ['section_name' => '12 – Jacinto', 'grade_level_id' => 12, 'strand_id' => 5, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 2, 'is_active' => true, 'is_full' => false],
            ['section_name' => '12 – Mabini', 'grade_level_id' => 12, 'strand_id' => 5, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 3, 'is_active' => true, 'is_full' => false],

            // Grade 11 - HE Strand (TVL-HE, strand_id = 6)
            ['section_name' => '11 – Aguinaldo', 'grade_level_id' => 11, 'strand_id' => 6, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 1, 'is_active' => true, 'is_full' => false],
            ['section_name' => '11 – Melchora', 'grade_level_id' => 11, 'strand_id' => 6, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 2, 'is_active' => true, 'is_full' => false],
            ['section_name' => '11 – Pardo', 'grade_level_id' => 11, 'strand_id' => 6, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 3, 'is_active' => true, 'is_full' => false],

            // Grade 12 - HE Strand (TVL-HE, strand_id = 6)
            ['section_name' => '12 – Gabriela', 'grade_level_id' => 12, 'strand_id' => 6, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 1, 'is_active' => true, 'is_full' => false],
            ['section_name' => '12 – Gregoria', 'grade_level_id' => 12, 'strand_id' => 6, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 2, 'is_active' => true, 'is_full' => false],
            ['section_name' => '12 – Teresa', 'grade_level_id' => 12, 'strand_id' => 6, 'max_capacity' => 25, 'current_count' => 0, 'section_priority' => 3, 'is_active' => true, 'is_full' => false],
        ];

        foreach ($sections as $section) {
            DB::table('section')->insert(array_merge($section, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        echo "Sections seeded successfully!\n";
    }
}
