<?php

namespace App\Services\Wallet;

use App\Services\Eportal\Connection;
use Error;

class UpdateWalletBalanceEportal
{


/**
     * @param  $wallet_id
     * @param  float $amount
     * @param  int $order_id
     * @return array|mixed
     */
    public static function checkWalletHaveAmount($wallet_id , float $amount)
    {
            $response = Connection::checkWallet($wallet_id, $amount , config('app.eportal_url') . 'check-wallet-balance')->json();
        //     dd($response);
            return $response;
    }







    /**
     * @param  $wallet_id
     * @param  float $amount
     * @param  int $order_id
     * @return array|mixed
     */
    public static function withdraw($wallet_id , float $amount , int $order_id , string $details = 'شراء منتجات' , $client_id = null)
    {
            $response = Connection::withdrawWallet($wallet_id, $amount , $order_id , config('app.eportal_url') . 'withdraw-my-wallet' , $details , $client_id)->json();
            return $response;
    }


        /**
     * @param  $wallet_id
     * @param  float $amount
     * @param  int $order_id
     * @return array|mixed
     */
    public static function refundWallet($wallet_id , float $amount , int $order_id , string $details = 'ارتجاع الفلوس' , $user_id ,int $use_refund_wallet = 0)
    {
            $response = Connection::depositWallet($wallet_id, round($amount,2) , $order_id , config('app.eportal_url') . 'deposit-to-wallet' , $details , $user_id , $use_refund_wallet)?->json() ?? [];
            return $response;
    }


}
