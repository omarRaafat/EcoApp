<?php
namespace App\Integrations\Shipping\Integrations\Spl;

use App\Models\Order;
use Exception;
use App\Models\OrderShip;
use App\Models\Warehouse;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use App\Events\Warehouse\CreateBezzShippingApiCall;
use App\Integrations\Shipping\Integrations\Spl\Login;
use App\Exceptions\Integrations\Shipping\ErrorWhileLogin;
use App\Integrations\Shipping\Integrations\Traits\Logger;
use App\Exceptions\Integrations\Shipping\Spl\ShipmentNotCreated;
use App\Services\Packages\Barcode;
use Illuminate\Support\Facades\Storage;
use App\Models\OrderShipFail;
use App\Actions\ApiRequestAction;

class CreateShipment
{
    use Logger;
    public $orderVendorShipping;
    public $warehouse;


    const ENDPOINT = "api/CreditSale/AddUPDSPickupDelivery";

    const LOG_CHANNEL = "spl-shipping";

    public function __invoke(Order $order , $orderVendorShipping , $shipping_method_id)
    {
        if($order->orderShip){
            return ['status' => false, 'message' => 'تم إرسال الشحنة مسبقا!'];
        }

        $accessToken = (new Login)();
        $this->orderVendorShipping = $orderVendorShipping ;

        $this->warehouse = $orderVendorShipping->orderVendorWarehouses()->where('shipping_method_id' , $shipping_method_id)->first()->warehouse;

        $data = $this->prepareShipmentInfo($order,$this->warehouse);
//        dd($data);
        $this->logger(self::LOG_CHANNEL, "SPL:CreateShipmentRequest", $data, false);

        $url = config("shipping.spl.base_api_url").self::ENDPOINT;
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => "Bearer $accessToken"
        ])
        ->post($url, $data);

        
        resolve(ApiRequestAction::class)->handle([
            'name' => 'SPLCreateShipment',
            'model_name' => 'Order',
            'model_id' => $order->id,
            'client_id' => $order->transaction->customer_id,
            'url' => $url,
            'req' => json_encode($data),
            'res' => $response->getBody()->getContents(),
            'http_code' => $response->status(),
        ]);

        $responseObject = (object) $response->json();

        //$this->logger(self::LOG_CHANNEL, "SPL:CreateShipmentResponse", ['response' => $responseObject], $response->failed());

        if($response->successful() && isset($responseObject->Status) && $responseObject->Status == 1) {
            $message = [
                'message' => 'created order',
                'trackingnumber' => $responseObject->Items[0]["Barcode"],
            ];
            OrderShipFail::where('order_id',$order->id)->update(['is_active'=>0]);

        } else {
            OrderShipFail::create([
                'order_id'=> $order->id,
                'orderVendorShipping_id'=> $orderVendorShipping->id,
                'shipping'=> 'spl',
                'req' =>  json_encode($data),
                'res' =>  $response,
            ]);
            
            $message = [
                'message' => 'لم يتم إنشاء الشحنة، '. ($responseObject->Message ?? ''),
                'trackingnumber' => "",
            ];
            $this->logger(self::LOG_CHANNEL, "SPL:" . $message['message'] , $message, $response->failed());

            $msg = $responseObject->Items[0]["Message"] ?? ($responseObject->Message ?? $response);

           

            return ['status' => false , 'message' => "شروط شحن الطلب ليست كما هو متوقع، رسالة سبل: $msg" ];


//            throw new ShipmentNotCreated("Order Shipment conditions not as expected, SPL Message: $msg");
        }

        $this->logger(self::LOG_CHANNEL, "SPL:" . $message['message'] , $message, $response->failed());

        $orderShip = $this->_createOrderShip(
            $this->orderVendorShipping->order,
            $responseObject->Items[0]["Barcode"],
        );
        return ['status' => true , 'data' => $orderShip];

