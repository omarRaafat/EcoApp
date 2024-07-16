<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WarehouseShippingType extends Model
{
    use HasFactory;

    protected $table = 'warehouse_shipping_types';

    protected $fillable = ['warehouse_id' , 'shipping_type_id'];

    /**
     * @return BelongsTo
     */
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class , 'warehouse_id');
    }

    public function shippingType(): BelongsTo
    {
        return $this->belongsTo(ShippingType::class , 'shipping_type_id');
    }

}
