<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\ProductImageResource;
use App\Http\Resources\Api\ProductReviewResource;

class ProductResource extends JsonResource
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
            'desc' => $this->desc,
            'vendor' => $this->vendor->name,
            'category' => ($this->category) ? $this->category->name : null,
            'image' => $this->square_image_small,
            'is_active' => $this->is_active,
            'status' => $this->status,
            'total_weight' => $this->total_weight,
            'net_weight' => $this->net_weight,
            'barcode' => $this->barcode,
            'length' => $this->length,
            'width' => $this->width,
            'height' => $this->height,
            'price' => $this->price,
            'price_before_offer' => $this->price_before_offer,
            'order' => $this->order,
            'expire_date' => $this->expire_date,
            'quantity_bill_count' => $this->quantity_bill_count,
            'bill_weight' => $this->bill_weight,
            'category_id' => $this->category_id,
            'quantity_type_id' => $this->quantity_type_id,
            'type_id' => $this->type_id,
            'is_visible' => $this->is_visible,
            'created_at' => $this->created_at->format("d-m-Y"),
            'rate' => [
                'value'=> (float)number_format($this->reviews_avg_rate, 1)?? 0,
                ],
            'reviews_count' =>$this->reviews_count ?? 0 ,
            'type' => ($this->type) ? $this->type->name : null,
            'quantity_type' => ($this->quantity_type) ? $this->quantity_type->name : null,
            'images' => ProductImageResource::collection($this->images),
            'reviews' => ProductReviewResource::collection($this->reviews),
        ];
    }
}
