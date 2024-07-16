<?php

namespace App\Http\Resources\Api;

use App\Enums\ProductStock;
use App\Models\FavoriteProduct;
use App\Models\ProductImage;
use App\Services\Eportal\Connection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;

class SingleProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $images = ProductImageResource::collection($this->images->where('is_accept',1))->toArray($request);

        array_unshift( $images ,[
            'id' => $this->id,
            'product_id' => $this->id,
            'url' => $this->square_image
        ]);

        $isFav = null;

        if (Route::currentRouteName() != 'paymant-callback') {
            if(auth('api_client')->check()){
                $isFav = FavoriteProduct::query()->where('user_id' ,auth('api_client')->user()->id)->where('product_id' , $this->id)->first();
            }
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'desc' => $this->desc,
            'details' => strip_tags($this->desc),
            'currency' => "SR",// static from backend till change currency business (for webengage usage)
            'image' => $this->square_image,
            'is_active' => $this->is_active,
            'status' => $this->status,
            'total_weight' => $this->total_weight,
            'net_weight' => $this->net_weight,
            'barcode' => $this->barcode,
            'length' => $this->length,
            'width' => $this->width,
            'height' => $this->height,
            'price' => $this->price_in_sar_rounded,
            'price_before_offer' => $this->price_before_offer,
            'order' => $this->order,
            'expire_date' => $this->expire_date,
            'quantity_bill_count' => $this->quantity_bill_count,
            'bill_weight' => $this->bill_weight,
            'category_id' => $this->category_id,
            'quantity_type_id' => $this->quantity_type_id,
            'type_id' => $this->type_id,
            'is_visible' => $this->is_visible,
            'vendor_id' => $this->vendor_id,
            'vendor' => $this->vendor->name ?? '',
            'certificates'=> CertificateResource::collection($this->vendor->approved_certificates   ),
            'created_at' => $this->created_at->format("d-m-Y"),
            'product_class_id' =>  $this->type_id,
            'rate' => [
                'value' => (float)number_format($this->rate, 1)?? 0,
            ],
            'reviews_count' =>$this->reviews_conunt ?? 0 ,
            'category' => ($this->category) ? $this->category->name : null,
            'type' => ($this->type) ? $this->type->name : null,
            'quantity_type' => ($this->quantity_type) ? $this->quantity_type->name : null,
            'images' => $images,
            'reviews' => ProductReviewResource::collection($this->approvedReviews),
            'is_favorite' => !is_null($isFav) ? 1 : 0,
            'available' => ($this->deleted_at || ($this->is_active !=1 || $this->status !='accepted')? 0 : 1),
            'product_classes'=> ProductClassRepsource::collection($this->product_classes),
            'total_weight_label' => $this->total_weight_label,
            'net_weight_label' => $this->net_weight_label,
            'stock' => $this->stock ?? 0,
            'is_low_stock' => ($this->stock ?? 0) <= ProductStock::LOW_STOCK,
            'is_low_stock_label' => __("api.low-stock-label"),
            'is_out_of_stock' => ($this->stock ?? 0) <= 0,
            'is_out_of_stock_label' => __("api.out-of-stock-label"),
        ];
    }
}
