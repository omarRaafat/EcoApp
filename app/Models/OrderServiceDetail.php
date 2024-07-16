<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderServiceDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_service_id',
        'service_id',
        'total',
        'quantity',
        'unit_price',
        'vat_percentage',
        'discount'
    ];
    public function orderService() : BelongsTo
    {
        return $this->belongsTo(OrderService::class,'order_service_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
