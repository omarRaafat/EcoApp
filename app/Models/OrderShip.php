<?php

namespace App\Models;

use App\Enums\ShippingMethodKeys;
use App\Enums\ShippingMethods;
use App\Models\Order;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderShip extends BaseModel
{

    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        "reference_model",
        "reference_model_id",
        "gateway_order_id",
        "gateway_tracking_id",
        "gateway_tracking_url",
        "extra_data",
        "is_out_of_stock",
        "warehouse_tracking_id",
        'status'
    ];

    /**
     * Return the Transaction belongs to this OrderShip.
     *
     * @return BelongsTo
     */
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, "reference_model_id", "id");
    }

    /**
     * Return the Order belongs to this OrderShip.
     *
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, "reference_model_id");
    }

    public function shipTrackingUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                return match (ShippingMethodKeys::convertKeyToId($this->transaction?->shippingMethod?->integration_key)) {
                    ShippingMethods::BEZZ => config("shipping.bezz.tracking_url") . $this->gateway_tracking_id,
                    ShippingMethods::SPL => config("shipping.spl.tracking_url") . $this->gateway_tracking_id,
                    default => '',
                };
            }
        );
    }

    public function waybillUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                return match (ShippingMethodKeys::convertKeyToId($this->transaction?->shippingMethod?->integration_key)) {
                    ShippingMethods::SPL => $this->gateway_tracking_url,
                    default => '',
                };
            }
        );
    }

    public function warehouseTrackingUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                return match (ShippingMethodKeys::convertKeyToId($this->transaction?->shippingMethod?->integration_key)) {
                    ShippingMethods::SPL => config("shipping.bezz.tracking_url") . $this->transaction?->warehouseShippingRequest?->tracking_id,
                    default => '',
                };
            }
        );
    }
}
