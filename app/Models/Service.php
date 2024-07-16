<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use App\Observers\ServiceObserver;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Scopes\ServiceCountryScope;
use App\Traits\UploadImageTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Service extends BaseModel implements HasMedia
{
    use HasTranslations,SoftDeletes, InteractsWithMedia, UploadImageTrait;

    const mediaCollectionName = "Services";
    const mediaTempCollectionName = "ServicesTemp";
    const clearanceCertTempCollectionName = "clearanceCertTemp";
    const clearanceCertCollectionName = "clearanceCert";

    protected $fillable = [
        'vendor_id',
        'category_id',
        'name',
        'desc',
        'conditions',
        'is_active',
        'is_visible',
        'status',
        'image'
    ];

    public $translatable = ['name' ,'desc','conditions'];

    protected $with = ['vendor'];

    public function fields()
    {
        return $this->hasMany(ServiceField::class);
    }

    public function category()
    {
        return $this->belongsTo(PostHarvestServicesDepartment::class,'category_id');
    }

    public function note()
    {
        return $this->hasOne(ServiceNote::class,'service_id')->latest()->withDefault();
    }

    public function scopeAvailable($query)
    {
        return $query
            ->where('is_active', 1)
            ->where('is_visible',1)
            ->where('status','accepted')
            ->whereHas('vendor', fn($q) => $q->available());

    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name->ar','like','%'.trim($search).'%')->orWhere('name->en','like','%'.trim($search).'%');
    }

    public function scopeAccepted($query)
    {
        return $query->where('status','accepted');
    }

    public function images()
    {
        return $this->hasMany(ServiceImage::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class,'vendor_id');
    }
    public function reviews()
    {
        return $this->hasMany(ServiceReview::class,'service_id');
    }

    public function orderServices()
    {
        return $this->hasMany(OrderServiceDetail::class,'service_id');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('assquare-medium')->format(Manipulations::FORMAT_WEBP)
        ->fit(Manipulations::FIT_MAX, 640, 640)
        ->crop('crop-center',640,640)
        ->nonQueued();

        $this->addMediaConversion('assquare-small')->format(Manipulations::FORMAT_WEBP)
        ->fit(Manipulations::FIT_MAX, 250, 250)
        ->crop('crop-center',250,250)
        ->nonQueued();
    }

    public function squareImage() : Attribute {
        return Attribute::make(
            get: fn($value) =>
                $this?->media?->first() ?
                    $this->getFirstMediaUrl(self::mediaCollectionName, 'assquare-medium')
                    :
                    ($this->image ? ossStorageUrl($this->image) : url("images/noimage-tumb.png"))
        );
    }

    public function thumbImage() : Attribute {
        // TODO: must be refactored when handle image conversions
        return Attribute::make(
            get: fn($v) => url($this->image)
        );
    }

    public function isAvailableService() : Attribute {
        return Attribute::make(
            get: fn() => $this->is_visible == 1 && $this->is_active == 1 && $this->status == 'accepted' &&  $this->vendor->is_available_vendor
        );
    }

    public function isNotAvailableService() : Attribute {
        return Attribute::make(
            get: fn() => !$this->is_available_service
        );
    }

    public function squareImageTemp() : Attribute {
        return Attribute::make(
            get: fn($value) =>
                $this?->media?->first() ? $this->getFirstMediaUrl(self::mediaTempCollectionName, 'assquare-medium') : null
        );
    }

    public function updateTempForSquareimage(){
        if( ($this->square_image_temp && $this->square_image_temp != $this->square_image)
            &&
            (!$this->temp || $this->temp?->approval != 'pending')
        ){
            $this->clearMediaCollection(Service::mediaCollectionName);
            Media::where(['model_id' => $this->id , 'model_type'=>'App\Models\Service', 'collection_name' => Service::mediaTempCollectionName])->update(['collection_name' => Service::mediaCollectionName]);
            $this->clearMediaCollection(Service::mediaTempCollectionName);
        };

        if($this->square_image_temp){
            return $this->square_image_temp;
        }

        return $this->square_image;
    }

    public function temp()
    {
        return $this->hasOne(ServiceTemp::class,'service_id')->latest();
    }

    public function serviceTemp() : HasOne
    {
        return $this->hasOne(ServiceTemp::class, 'service_id', 'id');
    }

    public function squareImageSmall() : Attribute {
        return Attribute::make(
            get: fn($value) =>
                $this?->media?->first() ?
                    $this->getFirstMediaUrl(self::mediaCollectionName, 'assquare-small')
                    :
                    ($this->image ? ossStorageUrl($this->image) : url("images/noimage-tumb.png"))
        );
    }

    public function favorites()
    {
        return $this->hasMany(FavoriteService::class, 'service_id');
    }

    public function calculateTotalPrice()
    {
        $fields = $this->fields; // Access the relationship

        if ($fields->isEmpty()) {
            return 0;
        }

        $dropdownFieldPrice = $fields->where('field_type', 'dropdown-list')
        ->groupBy('field_name')
        ->map(function ($group) {
            return $group->min('field_price');
        })
        ->sum();

        // Sum the prices of the fields that are not dropdowns
        $fieldsPrice = $fields->where('field_type', '!=', 'dropdown-list')->sum('field_price');

        return round(($dropdownFieldPrice + $fieldsPrice), 2);
    }

    public function calculateTotalPriceWithoutDropDown()
    {
        $fields = $this->fields; // Access the relationship

        if ($fields->isEmpty()) {
            return 0;
        }

        // Sum the prices of the fields that are not dropdowns
        $fieldsPrice = $fields->where('field_type', '!=', 'dropdown-list')->sum('field_price');

        return round($fieldsPrice, 2);
    }

    public function cities()
    {
        return $this->belongsToMany(City::class, 'service_cities', 'service_id', 'city_id');
    }

    public function approvedReviews()
    {
        return $this->hasMany(ServiceReview::class,'service_id')->approved();
    }
}
