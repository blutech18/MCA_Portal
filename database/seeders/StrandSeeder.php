<?php

namespace Database\Seeders;

use App\Models\Strands;
use Illuminate\Database\Seeder;

class StrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $strands = [
            ['name' => 'STEM', 'no_of_sections' => 2],
            ['name' => 'ABM', 'no_of_sections' => 2],
            ['name' => 'HUMSS', 'no_of_sections' => 2],
            ['name' => 'GAS', 'no_of_sections' => 1],
            ['name' => 'TVL-ICT', 'no_of_sections' => 1],
            ['name' => 'TVL-HE', 'no_of_sections' => 1],
        ];

        foreach ($strands as $strand) {
            Strands::create($strand);
        }
    }
}