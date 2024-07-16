<?php

namespace App\Models;

use App\Services\Eportal\Connection;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends BaseModel
{
    use SoftDeletes;
    protected $fillable=[ 'user_id' ,
    'is_active' ,
    'city_id' ,
    'total_shipping_fees' ,
    'total_shipping_fees' ,
    'total_weight' ,
    'visa_amount', 'wallet_amount', 'van_type' , 'products_count' , 'total_price' , 'guest_customer_id','service_address','service_date'];

    public function cartProducts()
    {
        return $this->hasMany(CartProduct::class);
    }

    public function availableCartProducts()
    {
        return $this->cartProducts()->with('product')->whereHas('product', function ($query) {
            $query->available();
        });
    }
    public function availableCartServices()
    {
        return $this->cartProducts()->with('service')->whereHas('service', function ($query) {
            $query->available();
        });
    }

    public function user()
    {
        return $this->belongsTo(auth()->guard('api_client')->user() ? Client::class : User::class,'user_id');
    }

    public function guestCustomer()
    {
        return $this->belongsTo(GuestCustomer::class , 'guest_customer_id');
    }

    public function vendors()
    {
        return $this->belongsToMany(Vendor::class, 'cart_product', "cart_id")->using(CartProduct::class);
    }
    public function vendorService()
    {
        return $this->belongsToMany(Vendor::class, 'cart_product', "cart_id",)->using(CartProduct::class);
    }


    public function products()
    {
        return $this->belongsToMany(Product::class)
        ->using(CartProduct::class)->withPivot('quantity','created_at','updated_at');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class,'cart_product')
        ->using(CartProduct::class)->withPivot('quantity','created_at','updated_at','total_price');
    }

    public function cartTotal() : Attribute {
        return Attribute::make(
            get: fn () => $this->products->sum(fn($p) => $p->price * $p->pivot->quantity),
        );
    }

    public function cartTotalInSar() : Attribute {
        return Attribute::make(
            get: fn () => $this->products->sum(fn($p) => $p->price * $p->pivot->quantity) / 100,
        );
    }

    public function cartServiceTotal() : Attribute {
        return Attribute::make(
            get: fn () => $this->cartProducts->whereNotNull('service_id')->whereNull('product_id')->sum('total_price'),
        );
    }

    public function cartServiceTotalInSar() : Attribute {
        return Attribute::make(
            get: fn () => $this->cartProducts->whereNotNull('service_id')->whereNull('product_id')->sum('total_price') / 100,
        );
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }


    public function  cartVendorShippings()
    {
        return $this->hasMany(CartVendorShipping::class , 'cart_id');
    }

    public function client(){
        return $this->belongsTo(Client::class, 'user_id')->withDefault();
    }

    public function scopeOwClient($query){
        return $query->where('user_id', auth()->guard('api_client')->user()?->id);
    }

    # check is city or country in domesticZones
    public function isAddressValidForDelivery(): bool{
        foreach ($this->cartVendorShippings as $key => $cartVendorShipping) {
            if ($cartVendorShipping->shippingMethod) {
                if($cartVendorShipping->shippingMethod?->domesticZones?->first()?->cities?->isNotEmpty() == false) return false;
            }
        }

        return true;
    }
    public function getVendorCartVatTotalService($vendorId)
    {
        return $this->cartProducts
            ->filter(fn($c) => $c->service->vendor_id == $vendorId)
            ->sum(fn($c) => $c->quantity * ($c->total_price ?? 0));
    }
    public function getVendorCartWithoutVatTotalService($vendorId)
    {
        $serviceTotal = $this->cartProducts()->where('service_id','!=',null)->sum('total_price') ?? 0;
        $vatPercentage = getParam('vat');
        $vat_rate = ($serviceTotal * ($vatPercentage / 115));
        $totalWithoutVat = ($serviceTotal - $vat_rate);
        return $this->cartProducts->filter(fn($c) => $c->service->vendor_id == $vendorId)->sum(fn($c) => $c->quantity * ($totalWithoutVat ?? 0));
    }
    public function getVendorTotalService($vendorId)
    {
        $cartTotalServiceVat = $this->getVendorCartVatTotalService($vendorId);
        $cartTotalWithOutVat = $this->getVendorCartWithoutVatTotalService($vendorId);
        return [
            "single_service_total" => $cartTotalServiceVat,
            "service_total" => $cartTotalWithOutVat,
            "vat_rate" => $cartTotalServiceVat,
            "vat_percentage" => getParam('vat'),
        ];
    }
    public function getVendorTotalsInHalala(int $vendorId) : array {
        $cartTotalVatInHalala = $this->vendorCartTotalVatInHalala($vendorId);
        $cartTotalWihtoutVatInHalala = $this->vendorCartTotalWithoutVatInHalala($vendorId);

        $deliveryFees = $this->cartVendorShippings()->where('vendor_id' ,$vendorId )->first()?->total_shipping_fees ?? 0;

        return [
            "products_total" => $cartTotalWihtoutVatInHalala,
            "vat_rate" => $cartTotalVatInHalala,
            "vat_percentage" => getParam('vat'),
            "delivery_fees" => $deliveryFees,
            "discount" => isset($this->discountComponent) ? $this->discountComponent->getDiscount() : 0,
        ];
    }

    public function vendorCartTotalVatInHalala(int $vendorId) : float {
        return $this->cartProducts
            ->filter(fn($c) => $c->product->vendor_id == $vendorId)
            ->sum(fn($c) => $c->quantity * ($c->product?->vat_rate_in_halala ?? 0));
    }

    public function vendorCartTotalWithoutVatInHalala(int $vendorId) : float {
        return $this->cartProducts
            ->filter(fn($c) => $c->product->vendor_id == $vendorId)
            ->sum(fn($c) => $c->quantity * ($c->product?->price_without_vat_in_halala ?? 0));
    }

    public function urwayTransaction()
    {
        return $this->hasMany(UrwayTransaction::class, 'cart_id');
    }

    public function tabbyTransaction()
    {
        return $this->hasMany(TabbyTransaction::class, 'cart_id');
    }

}
