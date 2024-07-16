<?php

namespace App\Models;

class OnlinePayment extends BaseModel
{
    protected $fillable = [
        'customer_id', 'amount', 'currency', 'payment_method', 'payment_id', 'transaction_id', 'cart_id'
    ];

    public function transaction() {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }
}
