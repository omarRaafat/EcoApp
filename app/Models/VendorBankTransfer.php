<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendorBankTransfer extends Model
{
    use HasFactory;

    protected $table = 'vendor_bank_transfers';

    protected $fillable = ['currency_id' , 'FTRefNum' , 'AmtDebitedAmount' , 'AmtCreditedAmount' , 'CurrBal' , 'vendor_id' , 'type' , 'status' , 'request_id' ];

    /**
     * @return BelongsTo
     */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo("\App\Models\Vendor" , 'vendor_id');
    }
}