//        event(new CreateBezzShippingApiCall($order->transaction));
    }

    /**
     * @param Order $order
     * @param string $tracking_id
     * @return OrderShip
     */
    private function _createOrderShip(Order $order, string $tracking_id) : OrderShip
    {
        return $order->orderShip()->updateOrCreate([
            'gateway_tracking_id'=>$tracking_id
         ],[
             "reference_model" => get_class($order),
             "reference_model_id" => $order->id,
             "gateway_tracking_id" => $tracking_id,
             "gateway_tracking_url" => $this->_generateWaybillPdf($order, $tracking_id)
         ]);

    }

    /**
     * @param Transaction $order->transaction
     * @param Warehouse $warehouse
     * @return array
     */
    private function prepareShipmentInfo(Order $order, Warehouse $warehouse) : array
    {
        return [
            "CRMAccountId" => config("shipping.spl.crm_account_id"),
            "BranchId" => $warehouse->splInfo->branch_id,
            "PickupType" => 1,
            "RequestTypeId" => 1,
            "CustomerName" => $order->transaction->client->name,
            "CustomerMobileNumber" => Str::replace("+", "", $order->transaction->client->phone), // remove the + sign as document say numbers only
            "SenderName" => $warehouse->administrator_name,
            "SenderMobileNumber" => Str::replace("+", "", $warehouse->administrator_phone), // remove the + sign as document say numbers only,
            "Items" => [
                [
                    "ReferenceId" => $order->code,
                    "PaymentType" => 1, // paid
                    "ContentPrice" => number_format(($order->transaction->sub_total ?? 0) + ($order->transaction->total_vat ?? 0), 2),
                    "ContentDescription" => "Dates",
                    "Weight" => $this->orderVendorShipping->total_weight ,
                    "SenderAddressDetail" => [
//                        "AddressTypeID" => 2,
//                        "LocationId" => 3, // warehouse city id
//                        "ZipCode" => 12271,
//                        "BuildingNo" => 2222,
//                        "UnitNo" => 2222,
//                        "AdditionalNo" => 2222,
                        'AddressTypeID' => 6,
                        "LocationId"    => $warehouse->cities()->first()->spl_id,
                        "Latitude" => $warehouse->latitude,
                        "Longitude" => $warehouse->longitude,
                        "AddressLine1"  => $warehouse->getTranslation('address','ar'),
                        "AddressLine2"  => $warehouse->getTranslation('address','ar')
                    ],
                    "ReceiverAddressDetail" => [
//                        "AddressTypeID" => 6,
//                        "BuildingNo" => 2222,
//                        "UnitNo" => 2222,
//                        "AdditionalNo" => 2222,
//                        "ZipCode" => 12271,
//                        "AddressLine1" => $order->transaction->city->name,
//                        "AddressLine2" => $order->transaction->city->name,
//                        "LocationId" => $order->transaction->city->id,
                        'AddressTypeID' => 6,
                        "LocationId"    => $order->transaction->city->spl_id,
                        "AddressLine1"  => $order->transaction->city->name,
                        "AddressLine2"  => $order->transaction->city->name,
                       // "Longitude"     => $order->transaction->city->longitude,
                       // "Latitude"      => $order->transaction->city->latitude,
                    ]
                ]
            ]
        ];
    }

    /**
     * @param Order $order
     * @param string $tracking_id
     * @return string
     */
    public function _generateWaybillPdf(Order $order, string $tracking_id) : string
    {
        if($order->orderShip && $order->orderShip->gateway_tracking_url) {
            return $order->orderShip->gateway_tracking_url;
        }
        ob_start();
        imagepng(Barcode::generate($tracking_id));
        $barcodeImage = ob_get_contents();
        ob_end_clean();

        $warehouse = $this->warehouse;
        $orderVendorShipping = $this->orderVendorShipping;
        // dd($warehouse);
        $pdf = \PDF::loadView(
            'integrations.spl_waybill_pdf', compact("order", "tracking_id", "warehouse", "barcodeImage" , "orderVendorShipping")
        );

        $fileName = $tracking_id . "_" . $order->id . "_" . time() . ".pdf";
        $path = "spl_waybill/" . $fileName;
        // dd('wwww');

        Storage::disk('oss')->put("public/$path", $pdf->output());

        return Storage::disk('oss')->url("public/$path");
    }
}
