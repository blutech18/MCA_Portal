<?php

namespace App\Http\Controllers;

use App\Models\EnrollmentFee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminFeeController extends Controller
{
    public function index()
    {
        // Get current fees for all types
        $currentFees = [];
        $feeTypes = [
            EnrollmentFee::FEE_TYPE_NEW_JHS => 'New Student - JHS',
            EnrollmentFee::FEE_TYPE_NEW_SHS => 'New Student - SHS',
            EnrollmentFee::FEE_TYPE_OLD_JHS => 'Old Student - JHS',
            EnrollmentFee::FEE_TYPE_OLD_SHS => 'Old Student - SHS',
        ];

        foreach ($feeTypes as $type => $label) {
            $currentFees[$type] = [
                'label' => $label,
                'fee' => EnrollmentFee::getCurrentFee($type),
            ];
        }

        return view('admin.fees.index', compact('currentFees'));
    }

    public function updateFee(Request $request)
    {
        // Check if user is admin
        if (Auth::user()->user_type !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'fee_type' => 'required|in:new_jhs,new_shs,old_jhs,old_shs',
            'amount' => 'required|numeric|min:0',
            'effective_date' => 'required|date|after_or_equal:today',
        ]);

        try {
            // Get current fee for comparison
            $currentFee = EnrollmentFee::getCurrentFee($validated['fee_type']);
            $oldAmount = $currentFee ? $currentFee->amount : 0;

            // Create new fee entry
            $newFee = EnrollmentFee::create([
                'fee_type' => $validated['fee_type'],
                'amount' => $validated['amount'],
                'effective_date' => $validated['effective_date'],
                'created_by' => Auth::id(),
                'is_active' => true,
            ]);

            // Log the fee change
            Log::info('Enrollment fee updated', [
                'fee_type' => $validated['fee_type'],
                'old_amount' => $oldAmount,
                'new_amount' => $validated['amount'],
                'effective_date' => $validated['effective_date'],
                'updated_by' => Auth::id(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Enrollment fee updated successfully!',
                'fee' => [
                    'type' => $newFee->fee_type_label,
                    'amount' => $newFee->formatted_amount,
                    'effective_date' => $newFee->effective_date->format('M d, Y'),
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to update enrollment fee', [
                'fee_type' => $validated['fee_type'] ?? 'unknown',
                'error' => $e->getMessage(),
                'updated_by' => Auth::id(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update enrollment fee. Please try again.',
            ], 500);
        }
    }

    public function history()
    {
        $feeHistory = EnrollmentFee::with('creator')
            ->orderBy('fee_type')
            ->orderBy('effective_date', 'desc')
            ->get()
            ->groupBy('fee_type');

        return view('admin.fees.history', compact('feeHistory'));
    }

    public function getCurrentFees()
    {
        return response()->json([
            'success' => true,
            'fees' => EnrollmentFee::getAllCurrentFees()
        ]);
    }
}
