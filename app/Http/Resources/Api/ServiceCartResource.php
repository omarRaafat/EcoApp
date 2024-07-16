<?php

namespace App\Http\Resources\Api;

use App\Http\Resources\ClientWalletResources;
use App\Models\Cart;
use App\Models\CartProduct;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceCartResource extends JsonResource
{
    private $wallets ;
    public function __construct($resource, $wallets = null) {
        // Ensure we call the parent constructor
        parent::__construct($resource);
        $this->resource = $resource;
        $this->wallets = $wallets;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $serviceTotal = $this->cartProducts()->sum('total_price') ?? 0;
        $vatPercentage = getParam('vat');
        $vat_rate = ($this->cartProducts()->sum('total_price') * ($vatPercentage / 115));
        $totalWithoutVat = ($this->cartProducts()->sum('total_price') - $vat_rate);
        $cart = Cart::find($this->id);
        $vendors = Cart::find($this->id)->cartProducts()
        ->with('service.vendor')
        ->get()
        ->pluck('service.vendor')
        ->unique('id'); // Ensure unique vendors
        $cart->load('cartProducts.service.images');
        $cartProduct = CartProduct::where('cart_id',$this->id)->first();
        return [
            'id' => $this->id,
            'city' => $this->city ? ['id' => $this->city_id , 'name' => $this->city->name, 'area_id' => $this->city->area_id] : null,
            'serviceAddress' => $cart->service_address,
            'serviceDate' => $cart->service_date,
            'vendors'               => VendorServiceResource::collection($vendors),
            // 'service'               => new ServiceResource($cartProduct->service ?? null),
            'serviceTotal'          => number_format($serviceTotal, 2),
            'serviceCount'          => $this->cart_products_sum_quantity,
            'total'                 => $this->cartProducts()->sum('total_price'),
            'total_without_vat'     => number_format($totalWithoutVat,2),
            'vat_percentage'        => $vatPercentage,
            'vat_rate'              => number_format($vat_rate,2),
            'wallet_amount'         => $this->wallet_amount ?? null,
            'wallet_amount_label'   => number_format($this->wallet_amount, 2) ?? null,
            'client_wallets' =>  $this->wallets ? ClientWalletResources::collection($this->wallets) : [],
        ];
    }
}
