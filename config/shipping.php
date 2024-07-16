<?php

/**
 * This config file contains all shipping integrations credentials.
 */

return [
    "torod" => [
        "production_url" => env("TOROD_PRODUCTION_URL"),
        "stage_url" => env("TOROD_STAGE_URL"),
        "client_id" => env("TOROD_CLIENT_ID"),
        "client_secret" => env("TOROD_CLIENT_SECRET"),
    ],

    "bezz" => [
        "acccount_number" => env("BEZZ_ACCOUNT_NUMBER" ),
        "api_key" => env("BEZZ_API_KEY"),
        "base_url" => env("BEZZ_BASE_URL"),
        "bezz_webhook_secret_key" => env("BEZZ_WEBHOOK_SECRET_KEY"),
        "tracking_url" => env("BEZZ_TRACKING_URL"),
        "default_customer_email" => "@saudidates.sa"
    ],
    "spl" => [
        "grant_type" => env("SPL_GRANT_TYPE" , "password"),
        "username" => env("SPL_USERNAME" , "extrTomor"),
        "password" => env("SPL_PASSWORD" , "P@ssw0rd#2o2!"),
        "crm_account_id" => env("SPL_CRM_ACCOUNT_ID" , "31314344634"),
        "branch_id" => env("SPL_BRANCH_ID" , "1760198"),
        "default_customer_email" => "@saudidates.sa",
        "base_api_url" => env("SPL_BASE_API_URL" , "https://gateway-minasapre.sp.com.sa/"),
        "tracking_url" => env("SPL_TRACKING_URL" , "https://splonline.com.sa/en/shipmentdetailsstatic/?tid="),
        "shipment_status_token" => env("SPL_SHIPMENT_STATUS_TOKEN"),
    ],
    "aramex" => [
        "AccountCountryCode"    => env("AccountCountryCode" , "SA") ,
        "AccountEntity"         => env("AccountEntity" , "RUH"),
        "AccountNumber"         => env("AccountNumber" , "4004636"),
        "AccountPin"            => env("AccountPin" , "432432"),
        "UserName"              => env("UserName" , "testingapi@aramex.com"),
        "Password"              => env("Password" , 'R123456789$r'),
        "Version"               => env("Version" , "v1"),
        "Source"                => env("Source" , 24),
        "ARAMEXPICKUPURL"       => env("ARAMEXPICKUPURL" , "https://ws.SBX.aramex.net/ShippingAPI.V2/Shipping/Service_1_0.svc/json/CreatePickup"),
        "ARAMEXCANCELURL"       => env("ARAMEXCANCELURL" , "https://ws.SBX.aramex.net/ShippingAPI.V2/Shipping/Service_1_0.svc/json/CancelPickup"),
        "ARAMEXPRINTLABELURL"   => env("ARAMEXPRINTLABELURL" , "https://ws.SBX.aramex.net/ShippingAPI.V2/Shipping/Service_1_0.svc/json/PrintLabel"),
        "ARAMEXTRACKINGURL"     => env("ARAMEXTRACKINGURL" , "https://ws.SBX.aramex.net/ShippingAPI.V2/Tracking/Service_1_0.svc/json/TrackShipments"),
        "shipment_status_token" => env("ARAMEX_SHIPMENT_STATUS_TOKEN"),
        "PaymentType"           => env("ARAMEX_PAYMENT_TYPE" , "P"),
        "ProductGroup"           => env("ARAMEX_Product_Group" , "DOM"),
        "ProductType"           => env("ARAMEX_Product_Type" , "CDS"),
    ],
];
