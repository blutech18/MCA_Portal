<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StrandSeederUpdated extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $strands = [
            ['id' => 1, 'name' => 'STEM', 'no_of_sections' => 6],
            ['id' => 2, 'name' => 'ABM', 'no_of_sections' => 6],
            ['id' => 3, 'name' => 'HUMSS', 'no_of_sections' => 6],
            ['id' => 4, 'name' => 'GAS', 'no_of_sections' => 6],
            ['id' => 5, 'name' => 'TVL-ICT', 'no_of_sections' => 6],
            ['id' => 6, 'name' => 'TVL-HE', 'no_of_sections' => 6],
        ];

        foreach ($strands as $strand) {
            DB::table('strands')->updateOrInsert(
                ['id' => $strand['id']], // Match condition
                array_merge($strand, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }

        echo "Strands seeded successfully!\n";
    }
}
