<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        "product_id",
        "country_id",
        "vat_percentage",
        "vat_rate_in_halala",
        "price_without_vat_in_halala",
        "price_with_vat_in_halala",
        'price_before_offer_in_halala'
    ];

    public function priceInSar() : Attribute {
        return Attribute::make(
            get: fn () => $this->price_with_vat_in_halala / 100,
        );
    }
    public function priceBeforeInSar() : Attribute {
        return Attribute::make(
            get: fn () => $this->price_before_offer_in_halala ? $this->price_before_offer_in_halala / 100 : null,
        );
    }

    public function priceBeforeInSarRounded() : Attribute {
        return Attribute::make(
            get: fn() => number_format($this->price_before_in_sar, 2)
        );
    }

    public function priceInSarRounded() : Attribute {
        return Attribute::make(
            get: fn() => number_format($this->price_in_sar, 2)
        );
    }

    public function country() : HasOne {
        return $this->hasOne(Country::class,'id','country_id');
    }

    public function product() : BelongsTo {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function setCountryIdAttribute() {
        $this->attributes['country_id'] = 1;
    }
}
