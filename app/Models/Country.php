<?php

namespace App\Models;

use App\Enums\CustomHeaders;
use App\Models\Area;
use App\Models\City;
use App\Observers\CountryObserver;
use App\Traits\ActiveScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Country extends BaseModel
{
    use SoftDeletes, HasTranslations, ActiveScope;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'code', 'flag', 'is_active', 'vat_percentage', 'is_national',
        'spl_id', // This id used by spl shipping integration, to refer to the country on their backend.
        'minimum_order_weight',
        'maximum_order_weight',
        'maximum_order_total',
    ];

    public $translatable = ['name'];

    protected static function boot() {
        parent::boot();
        self::observe(CountryObserver::class);
    }

    /**
     * Get list of areas assossiated to this country.
     * @return HasMany
     */
    public function areas() : HasMany
    {
        return $this->hasMany(Area::class);
    }

    public function countryPrices() : HasMany
    {
        return $this->hasMany(ProductPrice::class,'country_id');
    }

    public function warehouseCountry() : BelongsTo {
        return $this->belongsTo(WarehouseCountry::class, "id", "country_id");
    }

    public function domesticZoneMeta() : HasOne {
        return $this->hasOne(DomesticZoneMeta::class, "related_model_id")
            ->where("related_model", self::class);
    }

    public function cities() : HasManyThrough
    {
        return $this->hasManyThrough(
            City::class,
            Area::class,
            'country_id',
            'area_id',
            'id',
            'id'
        );
    }

    public function domesticZones() : BelongsToMany {
        return $this->belongsToMany(
            DomesticZone::class,
            'domestic_zone_metas',
            'related_model_id',
            'domestic_zone_id',
        )->wherePivot("related_model", Country::class);
    }

    public function scopeNational(Builder $query) : Builder {
        return $query->where("is_national", true);
    }

    public function scopeInternational(Builder $query) : Builder {
        return $query->where("is_national", false);
    }

    public function scopeCode(Builder $query, string $code) : Builder {
        return $query->where("code", $code);
    }

    public function warehouse() : BelongsToMany {
        return $this->belongsToMany(
            Warehouse::class,
            'warehouse_countries',
            'country_id',
            'warehouse_id',
        );
    }

    public function minimumOrderWeight() : Attribute {
        return Attribute::make(
            get: fn ($v) => $v ? $v / 100 : null,
            set: fn($v) => $v ? $v * 100 : null,
        );
    }

    public function maximumOrderWeight() : Attribute {
        return Attribute::make(
            get: fn ($v) => $v ? $v / 100 : null,
            set: fn($v) => $v ? $v * 100 : null,
        );
    }

    public function maximumOrderTotal() : Attribute {
        return Attribute::make(
            get: fn ($v) => $v ? $v / 100 : null,
            set: fn ($v) => $v ? $v * 100 : null,
        );
    }

    public static function getHeaderCountryCode() : string {
        return request()->hasHeader(CustomHeaders::COUNTRY_CODE) ?
            request()->header(CustomHeaders::COUNTRY_CODE) :
            (self::national()->first()->code ?? "");
    }
}
