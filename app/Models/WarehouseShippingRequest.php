<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Warehouse;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WarehouseShippingRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        "reference_model",
        "reference_model_id",
        "warehouse_id",
        "tracking_id",
        "tracking_url"
    ];

    /**
     * Return the Transaction belongs to this Warehouse Shipping Request.
     */
    public function transaction() : BelongsTo
    {
        return $this->belongsTo(Transaction::class, "reference_model_id", "id");
    }

    /**
     * Return the Order belongs to this Warehouse Shipping Request.
     */
    public function order() : BelongsTo
    {
        return $this->belongsTo(Order::class, "reference_model_id");
    }

    /**
     * Return the warehouse belongs to this Warehouse Shipping Request.
     */
    public function warehouse() : BelongsTo
    {
        return $this->belongsTo(Warehouse::class, "warehouse_id");
    }
}
