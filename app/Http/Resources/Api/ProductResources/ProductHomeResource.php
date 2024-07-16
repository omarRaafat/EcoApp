<?php

namespace App\Http\Resources\Api\ProductResources;

use App\Enums\ProductStock;
use App\Models\FavoriteProduct;
use App\Services\Eportal\Connection;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductHomeResource extends JsonResource
{
    public function toArray($request)
    {
        $isFav = null;
        if(auth('api_client')->check()){
            $isFav = FavoriteProduct::query()->where('user_id' ,auth('api_client')->user()->id)->where('product_id' , $this->id)->first();
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_low_stock' => ($this->stock ?? 0) <= ProductStock::LOW_STOCK,
            'is_low_stock_label' => __("api.low-stock-label"),
            'is_out_of_stock' => ($this->stock ?? 0) <= 0,
            'is_out_of_stock_label' => __("api.out-of-stock-label"),
            'image' => $this->square_image_small,
            'vendor' => $this->vendor->name ?? '',
            'price' => $this->price_in_sar_rounded,
            'price_before_offer' => $this->price_before_offer,
            'rate' => [
                'value' => (float) number_format($this->rate, 1) ?? 0,
            ],
            'is_favorite' => !is_null($isFav) ? 1 : 0,
            'total_weight_label' => $this->total_weight_label,
            'quantity_type' => ($this->quantity_type) ? $this->quantity_type->name : null,
        ];
    }
}
