<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderServiceFields extends Model
{
    use HasFactory;
    protected $fillable = ['key','value','type','price','transaction_id','service_id'];
    public function transaction() : BelongsTo
    {
        return $this->belongsTo(Transaction::class,'transaction_id');
    }
    public function service() : BelongsTo
    {
        return $this->belongsTo(Service::class,'service_id');
    }
}
