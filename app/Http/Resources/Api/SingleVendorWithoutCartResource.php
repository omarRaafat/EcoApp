<?php

namespace App\Http\Resources\Api;

use App\Http\Resources\Api\ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SingleVendorWithoutCartResource extends JsonResource
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
            'desc' => $this->desc,
            'logo' => ossStorageUrl($this->logo),
            'rate' => !empty($this->rate) ? $this->rate : null,
            'products' => ProductResource::collection($this->products),
        ];
    }
}
