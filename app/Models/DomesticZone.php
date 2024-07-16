<?php

namespace App\Models;

use App\Enums\DomesticZone as EnumsDomesticZone;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class DomesticZone extends BaseModel
{
    use HasTranslations, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'type', 'delivery_fees', 'additional_kilo_price', 'delivery_fees_covered_kilos',
        'days_from', 'days_to', 'fuelprice'
    ];

    /**
     * The attributes needs to be transelated.
     *
     * @var array
     */
    public $translatable =[
        'name'
    ];

    // public function deliveryFees() : Attribute {
    //     return Attribute::make(
    //         get: fn($v) => $v ? $v / 100 : null,
    //     );
    // }

    // public function deliveryFeesInHalala() : Attribute {
    //     return Attribute::make(
    //         get: fn() => $this->delivery_fees * 100,
    //     );
    // }

    // public function additionalKiloPrice() : Attribute {
    //     return Attribute::make(
    //         get: fn($v) => $v ? $v / 100 : null,
    //         set: fn($v) => $v ? $v * 100 : null,
    //     );
    // }

    public function domesticZoneMeta() : HasMany{
        return $this->hasMany(DomesticZoneMeta::class, 'domestic_zone_id');
    }

    public function cities() : BelongsToMany {
        return $this->belongsToMany(
            City::class,
            'domestic_zone_metas',
            'domestic_zone_id',
            'related_model_id',
        )
        ->wherePivot("related_model", City::class)
        ->wherePivotNull("deleted_at");
    }

    public function countries() : BelongsToMany {
        return $this->belongsToMany(
            Country::class,
            'domestic_zone_metas',
            'domestic_zone_id',
            'related_model_id',
        )
        ->wherePivot("related_model", Country::class)
        ->wherePivotNull("deleted_at");
    }

    public function scopeType(Builder $query, string $type) : Builder {
        return $query->when(
            $type == EnumsDomesticZone::NATIONAL_TYPE,
            fn($q) => $q->where('type', EnumsDomesticZone::NATIONAL_TYPE)
        )
        ->when(
            $type == EnumsDomesticZone::INTERNATIONAL_TYPE,
            fn($q) => $q->where('type', EnumsDomesticZone::INTERNATIONAL_TYPE)
        );
    }

    public function shippingMethods() : BelongsToMany {
        return $this->belongsToMany(
            ShippingMethod::class,
            'domestic_zone_shipping_methods',
            'domestic_zone_id',
            'shipping_method_id',
        );
    }

    public function deliveryFeeses() : HasMany {
        return $this->hasMany(DomesticZoneDeliveryFees::class, "domestic_zone_id");
    }
}
