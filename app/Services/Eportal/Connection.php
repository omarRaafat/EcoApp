<?php

namespace App\Services\Eportal;

use App\Models\GuestCustomer;
use App\Models\User;
use Exception;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Client;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Actions\ApiRequestAction;

class Connection
{
    /**
     * @param string $eportalRoute
     * @param array $data
     * @return JsonResponse
     */
    public static function send(string $eportalRoute , array $data): JsonResponse
    {
            $response = Http::asJson()->post($eportalRoute, $data);
            return response()->json([
                'success' => $response->json('success') ?? false,
                'message' => $response->json('message') ?? $response->reason(),
                'data'    => $response->json('data') ?? []
            ], $response->status());
    }

    /**
     * @param string $eportalRoute
     * @param array $data
     * @return JsonResponse
     */
    public static function get(string $eportalRoute): JsonResponse
    {
            $response = Http::asJson()->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => request()->header('Authorization')
            ])->get($eportalRoute);
            return response()->json([
                'success' => $response->status() == 200 ? true : false,
                'message' => $response->json('message') ?? $response->reason(),
                'data'    => $response->json('data') ?? []
            ], $response->status());
    }

      /**
     * @param  Request  $request
     * @param  string   $eportalRoute
     * @return PromiseInterface|Response
     */
    public static function userAuthOrGuestInfo(Request $request , string $eportalRoute)
    {
        if(auth('api_client')->check()){
            $data['model'] = Client::class;
            $data['id'] = auth('api_client')->user()->id;
            return $data;
        }

        if(!empty($request->header('X-Guest-Token'))){
            $token = GuestCustomer::where('token' , $request->header('X-Guest-Token'))->first();
            if($token){
                $data['model'] = GuestCustomer::class;
                $data['id'] = $token->id;
                return $data;
            }
        }

        return [];

    }

    /**
     * @param  Request  $request
     * @param  string   $eportalRoute
     * @return PromiseInterface|Response
     */
    public static function userAuthWallet(Request $request, $client = null)
    {
        $user = ($client) ?: auth()->guard('api_client')->user();

        $data = [
            'sso_secret'=>config('eportal.sso_secret'),
            'secret_wallet_key'=> getSecrectWalletKey(),
            "domain" => config('app.url'),
            'identity'=> $user->identity
        ];
        $url = config('app.eportal_url') . 'wallets';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post($url,$data);

        resolve(ApiRequestAction::class)->handle([
            'name' => 'userAuthWallet',
            'url' => $url,
            'client_id' => $user->id,
            'req' => $user->identity,
            'res' => $response->getBody()->getContents(),
            'http_code' => $response->status(),
        ]);

        return $response;
    }


    public static function getClientWallets(Request $request , string $eportalRoute)
    {
        if(auth('api_client')->check()){
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post($eportalRoute,[
                'sso_secret'=>config('eportal.sso_secret'),
                'secret_wallet_key'=> getSecrectWalletKey(),
                "domain" => config('app.url'),
                'identity'=> auth()->guard('api_client')->user()->identity
            ]);

            resolve(ApiRequestAction::class)->handle([
                'name' => 'getClientWallets',
                'url' => $eportalRoute,
                'client_id' => auth()->guard('api_client')->user()->id,
                'req' => auth()->guard('api_client')->user()->identity,
                'res' => $response->getBody()->getContents(),
                'http_code' => $response->status(),
            ]);

            return $response;
        }

        return null;
    }




    /**
     * @param  int $wallet_id
     * @param  float $amount
     * @param  int $order_id
     * @param  string $eportalRoute
     * @return PromiseInterface|Response
     */
    public static function checkWallet(int $wallet_id , float $amount  , string $eportalRoute)
    {
       try {
            $data = [
                'wallet_id' => $wallet_id,
                'amount'    => $amount,
                'sso_secret'=>config('eportal.sso_secret'),
                'secret_wallet_key'=> getSecrectWalletKey(),
                "domain" => config('app.url'),
                'identity'=> auth()->guard('api_client')->user()->identity
            ];

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => Request()->header('Authorization')
            ])->post($eportalRoute , $data);

            resolve(ApiRequestAction::class)->handle([
                'name' => 'checkWallet',
                'url' => $eportalRoute,
                'client_id' => auth()->guard('api_client')->user()->id,
                'req' => auth()->guard('api_client')->user()->identity,
                'res' => $response->getBody()->getContents(),
                'http_code' => $response->status(),
            ]);

            return $response;
        } catch (\Throwable $th) {
            report($th);
            return  null;
        }
    }


    /**
     * @param  $wallet_id
     * @param  string $eportalRoute
     * @param  int $is_refund
     * @param  int $client_id
     * @return PromiseInterface|Response
     */
    public static function findWallet($wallet_id  , string $eportalRoute ,int $is_refund = 0 , int $client_id)
    {
        try {
            $user = null;
            if($client_id){
            $user = Client::find($client_id);
            }
            if($user ==null && auth()->guard('api_client')->check()){
                $user = auth()->guard('api_client')->user();
            }

            $data = [
                'wallet_id' => $wallet_id,
                'is_refund' =>  $is_refund,
                'client_id' => $client_id,
                'sso_secret'=>config('eportal.sso_secret'),
                'secret_wallet_key'=> getSecrectWalletKey(),
                "domain" => config('app.url'),
                'identity'=> $user->identity
            ];


            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ])->post($eportalRoute , $data);


            resolve(ApiRequestAction::class)->handle([
                'name' => 'findWallet',
                'url' => $eportalRoute,
                'client_id' => $user->id,
                'req' => $user->identity,
                'res' => $response->getBody()->getContents(),
                'http_code' => $response->status(),
            ]);

            return $response;
        } catch (\Throwable $th) {
            report($th);
            return  null;
        }
    }



    /**
     * @param  $wallet_id
     * @param  float $amount
     * @param  int $order_id
     * @return array|mixed
     */
    public static function deposit_or_withdraw_center_account(string $eportalRoute  , int $client_id , int $wallet_id , $direction, float $amount , $order_code = null , $transaction_id = null   , $request_id = null , $FTRefNum ,$AmtDebitedAmount ,$AmtCreditedAmount ,$CurrBal , $bankRresponse)
    {
        try {
            $user = null;
            if($client_id){
            $user = Client::find($client_id);
            }
            if($user ==null && auth()->guard('api_client')->check()){
                $user = auth()->guard('api_client')->user();
            }

            $data = [
                'client_id' => $client_id ,
                'wallet_id' => $wallet_id ,
                'transaction_code' => $transaction_id,
                'order_code' => $order_code,
                'direction' => $direction ,
                'amount'    => $amount,
                'request_id' => $request_id,
                'FTRefNum' => $FTRefNum,
                'AmtDebitedAmount' => $AmtDebitedAmount,
                'AmtCreditedAmount' => $AmtCreditedAmount,
                'CurrBal' => $CurrBal,
                'response' => $bankRresponse,
                'identity'=> $user->identity
            ];

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ])->post($eportalRoute , $data);

            resolve(ApiRequestAction::class)->handle([
                'name' => 'deposit_or_withdraw_center_account',
                'url' => $eportalRoute,
                'client_id' => $user->id,
                'req' => $user->identity,
                'res' => $response->getBody()->getContents(),
                'http_code' => $response->status(),
            ]);

            return $response;
        } catch (\Throwable $th) {
            report($th);
            return  null;
        }
    }




    /**
     * @param  int $wallet_id
     * @param  float $amount
     * @param  int $order_id
     * @param  string $eportalRoute
     * @return PromiseInterface|Response
     */
    public static function withdrawWallet(int $wallet_id , float $amount , int $order_id , string $eportalRoute , string $details , $client_id = null)
    {
        try {
            $client = Client::find($client_id);
            $data = [
                'wallet_id' => $wallet_id ,
                'amount'    => $amount,
                'order_id'  => $order_id,
                'details'  => $details,
                'client_id' => $client_id ?? null,
                'sso_secret'=>config('eportal.sso_secret'),
                'secret_wallet_key'=> getSecrectWalletKey(),
                "domain" => config('app.url'),
                'identity'=> $client->identity ?? null,
            ];

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post($eportalRoute , $data);

            resolve(ApiRequestAction::class)->handle([
                'name' => 'withdrawWallet',
                'url' => $eportalRoute,
                'client_id' => $client_id ?? null,
                'req' => $client->identity ?? null,
                'res' => $response->getBody()->getContents(),
                'http_code' => $response->status(),
            ]);

            return $response;
        } catch (\Throwable $th) {
            report($th);
            return  null;
       }
    }

    public static function transactionPay($walletsOrdersAmountToPay, $client)
    {
        $data = [
            'wallets_amounts_orders' => $walletsOrdersAmountToPay ,
            'identity'=> $client->identity,
            'sso_secret'=>config('eportal.sso_secret'),
            'secret_wallet_key'=> getSecrectWalletKey(),
            "domain" => config('app.url'),
        ];

        $url = config('app.eportal_url') . 'transaction-pay';
        $response =  Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post($url , $data);

        unset($data['sso_secret'], $data['secret_wallet_key']);

        resolve(ApiRequestAction::class)->handle([
            'name' => 'transactionPay',
            'url' => $url,
            'client_id' => $client->id,
            'req' => json_encode($data),
            'res' => $response->getBody()->getContents(),
            'http_code' => $response->status(),
        ]);

        return $response;
    }


        /**
     * @param  int $wallet_id
     * @param  float $amount
     * @param  int $order_id
     * @param  string $eportalRoute
     * @return PromiseInterface|Response
     */
    public static function depositWallet(int|null $wallet_id , float $amount , int $order_id , string $eportalRoute , string $details , $user_id = null , $use_refund_wallet = 0)
    {
        try {
            $user = null;
            if($user_id){
            $user = Client::find($user_id);
            }

            if($user ==null && auth()->guard('api_client')->check()){
                $user = auth()->guard('api_client')->user();
            }

            $data = [
                'wallet_id' => $wallet_id,
                'amount'    => $amount,
                'order_id'  => $order_id,
                'details'  => $details,
                'client_id' => $user_id ? $user_id : null ,
                'use_refund_wallet' => $use_refund_wallet,
                'sso_secret'=>config('eportal.sso_secret'),
                'secret_wallet_key'=> getSecrectWalletKey(),
                "domain" => config('app.url'),
                'identity'=> $user->identity ?? null
            ];

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post($eportalRoute , $data);

            resolve(ApiRequestAction::class)->handle([
                'name' => 'depositWallet',
                'url' => $eportalRoute,
                'client_id' => $user_id ?? null,
                'req' => $user->identity ?? null,
                'res' => $response->getBody()->getContents(),
                'http_code' => $response->status(),
            ]);

            return $response;
        } catch (\Throwable $th) {
            report($th);
            return  null;
      }
    }



    public static function getCenterAccount()
    {
        $eportalRoute = config('app.eportal_url')  . 'center_account';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post($eportalRoute,[
            'sso_secret'=>config('eportal.sso_secret'),
            'secret_wallet_key'=> getSecrectWalletKey(),
            "domain" => config('app.url'),
        ])->json() ?? [];

        return $response;
    }


}
