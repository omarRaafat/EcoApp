<?php

namespace App\Http\Resources\Api;

use App\Enums\ServiceStock;
use App\Models\FavoriteService;
use App\Models\PostHarvestServicesDepartmentField;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $images = ServiceImageResource::collection($this->images)->toArray($request);

        array_unshift( $images ,[
            'id' => $this->id,
            'service_id' => $this->id,
            'url' => $this->square_image
        ]);

        $isFav = null;
        if(auth('api_client')->check()){
            $isFav = FavoriteService::query()->where('user_id' ,auth('api_client')->user()->id)->where('service_id' , $this->id)->first();
        }

        $price = $this->calculateTotalPrice();
        $price_without_dropdown = $this->calculateTotalPriceWithoutDropDown();

        $not_depends_fields = PostHarvestServicesDepartmentField::where('post_harvest_id', $this->category_id)
        ->where('depends_on_price', false)
        ->where('status', 'active')
        ->get();

        $transformed_fields = $not_depends_fields->map(function ($field) {
            return [
                "id" => $field->id,
                "category_id" => $field->post_harvest_id,
                "name" => $field->name,
                "type" => $field->type,
                "is_required" => $field->required,
                "values" => $field->values,
            ];
        });

        return [
            'id' => $this->id,
            'name' => $this->name,
            'desc' => $this->desc,
            'conditions' => $this->conditions,
            'details' => strip_tags($this->desc),
            'image' => $this->square_image_small,
            'is_active' => $this->is_active,
            'status' => $this->status,
            'category_id' => $this->category_id,
            'is_visible' => $this->is_visible,
            'vendor_id' => $this->vendor_id,
            'vendor' => $this->vendor->name ?? '',
            'created_at' => $this->created_at->format("d-m-Y"),
            'category' => ($this->category) ? $this->category->name : null,
            'images' => $images,
            'price' => $price,
            'price_without_dropdown' => $price_without_dropdown,
            'rate' => [
                'value' => (float)number_format($this->rate, 1)?? 0,
            ],
            'is_favorite' => !is_null($isFav) ? 1 : 0,
            'reviews_count' =>$this->reviews_count ?? 0 ,
            'available' => ($this->deleted_at || ($this->is_active !=1 || $this->status !='accepted')? 0 : 1),
            'fields' => ($this->fields) ? ServiceFieldResource::collection($this->fields) : null,
            'not_depends_fields' => $transformed_fields->isNotEmpty() ? $transformed_fields->toArray() : null,
            'cities' => ($this->cities) ? CityResource::collection($this->cities) : null,
        ];
    }
}
