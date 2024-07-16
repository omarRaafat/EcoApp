<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'first_name', 'last_name', 'description', 'type', 'is_default', 'country_id', 'area_id',
        'city_id', 'phone', 'is_international', 'international_city'
    ];

    public function user()
    {
        return $this->belongsTo(Client::class,'user_id');
    }

    public function country(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Country::class,'id','country_id')->withTrashed();
    }

    public function area(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Area::class,'id','area_id')->withTrashed();
    }

    public function city(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(City::class,'id','city_id')->withTrashed();
    }

    public function scopeDefault(Builder $query) : Builder {
        return $query->where("is_default", true);
    }

    public function scopeCountryByCode(Builder $query, string $code) : Builder {
        return $query->whereHas("country", fn($c) => $c->code($code));
    }
}
