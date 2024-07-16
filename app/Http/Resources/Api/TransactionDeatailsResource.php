<?php

namespace App\Http\Resources\Api;

use App\Enums\OrderStatus;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionDeatailsResource extends JsonResource
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
            'city' => ['id' => $this->city_id , 'name' => $this->city?->name ],
            'shipment_fee' => number_format($this->orderVendorShippings()->sum('total_shipping_fees') , 2) ?? 0,
            'shipment_fees_details' => [
                'cod_collect' => number_format($this->cod_collect_fees, 2) ?? 0,
                'packaging' => number_format($this->packaging_fees, 2) ?? 0,
                'extra_weight' => number_format($this->extra_weight_fees, 2) ?? 0,
            ],
            'discount' => $this->discount ?? 0,
            'products_total' => number_format($this->sub_total,2),
            'products_total_with_vat' =>  number_format($this->sub_total + $this->total_vat , 2),
            'products_and_devliery_without_vat' => $this->type == 'order' ? number_format($this->sub_total +  $this->orderVendorShippings()->sum('total_shipping_fees') , 2) : number_format($this->sub_total , 2),
            'total' => number_format($this->total , 2),
            'wallet_detaction' => $this->type == "order" ? $this->orders()->sum('wallet_amount') : $this->orderServices()->sum('wallet_amount'),
            'total_without_vat' => $this->type== 'order' ?  number_format($this->sub_total + $this->orderVendorShippings()->sum('total_shipping_fees') ?? 0 , 2) : number_format($this->sub_total ?? 0 , 2),
            'vat_percentage' => $this->vat_percentage ? $this->vat_percentage : 0,
            'vat_rate' => $this->total_vat ?? 0,
            'products_count' => $this->products_count,
            'inv_url' => in_array($this->status,['completed','refund']) ? $this->saveOrderPdfAndReturnPath() : null,
            'date' => Carbon::parse($this->date)->format('Y/m/d'),
            'payment_method' => __('translation.payment_methods.'. $this->payment_method),
            'status' => $this->status,
            'statuses' => $this->type == "order" ? $this->getStatuses() : $this->getStatusesOrderServices(),
            'orders' => $this->type == "order" ?  OrderResource::collection($this->orders) : OrderServicesDetailsResource::collection($this->orderServices),
        ];
    }
}
