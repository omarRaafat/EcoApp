<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Warehouse extends BaseModel
{
    use HasTranslations,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        "vendor_id",
        "name",
        "torod_warehouse_name",
        "administrator_name",
        "administrator_phone",
        "administrator_email",
        "map_url",
        "latitude",
        "longitude",
        "address", // @todo This address not translatable because we just need it when we create spl-waybill-pdf
        "package_price",
        "package_covered_quantity",
        "additional_unit_price",
        "api_key",
        'type',
        "postcode",
        "days",
        "time_work_from",
        "time_work_to",
        'is_active'
    ];

    /**
     * The attributes needs to be transelated.
     * @var array
     */
    public $translatable = ['name' , 'address'];

    const ACCEPTED = "accepted"; // موافق عليه
    const PENDING = "pending"; // عن الإضافة من تاجر
    const UPDATED = "updated"; // عند تحديث من تاجر
    const REJECTED = "rejected"; 
    const UPDATE_REFUSED = "update_refused"; 

    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * Return list of products assossiated to this warehouse.
     * @return HasMany
     */
    public function products() : HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get all warehouse shipping request assossiated to this warehouse.
     */
    public function warehouseShippingRequest() : HasMany
    {
        return $this->hasMany(WarehouseShippingRequest::class);
    }

    public function packagePrice() : Attribute {
        return Attribute::make(
            get: fn($v) => $v / 100,
            set: fn($v) => $v * 100,
        );
    }

    public function packagePriceHalala() : Attribute {
        return Attribute::make(
            get: fn() => $this->package_price * 100,
        );
    }

    public function additionalUnitPrice() : Attribute {
        return Attribute::make(
            get: fn($v) => $v / 100,
            set: fn($v) => $v * 100,
        );
    }

    public function additionalUnitPriceHalala() : Attribute {
        return Attribute::make(
            get: fn() => $this->additional_unit_price * 100,
        );
    }
    public function googleMapUrl() :Attribute
    {
        return Attribute::make(
            get:fn() => "https://www.google.com/maps/@$this->latitude,$this->longitude,13z?hl=ar-SA&entry=ttu"
        );
    }




    public function countries() : BelongsToMany
    {
        return $this->belongsToMany(
            Country::class,
            "warehouse_countries",
            "warehouse_id",
            "country_id"
        );
    }

    /**
     * @return BelongsToMany
     */
    public function cities() : BelongsToMany
    {
        return $this->belongsToMany(
            City::class,
            "warehouse_cities",
            "warehouse_id",
            "city_id"
        )->latest()->limit(1);
    }

    /**
     * @return BelongsTo
     */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo('App\Models\Vendor' , 'vendor_id');
    }


    /**
     * @param   $builder
     *
     * @return  Warehouse
     */
    public function scopeGetBothAndReceive($builder): Warehouse
    {
        return $builder->where('type' , '<>' , 'deliver');
    }

    /**
     * @return BelongsToMany
     */
    public function shippingTypes(): BelongsToMany
    {
        return $this->belongsToMany(ShippingType::class , 'warehouse_shipping_types' , 'warehouse_id' , 'shipping_type_id');
    }

    public function WarehouseShippingTypeReceive()
    {
        return $this->hasOne(WarehouseShippingType::class ,'warehouse_id','id')->where('shipping_type_id',1)->latest();
    }

    public function WarehouseShippingTypeDeliver()
    {
        return $this->hasOne(WarehouseShippingType::class ,'warehouse_id','id')->where('shipping_type_id',2)->latest();
    }

    public function splInfo()
    {
        return $this->hasOne(WarehouseSplInfo::class ,'warehouse_id','id')->withDefault();
    }

    public function warehouseProducts()
    {
        return $this->belongsToMany(
            \App\Models\Product::class,
            'product_warehouse_stocks',
            'warehouse_id',
            'product_id'
        )->withPivot(['stock'])
        ->withTimestamps();
    }

    public function getLastStatus(){
        return  $this->hasOne(WarehouseStatus::class,'warehouse_id','id')->latestOfMany()->withDefault([
           "status" => self::ACCEPTED
        ]);
    }

    public function scopeAvailable($query){
        $query->whereHas('getLastStatus',function($qr){
            $qr->whereNotIn('status',[self::PENDING,self::REJECTED]);
        });
    }

    public function scopePending($query){
        $query->whereHas('getLastStatus',function($qr){
            $qr->where('status',self::PENDING);
        });
    }

    public function isPending(){
        return $this->getLastStatus->status == self::PENDING;
    }
  
    public function isRejected(){
        return $this->getLastStatus->status == self::REJECTED;
    }

    public function isWaitUpdated(){
        return $this->getLastStatus->status == self::UPDATED;
    }

    public function isUpdatedRefused(){
        return $this->getLastStatus->status == self::UPDATE_REFUSED;
    }


    public function scopeActive($query){
        return $query->whereIsActive(1);
    }
    
    
  

}
