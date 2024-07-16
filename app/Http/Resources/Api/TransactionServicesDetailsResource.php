<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class TransactionServicesDetailsResource extends JsonResource
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
            'code' => $this->code,
            'city' => ['id' => $this->city_id , 'name' => $this->city->name ],
            'discount' => $this->discount ?? 0,
            'services_total' => number_format($this->sub_total,2),
            'services_total_with_vat' =>  number_format($this->sub_total + $this->total_vat , 2),
            // 'products_and_devliery_without_vat' => number_format($this->sub_total +  $this->orderVendorShippings()->sum('total_shipping_fees') , 2),
            'total' => number_format($this->total , 2),
            'wallet_detaction' => $this->orderServices()->sum('wallet_amount'),
            // 'total_without_vat' => number_format($this->sub_total + $this->orderVendorShippings()->sum('total_shipping_fees') ?? 0 , 2),
            'vat_percentage' => $this->vat_percentage ? $this->vat_percentage : 0,
            'vat_rate' => $this->total_vat ?? 0,
            'services_count' => $this->products_count,
            'inv_url' => in_array($this->status,['completed','refund']) ? $this->inv_url : null,
            'date' => Carbon::parse($this->date)->format('Y/m/d'),
            'payment_method' => __('translation.payment_methods.'. $this->payment_method),
            'status' => $this->status,
            'statuses' => $this->getStatuses(),
            'orders' => OrderServicesDetailsResource::collection($this->orderServices),
        ];
    }
}
