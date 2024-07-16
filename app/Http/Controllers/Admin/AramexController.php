<?php

namespace App\Http\Controllers\Admin;

use App\Integrations\Shipping\Shipment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Order;
use App\Enums\ShippingMethods;
use App\Enums\OrderStatus;
use App\Models\OrderShipStatusLog;
use App\Models\OrderShip;

class AramexController
{
    protected $shipmentMethod;

    public function __construct(Shipment $shipment)
    {
        $this->shipmentMethod = $shipment->make(1);
    }

    public function shipping(Request  $request)
    {
        $order = Order::find($request->id);
        return $this->shipmentMethod->createShipment($order, $order->orderShipping, ShippingMethods::ARAMEX);
    }

    public function aramexTest(Request  $request)
    {
        if($request->get('id')){
            $order = Order::whereHas('orderShip')->with('orderShip')->find(intval($request->id));
            if(!$order) return abort(404);

            $data = [
                "ClientInfo" => [
                    "UserName"=> config("shipping.aramex.UserName"),
                    "Password"=> config("shipping.aramex.Password"),
                    "Version"=> config("shipping.aramex.Version"),
                    "AccountNumber"=> config("shipping.aramex.AccountNumber"),
                    "AccountPin"=> config("shipping.aramex.AccountPin"),
                    "AccountEntity"=> config("shipping.aramex.AccountEntity"),
                    "AccountCountryCode"=> config("shipping.aramex.AccountCountryCode"),
                    "Source"=> config("shipping.aramex.Source")
                ],
                "GetLastTrackingUpdateOnly"=> true,
                "Shipments" => [
                    $order->orderShip->gateway_tracking_id
                ],
                "Transaction" => [
                    "Reference1" => $order->id,
                    "Reference2" => $order->code,
                    "Reference3" => "",
                    "Reference4" => "",
                    "Reference5" => ""
                ]
            ];

            $response = Http::withHeaders([
                'Accept' => "application/json",
                'Content-Type' => 'application/json'
            ])->post('https://ws.aramex.net/ShippingAPI.V2/Tracking/Service_1_0.svc/json/TrackShipments', $data);
            
            $resBody = $response->getBody()->getContents();

            if($response->successful()){
                if(isset(json_decode($resBody)->TrackingResults) && isset(json_decode($resBody)->TrackingResults[0])){
                    if(isset(json_decode($resBody)->TrackingResults[0]->Value[0]->UpdateDescription)){
                        return response()->json(['status' => json_decode($resBody)->TrackingResults[0]->Value[0]->UpdateDescription]);
                    }
                }
            }

            return response()->json(['status' => null, 'message' => $resBody]);
        }

       
    }

}
