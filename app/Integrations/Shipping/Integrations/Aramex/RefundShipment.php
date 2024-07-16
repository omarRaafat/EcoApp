<?php

namespace App\Integrations\Shipping\Integrations\Aramex;

use App\Exceptions\Integrations\Shipping\Aramex\ShipmentNotCreated;
use App\Integrations\Shipping\Integrations\Traits\Logger;
use App\Models\Order;
use App\Models\OrderShip;
use App\Models\Transaction;
use App\Models\Warehouse;
use http\Env\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Octw\Aramex\Aramex;
use function PHPUnit\Framework\isEmpty;
use Carbon\Carbon;
use App\Models\OrderShipFail;
use App\Actions\ApiRequestAction;

class RefundShipment
{
    use Logger;

    const LOG_CHANNEL = "aramex-shipping";

    public $orderVendorShipping;
    public $warehouse;

    /**
     * @param Order $order
     * @param $orderVendorShipping
     * @param $shipping_method_id
     * @return array|void
     */
    public function __invoke(Order $order , $orderVendorShipping , $shipping_method_id)
    {
        try {
            $this->orderVendorShipping = $orderVendorShipping ;
            $this->warehouse = $orderVendorShipping->orderVendorWarehouses()->where('shipping_method_id' , $shipping_method_id)->first()->warehouse;
            $data = $this->preparePickupData($order, $this->warehouse);

            $url = config('shipping.aramex.ARAMEXPICKUPURL');
            $responseee = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ])->post($url, $data);

            resolve(ApiRequestAction::class)->handle([
                'name' => 'AramexRefundShipment',
                'model_name' => 'Order',
                'model_id' => $order->id,
                'client_id' => $order->transaction->customer_id,
                'url' => $url,
                'req' => json_encode($data),
                'res' => $responseee->getBody()->getContents(),
                'http_code' => $responseee->status(),
            ]);

            if (!$responseee->successful()
                    || empty($responseee->json())
                    || (isset($responseee->json()['HasErrors']) && $responseee->json()['HasErrors'])
                    || (isset($responseee->json()['ProcessedPickup']['ProcessedShipments'][0]['HasErrors']) && $responseee->json()['ProcessedPickup']['ProcessedShipments'][0]['HasErrors'] )
            ){
                OrderShipFail::create([
                    'order_id'=> $order->id,
                    'orderVendorShipping_id'=> $orderVendorShipping->id,
                    'shipping'=> 'aramex',
                    'req' =>  json_encode($data),
                    'res' =>  $responseee,
                ]);
            }
            if (empty($responseee->json())) {
                return ['status' => false, 'message' => 'خطأ فى شحن أرامكس !'];
            }
            if (isset($responseee->json()['HasErrors']) && $responseee->json()['HasErrors']) {
                if ($responseee->json()['Notifications'][0]['Code'] != "ERR83") {
                    return [
                        'status' => false,
                        'message' => $responseee->json()['Notifications'][0]['Code'].":".$responseee->json()['Notifications'][0]['Message']
                    ];
                } else {
                    session()->flash("shipment.should.delivered",__("translation.drop_the_shipment_to_nearest_pickup_outlet"));
                }
            }

