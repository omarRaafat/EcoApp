<?php

namespace App\Http\Resources\Api;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogPostResource extends JsonResource
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
            'title' => $this->title,
            'body' => $this->body,
            'image' => $this->image_url_thumb,
            'cover_image' => $this->image_url_cover,
            'short_desc'=>$this->short_desc,
            'time' => Carbon::parse($this->created_at)->diffForHumans(),
            'date' => Carbon::parse($this->created_at)->format('d-m-Y'),
        ];
    }
}
