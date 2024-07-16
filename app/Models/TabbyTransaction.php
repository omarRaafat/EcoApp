<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabbyTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id", "transaction_id","cart_id", 'visa_amount', 'wallet_amount', "status", "tabby_payment_id", "customer_ip","response", "reqCallback", "statusCallback", "amountCallback", "payUuid"
    ];

    public function transaction() {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }
}
