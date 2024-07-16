<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\UploadImageTrait;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Str;
use Spatie\Image\Manipulations;

class Vendor extends BaseModel implements HasMedia
{
    use HasTranslations, SoftDeletes , InteractsWithMedia,  UploadImageTrait;

    protected $fillable     = [
        'is_active',
        'approval',
        'name',
        'desc',
        'street',
        'logo',
        'tax_num',
        'cr',
        'crd',
        // 'bank_name',
        'broc',
        'tax_certificate',
        'iban_certificate',
        'bank_num',
        'ipan',
        "name_in_bank",
        'commission',
        'rate',
        'ratings_count',
        'avg_rating',
        'is_international',
        'user_id',
        'bank_id',
        'second_phone',
        'website',
        'saudia_certificate' ,
        'subscription_certificate' ,
        'commercial_registration_no' ,
        'room_certificate',
        'services'
    ];
    public $translatable = ['name', 'desc'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }


    public function scopeAvailable($query)
    {
        return $query->where('is_active', 1)->where('approval','approved')->whereDoesntHave('agreements',function($qr){
            $qr->pending();
        });
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name->ar','like','%'.trim($search).'%')->orWhere('name->en','like','%'.trim($search).'%');
    }

    const mediaCollectionName = "ProductVendors";

    public function setLogoAttribute(UploadedFile $image)
    {
        if (isset($image) && is_file($image) && !is_string($image)) {
            $this->attributes['logo'] = self::moveFileToPublic($image, "ProductVendors");
        }else{
            $this->attributes['logo']=$image;
        }
    }

    public function setCrAttribute(UploadedFile $image)
    {
        if (isset($image) && is_file($image) && !is_string($image)) {
            $this->attributes['cr'] = self::moveFileToPublic($image, "ProductVendors");
        }else{
            $this->attributes['cr']=$image;
        }
    }

    public function setTaxCertificateAttribute(UploadedFile $image)
    {
        if (isset($image) && is_file($image) && !is_string($image)) {
            $this->attributes['tax_certificate'] = self::moveFileToPublic($image, "ProductVendors");
        }else{
            $this->attributes['tax_certificate']=$image;
        }
    }

    public function setIbanCertificateAttribute(UploadedFile $image)
    {
        if (isset($image) && is_file($image) && !is_string($image)) {
            $this->attributes['iban_certificate'] = self::moveFileToPublic($image, "ProductVendors");
        }else{
            $this->attributes['iban_certificate']=$image;
        }
    }

    public function setSaudiaCertificateAttribute(UploadedFile $image)
    {
        if (isset($image) && is_file($image) && !is_string($image)) {
            $this->attributes['saudia_certificate'] = self::moveFileToPublic($image, "ProductVendors");
        }else{
            $this->attributes['saudia_certificate']=$image;
        }
    }

    public function setSubscriptionCertificateAttribute(UploadedFile $image)
    {
        if (isset($image) && is_file($image) && !is_string($image)) {
            $this->attributes['subscription_certificate'] = self::moveFileToPublic($image, "ProductVendors");
        }else{
            $this->attributes['subscription_certificate']=$image;
        }
    }

    public function setRoomCertificateAttribute(UploadedFile $image)
    {
        if (isset($image) && is_file($image) && !is_string($image)) {
            $this->attributes['room_certificate'] = self::moveFileToPublic($image, "ProductVendors");
        }else{
            $this->attributes['room_certificate']=$image;
        }
    }



