<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\Admin\CityResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
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
            "name_ar" => $this->getTranslation('name', 'ar'),
            "name_en" => $this->getTranslation('name', 'en'),
            "is_active" => $this->is_active,
            "is_national" => $this->is_national,
            "cities" => CityResource::collection($this->cities)
        ];
    }
}
