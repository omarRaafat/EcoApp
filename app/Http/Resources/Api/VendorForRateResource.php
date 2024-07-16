<?php

namespace App\Http\Resources\Api;

use App\Enums\PaymentMethods;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class VendorForRateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $firstRate = $this?->vendor?->userVendorRates?->first();
        return [
            'name' => $this->vendor->name,
            'id' => $this->vendor->id,
            'order_id' => $this->id,
            'shipping_type_id' => $this->orderShipping->shipping_type_id,
            'processRate'=> $this->processRate ? true : false,
            'is_rated' => $firstRate ? true : false,
            'rate' => (float) ($firstRate && $firstRate->rate > 0 ? $firstRate->rate : 0),
            'products' => OrderProductsForReviewResource::collection($this->products)
        ];
    }
}


