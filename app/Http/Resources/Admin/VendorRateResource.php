<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Admin\AreaResource;

class VendorRateResource extends JsonResource
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
            "user" => $this->customer->name,
            "vendor" => $this->vendor_id,
            "rate" => $this->rate,
            "admin_id" => !empty($this->admin) ? $this->admin->name : trans("admin.vendortRate.not_found"),
            "admin_comment" => !empty($this->admin_comment) ? $this->admin_comment : trans("admin.vendortRates.not_found"),
            "admin_approved" => !empty($this->admin_approved) ? $this->admin_approved : trans("admin.vendortRates.not_found"),
            "created_at" => $this->created_at
        ];
    }
}
