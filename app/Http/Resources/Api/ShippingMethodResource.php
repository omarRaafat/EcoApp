<?php

namespace App\Http\Resources\Api;


use Illuminate\Http\Resources\Json\JsonResource;

class ShippingMethodResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $domesticZone = $this->domesticZones->first();
        $delivery_date_label=  "";

        if ($domesticZone && $domesticZone?->days_to) {
            $dateFrom = $domesticZone->days_from ? now()->addDays($domesticZone->days_from)->format("Y/m/d") : "";
            $dateTo = $domesticZone->days_to ? now()->addDays($domesticZone->days_to)->format("Y/m/d") : "";
            $delivery_date_label = __("cart.api.delivery-date", ['dateFrom' => $dateFrom, 'dateTo' => $dateTo]);
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'logo' => ossStorageUrl($this->logo),
            'delivery_fees' => 0,
            'is_selected' => 1,
            'delivery_date_label' => $delivery_date_label,
        ];
    }
}
