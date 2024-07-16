<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrwayTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id", "transaction_id","cart_id", 'visa_amount', 'wallet_amount', "status", "urway_payment_id", "customer_ip","response", "reqCallback", "statusCallback"
    ];

    public function transaction() {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }
}
