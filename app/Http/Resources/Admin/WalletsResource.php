<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class WalletsResource extends JsonResource
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
            "id" => $this->id,
            "customer" => [
                "id" => $this->customer->id,
                "name" => $this->customer->name
            ],
            "admin" => [
                "id" => $this->admin->id ?? '',
                "name" => $this->admin->name ?? ''
            ],
            "is_active" => $this->is_active,
            "amount" => $this->amount_with_sar,
            "reason" =>$this->reason,
            "attachment" => $this->attachment_url
        ];
    }
}
