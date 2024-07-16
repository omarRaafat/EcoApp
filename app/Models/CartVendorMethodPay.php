<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartVendorMethodPay extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "cart_id",'vendor_id','wallet_id','amount','visa_amount'
    ];

}
