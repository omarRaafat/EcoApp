<?php

namespace App\Services\Payments\Tabby;

use App\Exceptions\OrderAmountException;
use App\Integrations\Shipping\Integrations\Traits\Logger;
use App\Models\Transaction;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use App\Actions\ApiRequestAction;
use App\Models\Cart;
use Illuminate\Support\Str;

class Checkout
{
    use Logger;

    const LOG_CHANNEL = 'tabby';
    protected $checkout_url = "https://api.tabby.ai/api/v2/checkout";

    public function __invoke(Cart $cart)
    {
        /*prepare cart data*/
        $payUuid = mt_rand(1000000,9999999);
        $data = $this->prepareData($cart, $payUuid);
        $this->logger(self::LOG_CHANNEL, 'TAbby:StartNewOrder', [], false);


        /* checkout */
        $response = Http::withHeaders([
            "Accept" => "application/json",
            "Content-type" => "application/json",
            "Authorization" => "Bearer " . config('payment.Tabby.public_key')
        ])->post($this->checkout_url, $data);

        resolve(ApiRequestAction::class)->handle([
            'name' => 'TabbyCheckout',
            'model_name' => 'Cart',
            'model_id' => $cart->id,
            'client_id' => $cart->user_id,
            'url' => $this->checkout_url,
            'req' => json_encode($data),
            'res' => $response->getBody()->getContents(),
            'http_code' => $response->status(),
        ]);

        //$this->logger(self::LOG_CHANNEL, "Tabby checkout reponse", ['response' => $response], false);

        if ($response->successful()) {
            $response = $response->json();
            $configuration = Arr::get($response, 'configuration');
            $products = Arr::get($configuration, 'products');

            $installmentsAvailable = $products['installments']['is_available'];


            if ($installmentsAvailable) {

                $this->logger(self::LOG_CHANNEL, 'TAbby:OrderDone', [], false);
                return [
                    'status' => "successfully",
                    'payUuid' => $payUuid,
                    'payId' => $response['id'],
                    'url' => $configuration['available_products']['installments'][0]['web_url']
                ];
            } else {
                $this->logger(self::LOG_CHANNEL, 'TAbby:OrderError', [$products['installments']['rejection_reason']], true);
                throw new OrderAmountException($products['installments']['rejection_reason']);
            }
        }
        return [
            'status' => "error",
        ];

    }

    public function prepareData($cart, $payUuid)
    {

        $items = [];
        foreach ($cart->cartProducts as $cartProduct) {
            if($cartProduct->service_id == null){
                $items[] = [
                    "title" => $cartProduct->product?->name,
                    "description" => $cartProduct->product?->desc,
                    "quantity" => $cartProduct->quantity,
                    "unit_price" => $cartProduct->unit_price,
                    "discount_amount" => number_format($cartProduct->discount, 2, '.', ''),
                    "reference_id" => "{$cart->id}",
                    "image_url" => null,
                    "product_url" => null,
                    "gender" => null,
                    "category" => $cartProduct->product?->category?->name ?? null,
                    "color" => null,
                    "product_material" => null,
                    "size_type" => null,
                    "size" => null,
                    "brand" => null
                ];
            }else{
                $items[] = [
                    "title" => $cartProduct->service?->name,
                    "description" => $cartProduct->service?->desc,
                    "quantity" => $cartProduct->quantity,
                    "unit_price" => $cartProduct->unit_price,
                    "discount_amount" => number_format($cartProduct->discount, 2, '.', ''),
                    "reference_id" => "{$cart->id}",
                    "image_url" => null,
                    "product_url" => null,
                    "gender" => null,
                    "category" => $cartProduct->service?->category->name ?? null,
                    "color" => null,
                    "product_material" => null,
                    "size_type" => null,
                    "size" => null,
                    "brand" => null
                ];
            }

        }

        $data = [
            "payment" => [
                "amount" => (double)$cart->visa_amount,
                "currency" => "SAR",
                "description" => "string",
                "buyer" => [
                    "phone" => $cart->client?->phone,
                    "email" => null,
                    "name" => $cart->client?->name,
                    "dob" => null,
                ],
                "shipping_address" => [
                    "city" => $cart->city?->name,
                    "address" => "Saudi Arabia",
                    "zip" => "string"
                ],
                "order" => [
                    "tax_amount" => 0,
                    "shipping_amount" =>number_format($cart->delivery_fees, 2, '.', ''),
                    "discount_amount" => 0,
                    "updated_at" => date('Y-m-d') . "T00:00:00Z",
                    "reference_id" => "$cart->id",
                    "items" => $items
                ],
                "buyer_history" => [
                    "registered_since"=> date('Y-m-d',strtotime($cart->created_at))."T".date('H:i:s')."Z",
                    "loyalty_level"=> $cart->cartVendorShippings()->count(),
                    "wishlist_count"=> 0,
                    "is_social_networks_connected"=> false,
                    "is_phone_number_verified"=> true,
                    "is_email_verified"=> true

                ],
                "order_history" => [
                    [
                        "purchased_at"=> date('Y-m-d',strtotime($cart->created_at))."T00:00:00Z",
                        "amount" => (double)$cart->visa_amount,
                        "payment_method" => "card",
                        "status" => "new",
                        "buyer" =>
                            [
                                "phone" => $cart->client?->phone,
                                "email" => null,
                                "name" => $cart->client?->name,
                                "dob" => null,

                            ],
                        "shipping_address" =>
                            [
                                "city" => $cart->city?->name,
                                "address" => $cart->city?->name,
                                "zip" => "string"

                            ],
                        "items" => $items
                    ]
                ],


                "meta" => [
                    "order_id" => $cart->id,
                ],
            ],
            "lang" => "ar",
            "merchant_code" => config('payment.Tabby.merchant_code'),
            "merchant_urls" => [
                "success"   => route('paymant-callback',['status' => 'success' , 'cart_id' => $payUuid ]) , //route('user.tabbyCheckout','success'),
                "cancel"    => route('paymant-callback',['status' => 'cancel' , 'cart_id' => $cart->id]) , //route('user.tabbyCheckout','cancel'),
                "failure"   => route('paymant-callback',['status' => 'failure' , 'cart_id' => $cart->id]) , //route('user.tabbyCheckout','failure')
            ]
        ];

        return $data;
    }
}
