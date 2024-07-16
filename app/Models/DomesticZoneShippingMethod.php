<?php

namespace App\Models;
class DomesticZoneShippingMethod extends BaseModel
{
    protected $fillable = [
        "domestic_zone_id", "shipping_method_id"
    ];

    public function domesticZone() {
        return $this->belongsTo(DomesticZone::class, "domestic_zone_id");
    }

    public function shippingMethod() {
        return $this->belongsTo(ShippingMethod::class, "shipping_method_id");
    }
}