            if ($responseee->successful()) {
                $guid = null;
                if (isset($responseee->json()['ProcessedPickup']['GUID'])) {
                    $guid       = $responseee->json()['ProcessedPickup']['GUID'];
                }

                if(isset($responseee->json()['ProcessedPickup']['ProcessedShipments'][0]['HasErrors']) && $responseee->json()['ProcessedPickup']['ProcessedShipments'][0]['HasErrors']){
                    return ['status' => false , 'message' => $responseee->json()['ProcessedPickup']['ProcessedShipments'][0]['Notifications'][0]['Code'] . ':' . $responseee->json()['ProcessedPickup']['ProcessedShipments'][0]['Notifications'][0]['Message']];
                }

                if (isset($responseee->json()['ProcessedPickup']['ProcessedShipments'][0]['ID']) && !empty($responseee->json()['ProcessedPickup']['ProcessedShipments'][0]['ID'])) {
                    OrderShipFail::where('order_id',$order->id)->update(['is_active'=>0]);

                    $dataPrintLabel = $this->preparePrintLabel($responseee->json()['ProcessedPickup']['ProcessedShipments'][0]['ID'] , $order);
                    
                    $url = config('shipping.aramex.ARAMEXPRINTLABELURL');
                    $response = Http::withHeaders([
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json'
                    ])->post($url, $dataPrintLabel);

                    resolve(ApiRequestAction::class)->handle([
                        'name' => 'AramexPrintLabelAfterRefundShipment',
                        'model_name' => 'Order',
                        'model_id' => $order->id,
                        'client_id' => $order->transaction->customer_id,
                        'url' => $url,
                        'req' => json_encode($dataPrintLabel),
                        'res' => $response->getBody()->getContents(),
                        'http_code' => $response->status(),
                    ]);

                    if(isset($response->json()['HasErrors']) && $response->json()['HasErrors']){
                        return ['status' => false , 'message' => $response->json()['Notifications'][0]['Code'] . ":" . $response->json()['Notifications'][0]['Message']];
                    }

                    if($response->successful()){
                        $orderShip = $this->_createOrderShip(
                            $this->orderVendorShipping->order,
                            $responseee->json()['ProcessedPickup']['ProcessedShipments'][0]['ID'],
                            $response->json()['ShipmentLabel']['LabelURL'],
                            [
                                'GUID' => $guid,
                                'ShipmentNumber' => $responseee->json()['ProcessedPickup']['ProcessedShipments'][0]['ID'],
                                'LabelURL' => $response->json()['ShipmentLabel']['LabelURL'],
                            ]
                        );

                        return ['status' => true , 'data' => $orderShip];
                    }
                } else {
                    return ['status' => false , 'message' => 'منصة مزارع - خطا إرسال شحنة !'];
                }
            }

        } catch (\Throwable $th) {
            report( $th);
            return ['status' => false , 'message' => 'منصة مزارع - خطا إرسال شحنة !'];
        }

    }


    /**
     * @param  Order $order
     * @param  string $tracking_id
     * @param  string $LabelURL
     * @param  array $extra_data
     * @return OrderShip
     */
    private function _createOrderShip(Order $order, string $tracking_id , string $LabelURL , array $extra_data = []): OrderShip
    {
        return OrderShip::updateOrCreate([
            'gateway_tracking_id' => $tracking_id
        ], [
            "reference_model" => get_class($order),
            "reference_model_id" => $order->id,
            "gateway_tracking_id" => $tracking_id,
            "gateway_tracking_url" => $LabelURL,
            "gateway_order_id" => $order->id,

            "extra_data" => json_encode($extra_data),
        ]);
    }

    /**
     * @param  Order $order
     * @param  Warehouse $warehouse
     * @return array
     */
    public function preparePickupData(Order $order , Warehouse $warehouse): array
    {
        //date
        $baseDate = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d 15:00:00'));
        if (now()->hour > 15) {
            $baseDate->addDay();
        }
        if ($baseDate->isFriday()) {
            $baseDate->addDay();
        } elseif ($baseDate->isSaturday()) {
          //  $baseDate->addDay();
        }
        $timestamp = $baseDate->timestamp;
        $date = "/Date(" . ($timestamp * 1000) . "-0500)/";

        //date to
        $baseDate->addDays(4);
        if ($baseDate->isFriday()) {
            $baseDate->addDay();
        }
        $timestamp = $baseDate->timestamp;
        $dateClose = "/Date(". ($timestamp * 1000) ."-0500)/";

        $warehouseCity = $warehouse->cities()->first()->getTranslation('name','en');
        $PaymentType = ($warehouseCity != 'Riyadh') ? "3" : "P";

        $englishAddress = $warehouseCity .', Saudi Arabia';

        return [
            "ClientInfo" => $this->clientInfo(),
            "LabelInfo" => [
                "ReportID" => 9201,
                "ReportType" => "URL"
            ],
            "Pickup" => [
                "PickupAddress" =>  [
                    "Line1" => $englishAddress,
                    "Line2" => '',
                    "Line3" => '',
                    "City" => $order->transaction->city->getTranslation('name', 'en'),
                    "StateOrProvinceCode" => "",
                    "PostCode" => "",
                    "CountryCode" => config("shipping.aramex.AccountCountryCode"),
                    "Longitude" => 0,
                    "Latitude" => 0,
                    "BuildingNumber" => null,
                    "BuildingName" => null,
                    "Floor" => null,
                    "Apartment" => null,
                    "POBox" => null,
                    "Description" => "",
                ],
                "PickupContact" => [
                    "Department" =>  $order->transaction->client->name,
                    "PersonName" =>   $order->transaction->client->name,
                    "Title" => "",
                    "CompanyName" =>  $order->transaction->client->name,
                    "PhoneNumber1" => "+966" . (int)$order->transaction->client->phone,
                    "PhoneNumber1Ext" => "",
                    "PhoneNumber2" => "",
                    "PhoneNumber2Ext" => "",
                    "FaxNumber" => "",
                    "CellPhone" =>"+966" . (int) $order->transaction->client->phone,
                    "EmailAddress" => 'customer@info.me',
                    "Type" => ""
                ],
                "Shipments" => [
                    [
                        "Reference1" => "",
                        "Reference2" => "",
                        "Reference3" => "",
                        "Shipper" => [
                            "Reference1" => "",
                            "Reference2" => "",
                            "AccountNumber" => config("shipping.aramex.AccountNumber"),
                            "PartyAddress" =>  [
                                "Line1" => $englishAddress,
                                "Line2" => "",
                                "Line3" => "",
                                "City" => $order->transaction->city->getTranslation('name', 'en'),
                                "StateOrProvinceCode" => "",
                                "PostCode" => "", //$warehouse->cities()->first()->postcode,
                                "CountryCode" => config("shipping.aramex.AccountCountryCode"),
                                "Latitude" => 0, //$warehouse->latitude,
                                "Longitude" => 0, //$warehouse->longitude,
                                "BuildingNumber" => null,
                                "BuildingName" => null,
                                "Floor" => null,
                                "Apartment" => null,
                                "POBox" => null,
                                "Description" => null,
                            ],
                            "Contact" =>  [
                                "Department" => "",
                                "PersonName" => $warehouse->administrator_name,
                                "Title" => "",
                                "CompanyName" => $warehouse->vendor->name,
                                "PhoneNumber1" => "+966" . (int)$warehouse->administrator_phone,
                                "PhoneNumber1Ext" => "",
                                "PhoneNumber2" => "",
                                "PhoneNumber2Ext" => "",
                                "FaxNumber" => "",
                                "CellPhone" => "+966" . (int)$warehouse->administrator_phone,
                                "EmailAddress" => $warehouse->administrator_email,
                                "Type" => "",
                            ]
                        ],
                        "ThirdParty" => [
                            "Reference1" => "",
                            "Reference2" => "",
                            "AccountNumber" => config("shipping.aramex.AccountNumber"),
                            "PartyAddress" =>  [
                                "Line1" => $englishAddress,
                                "Line2" => "",
                                "Line3" => "",
                                "City" => $warehouse->cities()->first()->getTranslation('name','en'),
                                "StateOrProvinceCode" => "",
                                "PostCode" => "",//$warehouse->cities()->first()->postcode,
                                "CountryCode" => config("shipping.aramex.AccountCountryCode"),
                                "Latitude" => 0, //$warehouse->latitude,
                                "Longitude" => 0, //$warehouse->longitude,
                                "BuildingNumber" => null,
                                "BuildingName" => null,
                                "Floor" => null,
                                "Apartment" => null,
                                "POBox" => null,
                                "Description" => null,
                            ],
                            "Contact" =>  [
                                "Department" => "",
                                "PersonName" => $warehouse->administrator_name,
                                "Title" => "",
                                "CompanyName" => $warehouse->vendor->name,
                                "PhoneNumber1" => "+966" . (int)$warehouse->administrator_phone,
                                "PhoneNumber1Ext" => "",
                                "PhoneNumber2" => "",
                                "PhoneNumber2Ext" => "",
                                "FaxNumber" => "",
                                "CellPhone" => "+966" . (int)$warehouse->administrator_phone,
                                "EmailAddress" => $warehouse->administrator_email,
                                "Type" => "",
                            ]
                        ],
                        "Consignee"=> [
                            "Reference1"=> "",
                            "Reference2"=> "",
                            "AccountNumber"=> config("shipping.aramex.AccountNumber"),
                            "PartyAddress"=> [
                                "Line1"=>  $englishAddress,
                                "Line2"=> "",//$order->transaction->city->getTranslation('name','en'),
                                "Line3"=> "",// $order->transaction->city->getTranslation('name','en'),
                                "City"=> $warehouseCity,
                                "StateOrProvinceCode" => "",
                                "PostCode" => $order->transaction->city->postcode,
                                "CountryCode"=> config("shipping.aramex.AccountCountryCode"),
                                "Longitude"=> $order->transaction->city->longitude,
                                "Latitude"=> $order->transaction->city->latitude,
                                "BuildingNumber" => "",
                                "BuildingName" => "",
                                "Floor" => "",
                                "Apartment" => "",
                                "POBox" => null,
                                "Description" => 'أيام العمل:' . $warehouse->days . ' ' . $warehouse->time_work_from . '-' . $warehouse->time_work_to,
                            ],
                            "Contact" =>  [
                                "Department" => $warehouse->name,
                                "PersonName" =>  $warehouse->administrator_name,
                                "Title" => "",
                                "CompanyName" => $warehouse->administrator_name,
                                "PhoneNumber1" => "+966" . (int)$warehouse->administrator_phone,
                                "PhoneNumber1Ext" => "",
                                "PhoneNumber2" => "",
                                "PhoneNumber2Ext" => "",
                                "FaxNumber" => "",
                                "CellPhone" => "+966" . (int)$warehouse->administrator_phone,
                                "EmailAddress" => $warehouse->administrator_email,
                                "Type" => ""
                            ]
                        ],
                        "ShippingDateTime" =>  "/Date(".(time() * 1000)."-0500)/",
                        "DueDate" => "/Date(".(time() * 1000)."-0500)/",
                        "Comments" => "",
                        "PickupLocation" => "",
                        "OperationsInstructions" => "",
                        "AccountingInstrcutions" => "",
                        "Details" => [
                            "Dimensions" => null,
                            "ActualWeight" => [
                                "Unit" => "KG",
                                "Value" => $this->orderVendorShipping->total_weight
                            ],
                            "ChargeableWeight"=> null,
                            "DescriptionOfGoods"=> "Agricultural products",
                            "GoodsOriginCountry"=> strtolower(config("shipping.aramex.AccountCountryCode")),
                            "NumberOfPieces"=> $this->orderVendorShipping->order->no_packages,
                            "ProductGroup"=> config("shipping.aramex.ProductGroup"), // DOM, EXP
                            "ProductType"=>  config("shipping.aramex.ProductType"), // CDS,PDX
                            "PaymentType"=> $PaymentType, //"P",
                            "PaymentOptions"=> "",
                            "CustomsValueAmount"=> null,
                            "CashOnDeliveryAmount"=> null,
                            "InsuranceAmount"=> null,
                            "CashAdditionalAmount"=> null,
                            "CashAdditionalAmountDescription"=> "",
                            "CollectAmount"=> null,
                            "Services"=> "",
                            "Items"=> []
                        ],
                        "Attachments"=> [],
                        "ForeignHAWB"=> "",
                        "TransportType "=> 0,
                        "PickupGUID"=> "",
                        "Number"=> null,
                        "ScheduledDelivery"=> null
                    ]
                ],
                "PickupLocation" => $englishAddress,
                "PickupDate" => $date,
                "ReadyTime" => $date,
                "LastPickupTime" => $date,
                "ClosingTime" => $dateClose,
                "Comments" => "",
                "Reference1" => $order->id,
                "Reference2" => "",
                "Vehicle" => $this->orderVendorShipping->van_type ??  "",
                "PickupItems" => [
                    [
                        "ProductGroup"=> config("shipping.aramex.ProductGroup"), // DOM, EXP
                        "ProductType"=>  config("shipping.aramex.ProductType"), // CDS,PDX
                        "NumberOfShipments" => 1,
                        "PackageType" => "Box",
                        "Payment"=> config("shipping.aramex.PaymentType"), //"P",
                        "ShipmentWeight" => [
                            "Unit" => "KG",
                            "Value" => $this->orderVendorShipping->total_weight
                        ],
                        "ShipmentVolume" => null,
                        "NumberOfPieces" => $this->orderVendorShipping->order->no_packages,
                        "CashAmount" => null,
                        "ExtraCharges" => null,
                        "ShipmentDimensions" => [
                            "Length" => 0,
                            "Width" => 0,
                            "Height" => 0,
                            "Unit" => ""
                        ],
                        "Comments" => "Test"
                    ]
                ],
                "Status" => "Ready",
                "ExistingShipments" => null,
                "Branch" => "",
                "RouteCode" => ""
            ],
            "Transaction" => [
                "Reference1" => "",
                "Reference2" => "",
                "Reference3" => "",
                "Reference4" => "",
                "Reference5" => ""
            ]
        ];
    }

    /**
     * @param  $ShipmentNumber
     * @param  $order
     * @return array
     */
    public function preparePrintLabel($ShipmentNumber , $order): array
    {
        return [
            "ClientInfo" => $this->clientInfo(),
            "LabelInfo" => [
                "ReportID" => 9729,
                "ReportType" => "URL"
            ],
            "OriginEntity"   => "RUH",
            "ProductGroup"=> config("shipping.aramex.ProductGroup"), // DOM, EXP
            "ShipmentNumber" => $ShipmentNumber,
            "Transaction" => [
                "Reference1" => $order->id,
                "Reference2" => $order->code,
                "Reference3" => "",
                "Reference4" => "",
                "Reference5" => ""
            ]
        ];
    }

    /**
     * @return array
     */
    private static function clientInfo() : array
    {
        return [
            "UserName"=> config("shipping.aramex.UserName"),
            "Password"=> config("shipping.aramex.Password"),
            "Version"=> config("shipping.aramex.Version"),
            "AccountNumber"=> config("shipping.aramex.AccountNumber"),
            "AccountPin"=> config("shipping.aramex.AccountPin"),
            "AccountEntity"=> config("shipping.aramex.AccountEntity"),
            "AccountCountryCode"=> config("shipping.aramex.AccountCountryCode"),
            "Source"=> config("shipping.aramex.Source")
        ];
    }

    public function TrackShipments($shipment_number)
    {
        return [
            "ClientInfo" => $this->clientInfo(),
            "GetLastTrackingUpdateOnly"=> false,
            "Shipments"=> [
                $shipment_number
            ],
            "Transaction" => [
                "Reference1" => "",
                "Reference2" => "",
                "Reference3" => "",
                "Reference4" => "",
                "Reference5" => ""
            ]
        ];
    }

    private function removeUnicodeEscapeSequences($str) {
        return preg_replace('/\\\\u([a-fA-F0-9]{4})/', '&#x$1;', $str);
    }


}
