<?php

namespace App\Models;

use App\Models\DomesticZone;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class TorodCompany extends BaseModel implements HasMedia
{
    use HasTranslations, SoftDeletes, InteractsWithMedia;

    /**
     * Media collection name that used to retreve logo from spati media library.
     */
    const LOGO_MEDIA_COLLECTION = "torodCompaniesLogos";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        "name",
        "desc",
        "active_status",
        "delivery_fees",
        "domestic_zone_id",
        "torod_courier_id"
    ];

    /**
     * Columns need to be translated.
     * 
     * @var array
     */
    public $translatable = ["name", "desc"];

    /**
     * Array Of Custom Attributes.
     *
     * @var array
     */
    public $appends = [
        "delivery_fees_with_sar",
        "is_has_logo",
        "logo_url"
    ];

    /**
     * Cast some data columns.
     *
     * @var array
     */
    public $casts = [
        "active_status" => "boolean"
    ];

    /**
     * Get domistic zone assossiated to this company.
     *
     * @return BelongsTo
     */
    public function domesticZone() : BelongsTo
    {
        return $this->belongsTo(DomesticZone::class, "domestic_zone_id", "id");
    }

    /**
     * Get the Totord Company delivery fees with SAR by convert the halal to rial.
     *
     * @return int
     */
    public function getDeliveryFeesWithSarAttribute() : int
    {
        return $this->delivery_fees / 100;
    }

    /**
     * Check if this Torod Company has logo.
     *
     * @return bool
     */
    public function getIsHasLogoAttribute() : bool
    {
        return $this->media->count() > 0 ?? true;
    }

    /**
     * Get the logo full url.
     *
     * @return string
     */
    public function getLogoUrlAttribute() : string
    {
        return $this->media->count() > 0 ? $this->media->first()->getFullUrl() : url("images/nologo.png");
    }

    /**
     * Interact with the Torod Company delivery fees.
     *
     * @return  \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function deliveryFees(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value * 100,
            get: fn ($value) => $value / 100
        );
    }

    /**
     * Active Torod Companies Count.
     *
     * @return self
     */
    public static function activeCompaniesCount()
    {
        return self::where('active_status', true)->count();
    }

    /**
     * Inctive Torod Companies Count.
     *
     * @return self
     */
    public static function inactiveCompaniesCount()
    {
        return self::where('active_status', false)->count();
    }
}
