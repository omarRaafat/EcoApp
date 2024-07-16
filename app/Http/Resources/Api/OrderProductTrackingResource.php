<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductTrackingResource extends JsonResource
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

            'id' => $this->product->id,
            'name' => $this->product->name,
            'image' => url($this->product->image),
            'price' => $this->unit_price,
            'quantity' => $this->quantity,
            'available' => ($this->deleted_at || ($this->product->is_active !=1 || $this->product->status !='accepted')? 0 : 1)
        ];
    }
}
