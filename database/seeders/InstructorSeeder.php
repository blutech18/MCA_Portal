<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Instructor;
use App\Models\InstructorId;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class InstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a new instructor account
        $instructorData = [
            'instructor_school_number' => 'INS-2024-001',
            'first_name' => 'Maria',
            'middle_name' => 'Santos',
            'last_name' => 'Garcia',
            'suffix' => '',
            'email' => 'maria.garcia@mcams.edu.ph',
            'gender' => 'female',
            'date_of_birth' => '1985-03-15',
            'contact_number' => '09123456789',
            'address' => '123 Main Street, Quezon City, Metro Manila',
            'job_start_date' => '2024-01-15',
            'status' => 'active'
        ];

        // Generate username and password
        $base = Str::lower(substr($instructorData['first_name'], 0, 1) . $instructorData['last_name']);
        $username = $base . rand(100, 999);
        
        // Ensure username is unique
        while (User::where('username', $username)->exists()) {
            $username = $base . rand(100, 999);
        }
        
        $passwordPlain = Str::lower($instructorData['last_name']) . date('Ymd', strtotime($instructorData['date_of_birth']));

        // Create or fetch school ID
        $idRecord = InstructorId::firstOrCreate([
            'instructor_number' => $instructorData['instructor_school_number']
        ]);

        // Check if instructor with this school ID already exists
        if (Instructor::where('instructor_school_id', $idRecord->id)->exists()) {
            $this->command->error('Instructor with school number ' . $instructorData['instructor_school_number'] . ' already exists.');
            return;
        }

        // Create User record
        $newUser = User::create([
            'username' => $username,
            'name' => "{$instructorData['first_name']} {$instructorData['last_name']}",
            'email' => $instructorData['email'],
            'user_type' => 'instructor',
            'password' => Hash::make($passwordPlain),
        ]);

        // Create Instructor record
        $newInstructor = Instructor::create([
            'user_id' => $newUser->user_id,
            'instructor_school_id' => $idRecord->id,
            'first_name' => $instructorData['first_name'],
            'middle_name' => $instructorData['middle_name'],
            'last_name' => $instructorData['last_name'],
            'suffix' => $instructorData['suffix'],
            'gender' => $instructorData['gender'],
            'date_of_birth' => $instructorData['date_of_birth'],
            'contact_number' => $instructorData['contact_number'],
            'email' => $instructorData['email'],
            'address' => $instructorData['address'],
            'job_start_date' => $instructorData['job_start_date'],
            'status' => $instructorData['status'],
        ]);

        $this->command->info('Instructor account created successfully!');
        $this->command->info('Username: ' . $username);
        $this->command->info('Password: ' . $passwordPlain);
        $this->command->info('Name: ' . $instructorData['first_name'] . ' ' . $instructorData['last_name']);
        $this->command->info('Email: ' . $instructorData['email']);
        $this->command->info('Instructor ID: ' . $instructorData['instructor_school_number']);
    }
}
