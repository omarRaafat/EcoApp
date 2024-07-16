<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceReviewResource extends JsonResource
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
            "id" => $this->id,
            "name" => $this->user ? $this->user->getFirstAndLastName() : "",
            "image" => url($this->user ? $this->user->avatar : '' ),
            'rating'=> [
                'value'=> (float)number_format($this->rate, 1)?? 0
            ],
            "time" => $this->created_at->diffForHumans(),
            "Comment" => $this->comment
        ];
    }
}
