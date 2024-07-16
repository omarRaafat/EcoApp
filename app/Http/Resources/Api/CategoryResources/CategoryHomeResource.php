<?php

namespace App\Http\Resources\Api\CategoryResources;

use App\Http\Resources\Api\ProductResources\ProductHomeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryHomeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'level' => $this->level,
            'products' => ProductHomeResource::collection(
                $this->products()
                    ->without(['productClass'])
                    ->whereHas('warehouseStock', function ($q) {
                        $q->where('stock', '>', 0);
                    })
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
