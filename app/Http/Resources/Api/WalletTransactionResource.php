<?php

namespace App\Http\Resources\Api;

use Carbon\Carbon;
use App\Enums\WalletTransactionTypes;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletTransactionResource extends JsonResource
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
            "code" => $this->id,
            'transaction_type' => __('api.wallet-transaction-types.'. $this->transaction_type),
            "type" => $this->type,
            "amount" => $this->amount_with_sar,
            "date" => Carbon::parse($this->created_at)->format('Y/m/d')
        ];
    }
}
