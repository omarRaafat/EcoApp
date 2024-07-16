<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderTrackingResource extends JsonResource
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
            // 'status' => $this->transaction->status ?? $this->status,
            'status'=>$this->status,
            'statuses' => $this->getStatuses(),
            'products' => OrderProductTrackingResource::collection($this->products),
        ];
    }
}
