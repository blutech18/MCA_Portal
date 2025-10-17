<?php

namespace Database\Seeders;

use App\Models\EnrollmentFee;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnrollmentFeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first admin user as the creator
        $admin = User::where('user_type', 'admin')->first();
        $createdBy = $admin ? $admin->user_id : 1;

        // Default enrollment fees
        $defaultFees = [
            [
                'fee_type' => EnrollmentFee::FEE_TYPE_NEW_JHS,
                'amount' => 5000.00,
                'effective_date' => now()->toDateString(),
                'created_by' => $createdBy,
                'is_active' => true,
            ],
            [
                'fee_type' => EnrollmentFee::FEE_TYPE_NEW_SHS,
                'amount' => 6000.00,
                'effective_date' => now()->toDateString(),
                'created_by' => $createdBy,
                'is_active' => true,
            ],
            [
                'fee_type' => EnrollmentFee::FEE_TYPE_OLD_JHS,
                'amount' => 4500.00,
                'effective_date' => now()->toDateString(),
                'created_by' => $createdBy,
                'is_active' => true,
            ],
            [
                'fee_type' => EnrollmentFee::FEE_TYPE_OLD_SHS,
                'amount' => 5500.00,
                'effective_date' => now()->toDateString(),
                'created_by' => $createdBy,
                'is_active' => true,
            ],
        ];

        foreach ($defaultFees as $fee) {
            EnrollmentFee::create($fee);
        }
    }
}
