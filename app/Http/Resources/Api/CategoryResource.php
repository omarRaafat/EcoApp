<?php

namespace App\Http\Resources\Api;

use App\Enums\CategoryLevels;
use App\Models\Category;
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
            'id' => $this->id,
            'name' => $this->name,
            'parent_name' => $this->parent ? $this->parent?->name : "",
            'slug' => $this->slug,
            'level' => $this->level,
            'parent_id' => $this->parent_id,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at->format('d-m-Y'),
            'child' => CategoryResource::collection($this->child),
            "best_sell_product_id" => $this->yesterdayBestSales?->product_id,
            'products_count' => $this->getProductsCount(),
        ];
    }

    public function resolve($request = null)
    {
        if(is_null($this->resource))
            return [];
        else
            return $this->toArray($this->resource);
    }

    private function getProductsCount() {
        return match($this->level) {
            CategoryLevels::PARENT => $this->category_product_count,
            CategoryLevels::CHILD => $this->sub_category_product_count,
            CategoryLevels::SUBCHILD => $this->final_category_product_count,
            default => 0
        };
    }
}
