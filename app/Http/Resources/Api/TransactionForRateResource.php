<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionForRateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'is_rated' => $this->orders->filter(function($order) {
                    $vendorRated = $order?->vendor?->userVendorRates?->first();
                    
                    return !$vendorRated || $order->products->filter(function($product) {
                        return $product?->reviews?->first();
                        
                    })->isEmpty();

                })
                ->isEmpty(),
            'vendors' =>  VendorForRateResource::collection($this->orders)
        ];
    }
}
