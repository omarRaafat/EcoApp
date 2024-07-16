<?php

namespace App\Http\Resources\Admin;

use App\Enums\CategoryLevels;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            "name" => $this->name,
            "slug" => $this->slug,
            "level" => CategoryLevels::getLevels($this->level),
            "parent_id" => $this->parent_id,
            "order" => $this->order,
            "active" => $this->is_active == true ? "on" : "off"
        ];
    }
}
