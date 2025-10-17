<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradeLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gradeLevels = [
            ['grade_level_id' => 7, 'name' => 'Grade 7'],
            ['grade_level_id' => 8, 'name' => 'Grade 8'],
            ['grade_level_id' => 9, 'name' => 'Grade 9'],
            ['grade_level_id' => 10, 'name' => 'Grade 10'],
            ['grade_level_id' => 11, 'name' => 'Grade 11'],
            ['grade_level_id' => 12, 'name' => 'Grade 12'],
        ];

        foreach ($gradeLevels as $gradeLevel) {
            DB::table('grade_level')->insert(array_merge($gradeLevel, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        echo "Grade levels seeded successfully!\n";
    }
}
