<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

try {
    DB::beginTransaction();

    $students = \App\Models\Student::whereNull('user_id')->get();
    echo "Students to backfill: " . $students->count() . "\n";

    foreach ($students as $student) {
        $baseUsername = Str::slug(($student->first_name ?: 'student') . '.' . ($student->last_name ?: $student->school_student_id), '.');
        $username = $baseUsername;
        $counter = 1;
        while (\App\Models\User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        $email = $student->email ?: ($username . '@noemail.local');
        // Ensure unique email
        if (\App\Models\User::where('email', $email)->exists()) {
            $email = $username . '+'.uniqid().'@noemail.local';
        }

        $user = \App\Models\User::create([
            'name' => trim(($student->first_name ?? '') . ' ' . ($student->last_name ?? '')),
            'username' => $username,
            'email' => $email,
            'password' => 'Password123!@#', // hashed by model casts
            'user_type' => 'student',
        ]);

        $student->update(['user_id' => $user->user_id]);
        echo "Linked student ID {$student->student_id} to user {$user->user_id} ({$username})\n";
    }

    DB::commit();
    echo "Backfill completed successfully.\n";
} catch (Exception $e) {
    DB::rollBack();
    echo "Error: " . $e->getMessage() . "\n";
}
