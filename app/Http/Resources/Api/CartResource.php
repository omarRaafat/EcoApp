<?php

namespace App\Http\Resources\Api;

use App\Http\Resources\Admin\WalletResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\VendorResource;
use App\Http\Resources\ClientWalletResources;
use App\Models\Setting;
use App\Services\Eportal\Connection;
use Illuminate\Http\Request;

class CartResource extends JsonResource
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
        $vatRate = $this->totals['vat_rate'] ?? 0;
        $vatPercentage = $this->totals['vat_percentage'] ?? 0;

        $productsTotal = $this->cartProducts()->sum('total_price') ?? 0;
        $deliveryFees = $this->cartVendorShippings()->sum('total_shipping_fees') ?? 0;
        $discount = $this->totals['discount'] ?? 0;
        $total = $this->totals['products_total'] + $vatRate + $deliveryFees - $discount;
        $totalWithoutVat = $this->totals['products_total'] + $deliveryFees;

        return [
            'id' => $this->id,
            'city' => $this->city ? ['id' => $this->city_id , 'name' => $this->city->name, 'area_id' => $this->city->area_id] : null,
            'products_count'        => $this->cart_products_sum_quantity,
            'products_total'        => number_format($productsTotal, 2),
            'delivery_fees'         => number_format($deliveryFees, 2),
            'delivery_fees_details' => [
                'cod_collect'  => number_format(($this->totals['delivery_fees_details']['cod_collect'] ?? 0) / 100 ,2),
                'packaging'    => number_format(($this->totals['delivery_fees_details']['packaging'] ?? 0) / 100 ,2),
                'extra_weight' => number_format(($this->totals['delivery_fees_details']['extra_weight'] ?? 0) / 100 ,2),
            ],
            'discount'              => number_format($discount,2),
            'total_without_vat'     => number_format($totalWithoutVat, 2),
            'vat_percentage'        => number_format($vatPercentage, 2),
            'vat_rate'              => number_format($vatRate, 2),
            'total'                 => number_format($total, 2,'.',''),
            'wallet_amount'         => $this->wallet_amount ?? null,
            'wallet_amount_label'   => number_format($this->wallet_amount, 2) ?? null,
            'vendors'               => VendorResource::collection($this->vendors),
            'total_weight'          => $this->total_weight,
            'total_shipping_fees'   => number_format($deliveryFees, 2),
            'client_wallets' =>  $this->wallets ? ClientWalletResources::collection($this->wallets) : [],
        ];
    }
}