    public function registerMediaCollections(Media $media = null): void
    {
        $this->addMediaCollection('logo')
          ->acceptsMimeTypes(['image/jpg', 'image/jpeg', 'image/png']);
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



    /**
     * Undocumented function
     *
     * @return Attribute
     */
    /*
    protected function ibanCertificate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value
        );
    }

    public function SetIbanCertificateAttribute($value) {
        if ($value instanceof UploadedFile)
            return $this->attributes['iban_certificate'] = self::moveFile($value, "images/vendors/iban_certificates");
        else return $this->attributes['iban_certificate'] = $value;
    }
    */


    /**
     * Undocumented function
     *
     * @return Attribute
     */
    /*
    protected function cr(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
        );
    }

    public function SetCrAttribute($value) {
        if ($value instanceof UploadedFile)
            return $this->attributes['cr'] = self::moveFile($value, "images/vendors/commecral_registers");
        else return $this->attributes['cr'] = $value;
    }*/




    /**
     * Undocumented function
     *
     * @return Attribute
     */
    /*
    protected function broc(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
        );
    }

    public function SetBrocAttribute($value) {
        if ($value instanceof UploadedFile){
            return $this->attributes['broc'] = self::moveFile($value, "images/vendors/brand_rights_ownership_certificates");
        }else{
        return $this->attributes['broc'] = $value;
        }
    }*/

    /**
     * Undocumented function
     *
     * @return Attribute
     */
    /*
    protected function taxCertificate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
        );
    }

    public function SetTaxCertificateAttribute($value) {
        if ($value instanceof UploadedFile)
            return $this->attributes['tax_certificate'] = self::moveFile($value, "images/vendors/tax_certificates");
        else return $this->attributes['tax_certificate'] = $value;
    }*/


    /**
     * Undocumented function
     *
     * @return Attribute
     */
    /*
    protected function saudiaCertificate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
        );
    }
    public function SetSaudiaCertificateAttribute($value) {
//        dd($value);
        if ($value instanceof UploadedFile)
            return $this->attributes['saudia_certificate'] = self::moveFile($value, "images/vendors/saudia_certificate");
        else return $this->attributes['saudia_certificate'] = $value;
    }

    protected function subscriptionCertificate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
        );
    }

    public function SetSubscriptionCertificateAttribute($value) {
        if ($value instanceof UploadedFile)
            return $this->attributes['subscription_certificate'] = self::moveFile($value, "images/vendors/subscription_certificate");
        else return $this->attributes['subscription_certificate'] = $value;
    }


    protected function roomCertificate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
        );
    }

    public function SetRoomCertificateAttribute($value) {
        if ($value instanceof UploadedFile)
            return $this->attributes['room_certificate'] = self::moveFile($value, "images/vendors/room_certificate");
        else return $this->attributes['room_certificate'] = $value;
    }*/

    public function cartProducts()
    {
        return $this->belongsToMany(Product::class, 'cart_product', "vendor_id")->using(CartProduct::class)->withPivot('quantity')
        ->wherePivot('quantity', '>', 0);
    }
    public function cartService()
    {
        return $this->belongsToMany(Service::class, 'cart_product', "vendor_id")->using(CartProduct::class)->withPivot('quantity')
        ->wherePivot('quantity', '>', 0);
    }

    public function products()
    {
        return $this->hasMany(Product::class,'vendor_id');
    }
    public function vendorServices() :HasMany
    {
        return $this->hasMany(Service::class,'vendor_id');
    }

    public function availableProducts()
    {
        return $this->hasMany(Product::class,'vendor_id')->available();
    }

    public function availableServices()
    {
        return $this->hasMany(Service::class,'vendor_id')->available();
    }

    public function VendorWarnings()
    {
        return $this->hasMany(VendorWarnings::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get list of vendor rates that created by user(customer).
     *
     * @return HasMany
     */
    public function userVendorRates() : HasMany
    {
        return $this->hasMany(UserVendorRate::class);
    }

    /**
     * Get list of approved vendor rates that created by user(customer).
     *
     * @return HasMany
     */
    public function approvedUserVendorRates() : HasMany
    {
        return $this->hasMany(UserVendorRate::class)->approved();
    }

    public function wallet() {
        return $this->hasOne(VendorWallet::class, 'vendor_id');
    }

    /**
     * Get the user that own this vendor depend on his type.
     *
     * @return BelongsTo
     */
    public function owner() : BelongsTo
    {
        return $this->belongsTo(User::class, "user_id", "id")->where("type", "vendor");
    }



    public function certificates()
    {
        return $this->belongsToMany(Certificate::class, 'certificate_vendor', "vendor_id")->withPivot('approval');

    }

    public function approved_certificates()
    {
        return $this->belongsToMany(Certificate::class, 'certificate_vendor', "vendor_id")->withPivot('approval')
        ->where('approval','approved');

    }

    public function rate()
    {
        return $this->hasMany(UserVendorRate::class,'vendor_id');
    }

    public function isRatedBy($user)
    {
        return $this->rate()->where('user_id',$user->id)->count() ? 1:0 ;
    }

    private static function moveFile(UploadedFile $file, $path) {
        $fileName = time() .'-'. rand(1000,10000) .  '.' . $file->getClientOriginalExtension();
        Storage::disk('oss')->put($path ."/". $fileName, $file->get());
        return "$path/$fileName";
    }

    public function guestCartProducts()
    {
        return $this->belongsToMany(Product::class, 'guest_cart_products')->withPivot(['quantity']);
    }

    public function bank() : BelongsTo
    {
        return $this->belongsTo(Bank::class, 'bank_id', 'id')->withDefault();
    }

    public function isAvailableVendor() : Attribute {
        return Attribute::make(
            get: fn () => $this->approval == 'approved' && $this->is_active
        );
    }

    /**
     * This vendor has many warehouse integration requests
     */
    public function warehouseIntegrations() : HasMany
    {
        return $this->hasMany(WarehouseIntegration::class);
    }

    /**
     * Return the beez vendor id assossiated to this vendor.
     */
    public function beezConfig() : HasOne
    {
        return $this->hasOne(VendorBeezConfig::class);
    }

    public function agreements() : HasMany {
        return $this->hasMany(VendorAgreement::class, "vendor_id");
    }

    /**
     * @return HasMany
     */
    public function warehouses(): HasMany
    {
        return $this->hasMany('App\Models\Warehouse' , 'vendor_id');
    }

    /**
     * @return HasMany
     */
    public function warehousesReceive(): HasMany
    {
        return $this->warehouses()->whereIsActive(1)
                    ->whereHas('shippingTypes', function ($q) {
                        $q->where('shipping_type_id' ,1);
                    });
    }

    public function warehousesDeliver(): HasMany
    {
        return $this->warehouses()
                    ->whereHas('shippingTypes', function ($q) {
                        $q->where('shipping_type_id' ,2);
                    });
    }

    public function cartVendorShippings(): HasMany
    {
        return $this->hasMany(CartVendorShipping::class , 'vendor_id');
    }

    public function getShippingFeesAndVanType(int $cart_id)
    {
        $shippingFees = $this->cartVendorShippings()->where('cart_id' , $cart_id)->first();
        return ['total_fees' =>  isset($shippingFees['total_shipping_fees']) ? $shippingFees['total_shipping_fees'] : null , 'truck_type' => isset($shippingFees['van_type']) ? $shippingFees['van_type'] : null];
    }

    /**
     * @return HasMany
     */
    public function bankTransfer(): HasMany
    {
        return $this->hasMany("\App\Models\VendorBankTransfer" , 'vendor_id');
    }

    public function vendorWalletTransactions(){
        return $this->hasManyThrough(VendorWalletTransaction::class,VendorWallet::class,'vendor_id','wallet_id','id', 'id');
    }

    protected $casts = [
        'services' => 'array',
    ];

}
