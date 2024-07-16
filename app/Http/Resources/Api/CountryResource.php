<?php

namespace App\Http\Resources\Api;

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
        $data = [
            "id"          => $this->id,
            "name"        => $this->name,
            "code"        => $this->code,
            "flag"        => $this->flag,
            "is_active"   => $this->is_active,
            "is_national" => $this->is_national,
        ];

        if($this->is_national) {
            $data["areas"] = AreaResource::collection($this->whenLoaded("areas"));
        } else {
            $data["cities"] = CityResource::collection($this->whenLoaded("cities"));
        }

        return $data;
    }
}
