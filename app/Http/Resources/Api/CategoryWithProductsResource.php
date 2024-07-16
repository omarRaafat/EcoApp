<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryWithProductsResource extends JsonResource
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
            'image' =>'',
            'level' => $this->level,
            'parent_id' => $this->parent_id,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at->format('d-m-Y'),
            'products' => ProductResource::collection(
                $this->products()
                    ->whereHas('warehouseStock' , function($q){
                        $q->where('stock' , '>' , 0);
                    })->withAvg('reviews','rate')
                    ->withSum('orderProducts','quantity')
                    ->withCount('reviews')
                    ->available()
                    ->limit(10)
                    ->get()
            ),
            "product_image" => [
                "full" => $this->image_url,
                "thumb" => $this->image_url_thumb
            ],
            "best_sell_product_id" => $this->yesterdayBestSales?->product_id,
        ];
    }
}
