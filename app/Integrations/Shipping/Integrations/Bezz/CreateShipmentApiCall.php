<?php
namespace App\Integrations\Shipping\Integrations\Bezz;

use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Enums\PaymentMethods;
use Illuminate\Support\Facades\Http;
use App\Exceptions\Integrations\Shipping\Bezz\ShipmentNotCreated;
use App\Integrations\Shipping\Integrations\Traits\Logger;

class CreateShipmentApiCall
{
    use Logger;

    /**
     * Api Endpoint to get create shipment.
     */
    const ENDPOINT = "Orders/PostOrder";

    /**
     * Log Channel...
     */
    const LOG_CHANNEL = "bezz-shipping";
    /**
     * sHIPPING TYPE
     */
    const SHIPPING_TYPE = "C";

    /**
     * Create New Shipment.
     */
    public function __invoke(Transaction $transaction) : string
    {
        $warehouse = $transaction->addresses->country->warehouseCountry->warehouse;

        $data = $this->bezzData($transaction,$warehouse);

        $this->logger(self::LOG_CHANNEL, "BEZZ:CreateShipmentRequest", $data, false);

        $response = Http::withHeaders(['Content-Type' => 'application/json', 'Accept' => 'application/json'])
            ->timeout(60)
            ->post(config("shipping.bezz.base_url").self::ENDPOINT,$data);

        $res = (object) $response->json();

        $this->logger(self::LOG_CHANNEL, "BEZZ:CreateShipmentResponse", ['response' => $res], $response->failed());

        if($response->successful() && in_array($response->status(), [200, 201])) {
            $message = [
                'trackingnumber' => $res->scalar,
                'message' => 'created order',
            ];
        } elseif($response->status() == 400 && isset($res->trackingnumber)) {
            $message = [
                'trackingnumber' => $res->trackingnumber,
                'message' => 'Order Number Already Exist',
            ];
        } else {
            $message = [
                'message' => 'Shipment Not Created',
                'trackingnumber' => $data['OrderNumber'] ?? 'SD-'. Str::random(32),
            ];
            $this->logger(self::LOG_CHANNEL, "BEZZ:" . $message['message'] , $message, $response->failed());

            throw new ShipmentNotCreated(
             isset($res->Message) ? $res->Message : "Order Shipment conditions not as expected,".
                " response from bezz must have tracking number".
                " & response status code must be in (200, 201, 400)"
            );
        }

        $this->logger(self::LOG_CHANNEL, "BEZZ:" . $message['message'] , $message, $response->failed());

        return $message['trackingnumber'];
    }

    /**
     * Undocumented function
     *
     * @param [type] $products
     * @return
     */
    private function lineItems($products){

        $array=[];

        foreach($products as $orderProduct){

            $item= [
                "ProductName"=>$orderProduct->product->name,
                "Quantity"=>intval($orderProduct->quantity),
                "SKU"=>$orderProduct->product->sku ? $orderProduct->product->sku  :'Test1',
                "UPC"=>null,
                "GiftWrapping"=> false,
                "Description"=>"With beads and stones",
            ];

            array_push($array,$item);
        }
        return $array;
    }


    /**
     * Undocumented function
     *
     * @param [type] $transaction
     * @param [type] $warehouse
     * @return
     */
    private function bezzData($transaction,$warehouse){
        if ($transaction->payment_method == PaymentMethods::CASH) {
            $cod = $transaction->reminder_in_sar;
        } else {
            $cod = "00.00";
        }

        $data = [
            'LineItems'=>$this->lineItems($transaction->products),
            "Edit" =>false,
            "Payment" =>false,
            "PaymentAmount" =>"00.00",
            "TrackingNumber" =>"",
            'AccountNumber'=>config("shipping.bezz.acccount_number"),
            'ApiKey'=> config("shipping.bezz.api_key"),
            "RequestedBy"=>"Branch #9",
            "OrderNumber" =>$transaction->code, //@todo Change The Order Number from Test to Production Code Transaction
            "Shipping" =>true,
            "ShipmentType" =>"C",
            "CustomerNote"=>"",
            "CustomerEmail" => $transaction->customer->email ? $transaction->customer->email : $transaction->customer->id . config("shipping.bezz.default_customer_email"),
            "Description"=>"",
            "COD" =>$cod,
            "PickupLocation" =>$warehouse->latitude.",".$warehouse->longitude,
            "dimensions" =>null,
            "BillingAddress" =>
            [[
            "CustomerFirstname" =>$transaction->customer->name,
            "CustomerLastname" =>$transaction->customer->name,
            "CustomerPhone1" =>$transaction->customer->phone,
            "CustomerPhone2" =>$transaction->customer->phone,
            "Lat" =>"0.00",
            "Lng" =>"0.00",
            "Line1" =>null,
            "Line2" =>"",
            "District" =>null,
            "City" => null,
            "Province" =>"",
            "PostCode" =>null,
            "Country" =>null
            ]],
            "ShippingAddress"=>[[
            "CustomerFirstname" =>$transaction->addresses->first_name,
            "CustomerEmail" =>null,
            "CustomerLastname" =>$transaction->addresses->first_name,
            "CustomerPhone1" =>$transaction->addresses->phone,
            "CustomerPhone2" =>$transaction->addresses->phone,
            "Lat" =>"0.00",
            "Lng" =>"0.00",
            "Line1" =>$transaction->addresses->description,
            "Line2" =>null,
            "District" =>null,
            "City" =>$transaction->addresses->city ? $transaction->addresses->city->name:null,
            "Province" =>$transaction->addresses->area?$transaction->addresses->area->name:null,
            "PostCode" =>null,
            "Country" =>$transaction->addresses->country ? $transaction->addresses->country->name:null,
            ]]
        ];

        if($transaction->orderShip && $transaction->addresses->is_international) {
            $data["International"] = $transaction->orderShip->gateway_tracking_url;
        }

        return $data;
    }
}
