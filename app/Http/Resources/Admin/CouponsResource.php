<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class CouponsResource extends JsonResource
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
        "code" => $this->code,

        "title_ar" => $this->getTranslation('title', 'ar'),
        "title_en" => $this->getTranslation('title', 'en'),
        
        'amount'=>$this->amount,
        'minimum_amount'=>$this->minimum_amount,

        "status" => $this->status,
    ];
}
}