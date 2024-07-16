<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class CartServiceDataResource extends JsonResource
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
            'id' => $this->service?->id,
            'name' => $this->service?->name,
            'desc' => $this->service?->desc,
            'image' => $this->service?->square_image_small,
            'price' => round($this->total_price / $this->quantity,2),
            'quantity' => $this->quantity,
            'cities' => CityResource::collection($this->service?->cities),
            'service_fields' => CartProductServiceFieldResource::collection($this->cartProductServiceFields)
        ];
    }
}
