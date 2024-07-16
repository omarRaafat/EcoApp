<?php
namespace App\Models;

class TransactionWarning extends BaseModel
{
    protected $fillable = [
        'message', 'reference_id', 'reference_type', 'transaction_id', 'code', 'title'
    ];

}
