<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use App\Observers\ProductObserver;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Scopes\ProductCountryScope;
use App\Traits\UploadImageTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends BaseModel implements HasMedia
{
    use HasTranslations,SoftDeletes, InteractsWithMedia, UploadImageTrait;

    const mediaCollectionName = "Products";
    const mediaTempCollectionName = "ProductsTemp";
    const clearanceCertTempCollectionName = "clearanceCertTemp";
    const clearanceCertCollectionName = "clearanceCert";
    
    
    

    protected $fillable = [
        'name', 'desc', 'image', 'is_active', 'status', 'total_weight', 'net_weight', 'barcode',
        'length', 'width', 'height', 'price', 'price_before_offer', 'order', 'expire_date',
        'quantity_bill_count', 'bill_weight', 'category_id', 'quantity_type_id', 'type_id',
        'is_visible', 'vendor_id', 'product_class_id', 'sku', 'sub_category_id' ,'final_category_id',
        'stock', 'hs_code' , 'no_receive_from_vendor' , 'no_sells','clearance_cert'
    ];

    public $translatable = ['name' ,'desc'];

    protected static function boot()
    {

        parent::boot();
        self::observe(ProductObserver::class);
        return static::addGlobalScope(new ProductCountryScope);


    }

    protected $with = ['vendor','productClass','quantity_type'];

    public function scopeAvailable($query)
    {
        return $query
            ->where('is_active', 1)
            ->where('is_visible',1)
            ->where('status','accepted')
            ->where('stock', ">", 0)
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

    public function scopeHasStock(Builder $query, int $qnt) : Builder
    {
        return $query->where('stock', ">=", $qnt);
    }
   
    public function priceInSar() : Attribute {
        return Attribute::make(
            get: fn () => $this->price ,
        );
    }

    public function priceBeforeOfferInSar() : Attribute {
        return Attribute::make(
            get: fn () => $this->price_before_offer ? $this->price_before_offer : null,
        );
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(Category::class,'sub_category_id');
    }

    public function finalSubCategory()
    {
        return $this->belongsTo(Category::class,'final_category_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class,'vendor_id');
    }

    public function quantity_type()
    {
        return $this->belongsTo(ProductQuantity::class,'quantity_type_id');
    }

    public function type()
    {
        return $this->belongsTo(ProductClass::class,'type_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class,'product_id');
    }
    public function temp()
    {
        return $this->hasOne(ProductTemp::class,'product_id')->latest();
    }
    public function note()
    {
        return $this->hasOne(ProductNote::class,'product_id')->latest()->withDefault();
    }

    public function approvedReviews()
    {
        return $this->hasMany(Review::class,'product_id')->approved();
    }



    public function rate()
    {
        $count=$this->reviews()->count();
        $rate=($count)?$this->reviews()->sum('rate')/$count:0;
        return round($rate,1);
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class,'product_id');
    }

    /**
     * Get the prodcut class.
     *
     * @return BelongsTo
     */
    public function productClass() : BelongsTo
    {
        return $this->belongsTo(ProductClass::class, 'product_class_id', 'id');
    }
    /**
     * Get the prodcut temp.
     *
     * @return HasOne
     */
    public function productTemp() : HasOne
    {
        return $this->hasOne(ProductTemp::class, 'product_id', 'id');
    }

    /**
     * Get List Of all this product assossiations in any Vendor Warehouse Request Products.
     *
     * @return HasMany
     */
    public function whereHouseRequestItems() : HasMany
    {
        return $this->hasMany(VendorWarehouseRequestProduct::class);
    }

    /**
     * @return HasMany
     */
    public function warehouseStock() : HasMany
    {
        return $this->hasMany(ProductWarehouseStock::class, "product_id");
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

    //صورة  منتج جديدة لكن في انتظار موافقة الإدارة
    public function squareImageTemp() : Attribute {
        return Attribute::make(
            get: fn($value) =>
                $this?->media?->first() ? $this->getFirstMediaUrl(self::mediaTempCollectionName, 'assquare-medium') : null
        );
    }

    //شهادة فسح للمنتج  منتج جديدة لكن في انتظار موافقة الإدارة
    public function clearanceCertMediaTemp() : Attribute {
        return Attribute::make(
            get: fn($value) =>
                $this?->media?->first() ? $this->getFirstMediaUrl(self::clearanceCertTempCollectionName) : null
        );
    }

    //شهادة فسح للمنتج  منتج 
    public function clearanceCertMedia() : Attribute {
        return Attribute::make(
            get: fn($value) =>
                $this?->media?->first() ? $this->getFirstMediaUrl(self::clearanceCertCollectionName) : ""
        );
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

    public function thumbImage() : Attribute {
        // TODO: must be refactored when handle image conversions
        return Attribute::make(
            get: fn($v) => url($this->image)
        );
    }

    public function isRatedBy($user)
    {
        return $this->reviews()->where('user_id',$user->id)->count() ? 1:0 ;
    }

    public function isImageNotConvertable() : Attribute {
        return Attribute::make(
            get: fn($value) =>
                Str::contains($this->image, "png", true) ||
                Str::contains($this->image, "gif", true) ||
                Str::contains($this->image, "webp", true)
        );
    }

    /*
     * Scope to retun all product by Kilo
     * */
    public function totalWeightLabel() : Attribute {
        return Attribute::make(
            get: fn($value) => $this->total_weight < 1000 ?
                $this->total_weight .' '. __('translation.gram') :
                $this->total_weight / 1000 .' '. __('translation.kilo')
        );
    }

    public function totalWeightByKilo() : Attribute {
        return Attribute::make(
            get: fn($value) => $this->total_weight / 1000
        );
    }

    /*
     * Scope to retun all product by Kilo
     * */
    public function netWeightLabel() : Attribute {
        return Attribute::make(
            get: fn($value) => $this->net_weight < 1000 ?
                $this->net_weight .' '. __('translation.gram') :
                $this->net_weight / 1000 .' '. __('translation.kilo')
        );
    }

    public function isAvailableProduct() : Attribute {
        return Attribute::make(
            get: fn() => $this->is_visible == 1 && $this->is_active == 1 && $this->status == 'accepted' && $this->stock > 0 && $this->vendor->is_available_vendor
        );
    }

    public function isNotAvailableProduct() : Attribute {
        return Attribute::make(
            get: fn() => !$this->is_available_product
        );
    }

    public function prices() {
        return $this->hasMany(ProductPrice::class, 'product_id');
    }

    public function countriesInternationalPrices() {
        return $this->belongsToMany(Country::class, 'product_prices')->withPivot(
        'product_id',
        'country_id',
        'vat_percentage',
        'vat_rate_in_halala',
        'price_without_vat_in_halala',
        'price_with_vat_in_halala',
        'price_before'
        )->withTimestamps();
    }

    public function productSales() : HasOne {
        return $this->hasOne(ProductSales::class, "product_id", "id");
    }

    /**
     * Price In Sar Rounded function
     *
     * @return Attribute
     */
    public function priceInSarRounded() : Attribute {
        return Attribute::make(
            get: fn() => round($this->price_in_sar, 2)
        );
    }

    /**
     * Product Price Country function
     *
     * @return HasOne
     */
    public function productPriceCountry() : HasOne {
        return $this->hasOne(ProductPrice::class, 'product_id');
    }

    /**
     * Product Price Country function
     *
     * @return HasMany
     */
    public function bestSellings() : HasMany {
        return $this->hasMany(BestSellingProduct::class, 'product_id');
    }


    /**
     * Product Price For National Country
     *
     * @return HasOne
     */
    public function nationalCountryPrice() : HasOne {
        return $this->hasOne(ProductPrice::class, 'product_id')
            ->whereHas('country', fn($c) => $c->national());
    }

    /**
     * Multi Price With Product Country function
     *
     * @return Attribute
     */
    public function price() : Attribute {
        return Attribute::make(
            get: function($price) {
                if (isAPiInternational()) {
                    return $this->productPriceCountry ? $this->productPriceCountry->price_with_vat_in_halala : $price;
                }
                return $price;
            },
            set: fn($v) => $v
        );
    }

    /**
     * Price Before With Multi Price Porduct function
     *
     * @return Attribute
     */
    public function priceBeforeOffer() : Attribute {
        return Attribute::make(
            get: function($priceBeforeOffer) {
                if (isAPiInternational()) {
                    return $this->productPriceCountry ? $this->productPriceCountry->price_before_offer_in_halala : $priceBeforeOffer;
                }
                return $priceBeforeOffer;
            },
            set: fn($v) => $v
        );
    }

    /**
     * Price Without Vat Product By Country
     * @return Attribute
     */
    public function priceWithoutVatInHalala() : Attribute {
        return Attribute::make(
            get: function() {
                if (isAPiInternational()) {
                    return $this->productPriceCountry ?
                        $this->productPriceCountry->price_without_vat_in_halala : $this->defaultPriceWithoutVat();
                }
                return $this->nationalCountryPrice->price_without_vat_in_halala ?? $this->defaultPriceWithoutVat();
            }
        );
    }

    /**
     * Product Vat Rate By Country
     * @return Attribute
     */
    public function vatRateInHalala() : Attribute {
        return Attribute::make(
            get: function() {
                if (isAPiInternational()) {
                    return $this->productPriceCountry ? $this->productPriceCountry->vat_rate_in_halala : $this->defaultVatRate();
                }
                return $this->nationalCountryPrice->vat_rate_in_halala ?? $this->defaultVatRate();
            }
        );
    }

    /**
     * Product Vat Rate By Country
     * @return Attribute
     */
    public function vatPercentage() : Attribute {
        return Attribute::make(
            get: function() {
                if (isAPiInternational()) {
                    return $this->productPriceCountry ? $this->productPriceCountry->vat_percentage : $this->defaultVatPercentage();
                }
                return $this->nationalCountryPrice->vat_percentage ?? $this->defaultVatPercentage();
            }
        );
    }

    /**
     * Product Price Country Id
     * @return Attribute
     */
    public function priceCountryId() : Attribute {
        return Attribute::make(
            get: function() {
                if (isAPiInternational()) {
                    return $this->productPriceCountry ? $this->productPriceCountry->country_id : null;
                }
                return $this->nationalCountryPrice->country_id ?? null;
            }
        );
    }

    /**
     * Price In Sar Rounded function
     *
     * @return Attribute
     */
    public function priceBeforeOfferInSarRounded() : Attribute {
        return Attribute::make(
            get: fn() => number_format($this->price_before_offer_in_sar, 2)
        );
    }

    /**
     * Product Stock By Header Country
     * @return Attribute
     */
    public function countryStock() : Attribute {
        return Attribute::make(
            get: function() {
                $defaultStock = $this->stock;
                if (isAPiInternational()) {
                    return $this->warehouseStock?->first()?->stock ?? $defaultStock;
                }
                return $defaultStock;
            }
        );
    }

    private function defaultPriceWithoutVat() {
        return $this->price  * 1 / 1.15;
    }

    private function defaultVatRate() {
        return $this->price - ($this->price  * 1 / 1.15);
    }

    private function defaultVatPercentage() {
        return 15;
    }

    public function favourites()
    {
        return $this->hasMany(FavoriteProduct::class, 'product_id');
    }

    public function updateTempForSquareimage(){
        if( ($this->square_image_temp && $this->square_image_temp != $this->square_image) 
            && 
            (!$this->temp || $this->temp?->approval != 'pending')
        ){
            $this->clearMediaCollection(Product::mediaCollectionName);
            Media::where(['model_id' => $this->id , 'model_type'=>'App\Models\Product', 'collection_name' => Product::mediaTempCollectionName])->update(['collection_name' => Product::mediaCollectionName]);
            $this->clearMediaCollection(Product::mediaTempCollectionName);
        };

        if($this->square_image_temp){
            return $this->square_image_temp;
        }

        return $this->square_image;
    }
}
