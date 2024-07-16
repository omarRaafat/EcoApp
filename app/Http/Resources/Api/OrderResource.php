<?php

namespace App\Http\Resources\Api;
use App\Http\Resources\Api\OrderProductResource;
use App\Models\Order;
use App\Models\Transaction;
use App\Services\Invoices\NationalTaxInvoice;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'code' => $this->code,
            'status' => $this->status,
//            'city' => ['id' => $this->transaction->city_id , 'name' => $this->transaction->city->name ],

            // 'city_id' => $this->transaction->city_id,
            'statuses' => $this->getStatuses(),
            'inv_url' => $this->saveOrderPdfAndReturnPath(),
            'products' => OrderProductResource::collection($this->products),

        ];
    }
}
