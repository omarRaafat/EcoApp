<?php

namespace App\Models;
class TransactionLog extends BaseModel
{
    protected $fillable=['old_status','new_status','user_id','transaction_id'];
}
