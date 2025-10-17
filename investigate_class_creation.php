<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use App\Models\Subject;
use App\Models\SchoolClass;
use App\Models\StudentSection;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Investigating Class Creation Issue ===\n\n";

// Check if there are default subjects
echo "1. CHECKING DEFAULT SUBJECTS:\n";
$defaultSubjects = Subject::where('is_default', true)->get();
echo "   Found " . $defaultSubjects->count() . " default subjects:\n";
foreach ($defaultSubjects as $subject) {
    echo "   - ID: " . $subject->id . ", Name: " . $subject->name . ", is_default: " . ($subject->is_default ? 'true' : 'false') . "\n";
}

echo "\n";

// Check all subjects
echo "2. CHECKING ALL SUBJECTS:\n";
$allSubjects = Subject::all();
echo "   Total subjects: " . $allSubjects->count() . "\n";
foreach ($allSubjects as $subject) {
    echo "   - ID: " . $subject->id . ", Name: " . $subject->name . ", is_default: " . ($subject->is_default ? 'true' : 'false') . "\n";
}

echo "\n";

// Check existing sections
echo "3. CHECKING EXISTING SECTIONS:\n";
$sections = StudentSection::with(['gradeLevel', 'strand'])->get();
echo "   Found " . $sections->count() . " sections:\n";
foreach ($sections as $section) {
    echo "   - ID: " . $section->id . ", Name: " . $section->section_name . ", Grade: " . ($section->gradeLevel->name ?? 'N/A') . ", Strand: " . ($section->strand->name ?? 'N/A') . "\n";
}

echo "\n";

// Check existing classes
echo "4. CHECKING EXISTING CLASSES:\n";
$classes = SchoolClass::with(['subject', 'section'])->get();
echo "   Found " . $classes->count() . " classes:\n";
foreach ($classes as $class) {
    echo "   - ID: " . $class->id . ", Name: " . $class->name . ", Subject: " . ($class->subject->name ?? 'N/A') . ", Section: " . ($class->section->section_name ?? 'N/A') . "\n";
}

echo "\n";

// Check recent logs for class creation
echo "5. CHECKING RECENT LOGS:\n";
$logFile = storage_path('logs/laravel.log');
if (file_exists($logFile)) {
    $logContent = file_get_contents($logFile);
    $lines = explode("\n", $logContent);
    $recentLines = array_slice($lines, -50); // Get last 50 lines
    
    $classCreationLogs = [];
    foreach ($recentLines as $line) {
        if (strpos($line, 'AUTO-CREATED CLASSES') !== false || strpos($line, 'createDefaultClassesForSection') !== false) {
            $classCreationLogs[] = $line;
        }
    }
    
    if (!empty($classCreationLogs)) {
        echo "   Recent class creation logs:\n";
        foreach ($classCreationLogs as $log) {
            echo "   " . $log . "\n";
        }
    } else {
        echo "   No recent class creation logs found.\n";
    }
} else {
    echo "   Log file not found.\n";
}

echo "\n=== Investigation Complete ===\n";
