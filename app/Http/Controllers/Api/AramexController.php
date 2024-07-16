<?php

namespace App\Http\Controllers\Api;

use App\Integrations\Shipping\Integrations\Aramex\Aramex;
use App\Integrations\Shipping\Shipment;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class AramexController
{
    protected $shipmentMethod;
    protected $Aramex;

    public function __construct(Shipment $shipment,Aramex $Aramex)
    {
        $this->shipmentMethod = $shipment->make(1);
        $this->Aramex = $Aramex;
    }

    public function shipping(Request  $request)
    {

        $transaction = Transaction::query()->where('id', $request->transaction_id)->first();
        $this->shipmentMethod->createShipment($transaction);
    }


    public function calculateRate(Request $request)
    {
        $order = Order::find(1269);
        $ddd = $this->Aramex->cancelShipment($order);
dd($ddd);
    $calculate_rate_url = "https://ws.dev.aramex.net/ShippingAPI.V2/RateCalculator/Service_1_0.svc/json/CalculateRate";
        $test_url = "https://ws.dev.aramex.net/ShippingAPI.V2/Shipping/Service_1_0.svc/json";
        $live_url = "https://ws.aramex.net/ShippingAPI.V2/Shipping/Service_1_0.svc/json";

        $calculate_rate_url_test = $test_url . "/CalculateRate";
        $calculate_rate_url_live = $live_url . "/CalculateRate";

        $CancelPickup_url_test = $test_url . "/CancelPickup";
        $CancelPickup_url_live = $live_url . "/CancelPickup";

        $calculate_rate_data = [
            "ClientInfo" => [
                /*live*/
                /* "UserName" => "testingapi@aramex.com",
                 "Password" => "R123456789\$r",
                 "Version" => "v1",
                 "AccountNumber" => "20016",
                 "AccountPin" => "331421",
                 "AccountEntity" => "AMM",
                 "AccountCountryCode" => "JO",*/

                /*test*/
                "UserName" => "reem@reem.com",
                "Password" => "123456789",
                "Version" => "1.0",
                "AccountNumber" => "4004636",
                "AccountPin" => "432432",
                "AccountEntity" => "RUH",
                "AccountCountryCode" => "SA"
            ],
            "OriginAddress " => [
                "Line1" => "",
                "Line2" => "",
                "Line3" => "",
                "City" => "Dubai",
                "StateOrProvinceCode" => null,
                "PostCode" => null,
                "CountryCode" => "AE",
                "Longitude" => 0,
                "Latitude" => 0,
                "BuildingNumber" => null,
                "BuildingName" => null,
                "Floor" => null,
                "Apartment" => null,
                "POBox" => null,
                "Description" => null
            ],
            "DestinationAddress" => [
                "Line1" => "ABC street",
                "Line2" => "",
                "Line3" => "",
                "City" => "Amman",
                "StateOrProvinceCode" => null,
                "PostCode" => null,
                "CountryCode" => "jo",
                "Longitude" => 0,
                "Latitude" => 0,
                "BuildingNumber" => null,
                "BuildingName" => null,
                "Floor" => null,
                "Apartment" => null,
                "POBox" => null,
                "Description" => null

            ],
            "ShipmentDetails" => [
                "PaymentType" => "P",
                "ProductGroup" => "DOM",
                "ProductType" => "OND",
                "ActualWeight" => [
                    "Value" => 1,
                    "Unit" => "KG"
                ],
                "NumberOfPieces" => "1",
                "Dimensions" => null,
                "ChargeableWeight" => null,
                "DescriptionOfGoods" => null,
                "GoodsOriginCountry" => null,
                "PaymentOptions" => null
            ],
            "PreferredCurrencyCode" => [

            ]


        ];


        $responseee = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post($CancelPickup_url_test, $calculate_rate_data);

        /* $responseee =   $responseee->getBody()->getContents();*/

        dd($responseee->json());

    }


    public function curl(Request $request)
    {


        /*
         * AramexUserName="aalmatrodi@ncpd.org.sa"
            AramexPassword="wgxitb!4KG"
            AramexVersion="v1"
            AramexAccountNumber="60536236"
            AramexAccountPin="432432"
            AramexAccountEntity="RUH"
            AramexAccountCountryCode="SA"
            AramexShipperCellPhone=966568644681
            AramexShipperPhoneNumber1=00966568644681
         *
         *
         *
         * */


        $url = "https://ws.aramex.net/ShippingAPI.V2/Shipping/Service_1_0.svc/json/CancelPickup";
        $data = [
            "ClientInfo" => [
                "UserName" => "testingapi@aramex.com",
                "Password" => "R123456789\$r",
                "Version" => "v1",
                "AccountNumber" => "20016",
                "AccountPin" => "331421",
                "AccountEntity" => "AMM",
            ]
        ];


        $responseee = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post($url, $data);

        dd($responseee->body());
        $ressssssssss = $responseee->getBody()->getContents();


        $header = array(
            "POST /SmsWebService.asmx/send HTTP/1.1",
            "Host: server.smson.com",
            "Content-Type: application/x-www-form-urlencoded",
            "Content-Length: " . strlen($data),
        );

        $soap_do = curl_init();
        curl_setopt($soap_do, CURLOPT_URL, $url);
        curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($soap_do, CURLOPT_TIMEOUT, 10);
        curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($soap_do, CURLOPT_POST, true);
        curl_setopt($soap_do, CURLOPT_POSTFIELDS, $data);
        curl_setopt($soap_do, CURLOPT_HTTPHEADER, $header);

        $result = curl_exec($soap_do);

// Close curl resource to free up system resources
        curl_close($soap_do);

        return $result;
    }


}
