<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EnrollmentFee extends Model
{
    protected $fillable = [
        'fee_type',
        'amount',
        'effective_date',
        'created_by',
        'is_active'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'effective_date' => 'date',
        'is_active' => 'boolean'
    ];

    // Fee type constants
    const FEE_TYPE_NEW_JHS = 'new_jhs';
    const FEE_TYPE_NEW_SHS = 'new_shs';
    const FEE_TYPE_OLD_JHS = 'old_jhs';
    const FEE_TYPE_OLD_SHS = 'old_shs';

    // Relationship with User (admin who created the fee)
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }

    // Get fee type label
    public function getFeeTypeLabelAttribute(): string
    {
        return match($this->fee_type) {
            self::FEE_TYPE_NEW_JHS => 'New Student - JHS',
            self::FEE_TYPE_NEW_SHS => 'New Student - SHS',
            self::FEE_TYPE_OLD_JHS => 'Old Student - JHS',
            self::FEE_TYPE_OLD_SHS => 'Old Student - SHS',
            default => 'Unknown'
        };
    }

    // Get formatted amount
    public function getFormattedAmountAttribute(): string
    {
        return '₱' . number_format($this->amount, 2);
    }

    // Scope for active fees
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for current fees (active and effective today or earlier)
    public function scopeCurrent($query)
    {
        return $query->active()->where('effective_date', '<=', now()->toDateString());
    }

    // Get current fee for a specific type
    public static function getCurrentFee(string $feeType): ?self
    {
        return self::current()
            ->where('fee_type', $feeType)
            ->orderBy('effective_date', 'desc')
            ->first();
    }

    // Get all current fees as array
    public static function getAllCurrentFees(): array
    {
        $fees = [];
        foreach ([self::FEE_TYPE_NEW_JHS, self::FEE_TYPE_NEW_SHS, self::FEE_TYPE_OLD_JHS, self::FEE_TYPE_OLD_SHS] as $type) {
            $fee = self::getCurrentFee($type);
            $fees[$type] = $fee ? $fee->amount : 0;
        }
        return $fees;
    }
}
