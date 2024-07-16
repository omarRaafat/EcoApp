<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\VendorResource;
use Illuminate\Support\Facades\Storage;

class SliderImageResource extends JsonResource
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
            'name' => $this->getTranslation("name", app()->getLocale()),
            'category' => $this->getTranslation("category", app()->getLocale()),
            'offer' => $this->getTranslation("offer", app()->getLocale()),
            'thumb_image' => ossStorageUrl($this->image),
            'cover_image' => ossStorageUrl($this->image),
            'url' => $this->url,
        ];
    }
}
