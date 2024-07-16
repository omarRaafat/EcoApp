<?php

namespace App\Http\Resources\Api;

use App\Http\Resources\Api\ProductResources\ProductHomeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceCategoryHomeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'services' => ProductHomeResource::collection(
                $this->services()
                    ->available()
                    ->limit(10)
                    ->get()
            ),
            "service_image" => [
                "full" => $this->image_url,
                "thumb" => $this->image_url_thumb
            ],
            "best_sell_service_id" => $this->yesterdayBestSales?->service_id,
        ];
    }
}
