<?php

namespace App\Jobs;

use App\Models\Order;
use App\Enums\OrderStatus;
use Illuminate\Bus\Queueable;
use App\Enums\OrderShipStatus;
use App\Models\OrderShipStatusLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class CheckOrderAramexStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
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
                "GetLastTrackingUpdateOnly"=> false,
                "Shipments" => [
                    $this->order->orderShip->gateway_tracking_id
                ],
                "Transaction" => [
                    "Reference1" => $this->order->id,
                    "Reference2" => $this->order->code,
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

            if($response->successful())
            {
                if(isset(json_decode($resBody)->TrackingResults) && isset(json_decode($resBody)->TrackingResults[0])){
                    $statuses = json_decode($resBody)->TrackingResults[0]->Value;
                    $statusPickedUp = null;
                    $statusIN_SHIPPING = null;
                    $statusCOMPLETED = null;

                    foreach ($statuses as $key => $item) {
                        if(in_array($item->UpdateCode, ['SH047', "SH012"])){
                            $statusPickedUp = "PickedUp";
                        }
                        if (in_array($item->UpdateCode, [
                            "SH001",
                            "SH002",
//                            "SH003",
//                            "SH022",
//                            "SH033",
//                            "SH044",
//                            "SH070",
//                            "SH076",
//                            "SH077",
//                            "SH110",
//                            "SH249",
//                            "SH259",
//                            "SH164",
//                            "SH260",
//                            "SH270",
//                            "SH271",
//                            "SH273",
//                            "SH295",
//                            "SH296",
//                            "SH369",
                        ])) {
                            $statusIN_SHIPPING = OrderStatus::IN_SHIPPING;
                        }
                        if(in_array($item->UpdateCode,["SH005","SH496","SH006"])){
                            $statusCOMPLETED = OrderStatus::COMPLETED;
                        }
                    }

                    $status = null;
                    if($statusCOMPLETED){
                        // UPDATE DELIVERY TIMESTAMP
                        $status=  $statusCOMPLETED;
                        // UPDATE DELIVERY TIMESTAMP IF IT IS DELIVERED
                        $orderShipStatus = 'delivered';
                    }elseif ($statusIN_SHIPPING) {
                        $status=  $statusIN_SHIPPING;
                        $orderShipStatus = 'confirmed';
                    }
                    elseif ($statusPickedUp) {
                        $status=  $statusPickedUp;
                        $orderShipStatus = OrderStatus::PICKEDUP;
                    }

                    if ($status && $status != $this->order->status) {


                        if(!in_array($this->order->status,[OrderStatus::REFUND,OrderStatus::COMPLETED,OrderStatus::CANCELED])){
                            OrderShipStatusLog::create([
                                'order_id' => $this->order->id,
                                'old_status' => $this->order->status,
                                'new_status' => $status,
                            ]);

                            $this->order->update(['status' => $status]);

                            #update orderVendorShippings
                            $this->order->orderVendorShippings()->update(['status' => $status]);
                            #update orderShip
                            $this->order->orderShip()->update(['status' => $orderShipStatus]);
                            #update transaction
                            $transaction = $this->order->transaction;
                            if ($transaction->orders()->whereNotIn('status', ['completed'])->doesntExist() ||
                                $transaction->orders()->whereIn('status', ['completed', 'canceled'])->count() === $transaction->orders()->count() ||
                                $transaction->orders()->whereIn('status', ['completed', 'refund'])->count() === $transaction->orders()->count()) {
                                $transaction->update(['status' => 'completed']);
                            }

                            // UPDATE ORDER DELIVERY TIME
                            if($status == OrderStatus::COMPLETED){
                                $this->order->update(['delivered_at' => now()]);
                            }

                            if ($status == OrderStatus::PICKEDUP && is_null($this->order->pickup_at)) {
                                $this->order->update(['pickup_at' => now()]);
                            }
                        }else{
                            OrderShipStatusLog::create([
                                'order_id' => $this->order->id,
                                'old_status' => $this->order->status,
                                'new_status' => $status,
                                'status' => 'not_applied',
                            ]);
                        }
                    }
                }

            }

        } catch (\Throwable $th) {
            report($th);
        }
    }
}
