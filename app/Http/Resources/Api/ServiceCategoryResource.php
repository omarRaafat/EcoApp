<?php

namespace App\Http\Resources\Api;

use App\Enums\CategoryLevels;
use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceCategoryResource extends JsonResource
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
            'status' => $this->status,
            'created_at' => $this->created_at->format('d-m-Y'),
            'services_count' => $this->services_count,
        ];
    }

    public function resolve($request = null)
    {
        if(is_null($this->resource))
            return [];
        else
            return $this->toArray($this->resource);
    }

}
