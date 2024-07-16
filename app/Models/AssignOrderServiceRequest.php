<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
class AssignOrderServiceRequest extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['order_service_id','created_by','assign_by'];
    public function orderService() : BelongsTo
    {
        return $this->belongsTo(OrderService::class,'order_service_id');
    }
    public function createdBy() : BelongsTo
    {
        return $this->belongsTo(User::class,'created_by');
    }
    public function assignBy() : BelongsTo
    {
        return $this->belongsTo(User::class,'assign_by');
    }
}
