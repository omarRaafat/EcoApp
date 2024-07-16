<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;

class VendorWallet extends BaseModel
{
    protected $fillable = [
        'vendor_id', 'balance'
    ];

    public function vendor() {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function transactions() {
        return $this->hasMany(VendorWalletTransaction::class, 'wallet_id');
    }

    public function balanceInSar() : Attribute {
        return Attribute::make(
            get: fn () => $this->balance / 100,
        );
    }

    public function pendingTransactionAmount()
    {
        return $this->transactions()
            ->where('operation_type', 'in')
            ->where('status', 'pending')
            ->sum('amount');
    }

    public function completedTransactionAmount()
    {
        $inAmount = $this->getCompletedTransactionAmountByOperation('in');
        $outAmount = $this->getCompletedTransactionAmountByOperation('out');

        return round($inAmount - $outAmount, 3);
    }

    public function getCompletedTransactionAmountByOperation($operationType)
    {
        return $this->transactions()
            ->where('operation_type', $operationType)
            ->where('status', 'completed')
            ->sum('amount');
    }
}
