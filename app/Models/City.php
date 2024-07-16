<?php

namespace App\Models;

use App\Traits\ActiveScope;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class City extends BaseModel
{
    use  SoftDeletes, HasTranslations, ActiveScope;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'area_id',
        'is_active',
        'torod_city_id',
        'latitude',
        'longitude' ,
        'postcode',
        'spl_id', //unique
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * The attributes needs to be transelated.
     *
     * @var array
     */
    public $translatable = ['name'];

    /**
     * Get The area that belongs to this city.
     * @return BelongsTo
     */
    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class, "area_id");
    }


    public function scopeArea($query, $area_id)
    {
        return $query->where('area_id', $area_id);
    }

    public function domesticZoneMeta()
    {
        return $this->hasOne(DomesticZoneMeta::class, "related_model_id")
            ->where("related_model", self::class);
    }

    /**
     * @return HasMany
     */
    public function warehouses(): HasMany
    {
        return $this->hasMany(WarehouseCity::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(ServiceCity::class);
    }


    /**
     * @param $query
     * @return mixed
     */
    public function scopeActive($query): mixed
    {
        return $query->where('is_active', true);
    }

    public function addresses(): HasMany
    {
        return  $this->hasMany(Address::class);
    }
}
