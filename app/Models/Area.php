<?php

namespace App\Models;

use App\Models\City;
use App\Models\Country;
use App\Traits\ActiveScope;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Area extends BaseModel
{
    use  SoftDeletes, HasTranslations, ActiveScope;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'country_id', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * The attributes needs to be transelated.
     *
     * @var array
     */
    public $translatable=['name'];

    /**
     * Get The Country that belongs to this area.
     * @return BelongsTo
     */
    public function country() : BelongsTo
    {
        return $this->belongsTo(Country::class, "country_id");
    }

    /**
     * Get collection of cities assossiated to this area.
     *
     * @return HasMany
     */
    public function cities() : HasMany
    {
        return $this->hasMany(City::class);
    }

    public function scopeCountry($query, $countryId)
    {
        return $query->where('country_id', $countryId);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeActive($query): mixed
    {
        return $query->where('is_active', true);
    }
}
