<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Admin\AreaResource;

class ProductRateResource extends JsonResource
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
            "rate" => $this->rate,
            "comment" => $this->comment,
            "user_id" => $this->user->name,
            "product_id" => $this->product->name,
            "admin_id" => !empty($this->admin) ? $this->admin->name : trans("admin.productRate.not_found"),
            "reason" => !empty($this->reason) ? $this->reason : trans("admin.productRates.not_found"),
            "admin_comment" => !empty($this->admin_comment) ? $this->admin_comment : trans("admin.productRates.not_found"),
            "admin_approved" => !empty($this->admin_approved) ? $this->admin_approved : trans("admin.productRates.not_found"),
            "reporting" => !empty($this->reporting) ? $this->reporting : trans("admin.productRates.not_found"),
            "created_at" => $this->created_at
        ];
    }
}
