<?php

namespace App\Models;

use App\Traits\UploadImageTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\UploadedFile;
use Spatie\Translatable\HasTranslations;

class ShippingMethod extends BaseModel
{
    use HasTranslations, UploadImageTrait;

    protected $fillable = [
        "name", "logo", "integration_key", "cod_collect_fees", "type",'is_active'
    ];

    public $casts = [
        'name' => 'json',
        'is_active' => "boolean"
    ];
    public $translatable = ['name'];

    public function transactions() : HasMany {
        return $this->hasMany(Transaction::class, "shipping_method_id");
    }

    public function logo() : Attribute {
        return Attribute::make(
            get: fn($v) => $v ? url($v) : url("images/noimage.png")
        );
    }

    public function SetLogoAttribute($logo) {
        if ($logo instanceof UploadedFile) {
            return $this->attributes['logo'] = self::moveFileToPublic($logo, "shipping-methods/logos");
        }
        return $this->attributes['logo'] = $logo;
    }

    public function codCollectFees() : Attribute {
        return Attribute::make(
            get: fn($v) => $v ? $v / 100 : null,
            set: fn($v) => $v ? $v * 100 : null,
        );
    }

    public function codCollectFeesInhalala() : Attribute {
        return Attribute::make(
            get: fn() => $this->cod_collect_fees * 100,
        );
    }

    public function domesticZoneShippingMethod() {
        return $this->hasMany(DomesticZoneShippingMethod::class, 'shipping_method_id');
    }

    public function domesticZones() {
        return $this->belongsToMany(
            DomesticZone::class,
            'domestic_zone_shipping_methods',
            'shipping_method_id',
            'domestic_zone_id'
        );
    }

    public function scopeActive($query){
        $query->where('is_active',1);
    }

}
