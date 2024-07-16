<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DomesticZoneDeliveryFees extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "domestic_zone_id",
        "weight_from",
        "weight_to",
        "delivery_fees",
    ];

    protected $hidden = [
        "deleted_at", "created_at", "updated_at"
    ];

    public function domesticZone() : BelongsTo {
        return $this->belongsTo(DomesticZone::class, "domestic_zone_id");
    }

    public function deliveryFees() : Attribute {
        return Attribute::make(
            get: fn($v) => $v / 100,
            set: fn($v) => $v * 100,
        );
    }

    public function deliveryFeesInHalala() : Attribute {
        return Attribute::make(
            get: fn() => $this->delivery_fees * 100,
        );
    }
}
