<?php

namespace App\Http\Resources\Api;

use App\Enums\PaymentMethods;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductsForReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $firstReview = $this?->reviews?->first();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->square_image,
            'is_rated' => $this?->reviews?->isNotEmpty(),
            'rate' => (float) ($firstReview && $firstReview->rate > 0 ? $firstReview->rate : 0),
            'review' => $firstReview->comment ?? "",
        ];
    }
}
