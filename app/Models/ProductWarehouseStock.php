<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductWarehouseStock extends Model
{
    use HasFactory;

    protected $fillable = [
        "product_id",
        "warehouse_id",
        "stock",
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($model){
            $product = Product::query()->find($model->product_id);
            $product->stock = abs($product->stock - $model->stock);
            $product->save();
        });
    }

    public function product() : BelongsTo {
        return $this->belongsTo(Product::class, "product_id");
    }

    public function warehouse() : BelongsTo {
        return $this->belongsTo(Warehouse::class, "warehouse_id")->withDefault();
    }
    
    public function WarehouseShippingTypeDeliver()
    {
        return $this->hasOne(WarehouseShippingType::class ,'warehouse_id','warehouse_id')->where('shipping_type_id',2);
    }

    public function WarehouseShippingTypeReceive()
    {
        return $this->hasOne(WarehouseShippingType::class ,'warehouse_id','warehouse_id')->where('shipping_type_id',1);
    }

    public function scopeWarehouseId(Builder $query, int $warehouseId) : Builder {
        return $query->where("warehouse_id", $warehouseId);
    }

    public function scopeProductId(Builder $query, int $productId) : Builder {
        return $query->where("product_id", $productId);
    }
}
