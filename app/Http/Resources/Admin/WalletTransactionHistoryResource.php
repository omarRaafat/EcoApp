<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class WalletTransactionHistoryResource extends JsonResource
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
            "customer" => [
                "id" => $this->customer->id,
                "name" => $this->customer->name
            ],
            "wallet_id" => $this->wallet->id,
            "type" => $this->type,
            "amount" => $this->amount,
            "created_at" => $this->created_at
        ];
    }
}
