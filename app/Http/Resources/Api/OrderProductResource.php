<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductResource extends JsonResource
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
            'name' => $this->name,
            'image' => $this->square_image,
            'price' => $this->pivot->unit_price,
            'quantity' => $this->pivot->quantity,
            'available' => ($this->deleted_at || ($this->is_active !=1 || $this->status !='accepted')? 0 : 1)

        ];
    }
}
