<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Enums\ServiceOrderStatus;
use App\Models\ClientMessage;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ClientMessageService
{

    /**
     * @param string $type
     * @param Transaction $transaction
     * @return void
     * @throws \Exception
     */
    public static function transactionCreatedMessage(string $type, Transaction $transaction): void
    {
        try {
            if ($transaction->status == OrderStatus::PAID) {
                $invoice_number = implode(', ', $transaction->orders()->pluck('code')->toArray());
                $clientMessage = ClientMessage::messageFor($type)->first();
                if ($clientMessage){
                    $msg = $clientMessage->getTransMessage("ar");
                    $msg = str_replace("::var_client_name::", $transaction->client->name, $msg);
                    $msg = str_replace("::var_order_id::", $transaction->code, $msg);
                    $msg = str_replace("::var_order_amount::", $transaction->total, $msg);
                    $msg = str_replace("::var_order_invoice_no::", $invoice_number, $msg);

                    SendSms::toSms($transaction->client->phone, $msg);
                }
            }
        } catch (\Exception $ex) {
            // throw $ex;
            Log::channel("customer-sms-errors")->error("Exception in TransactionCreated: " . $ex->getMessage());
        }
    }

    public static function transactionServiceCreatedMessage(string $type, Transaction $transaction): void
    {
        try {
            if ($transaction->status == ServiceOrderStatus::PAID) {
                $invoice_number = implode(', ', $transaction->orders()->pluck('code')->toArray());
                $clientMessage = ClientMessage::messageFor($type)->first();
                if ($clientMessage){
                    $msg = $clientMessage->getTransMessage("ar");
                    $msg = str_replace("::var_client_name::", $transaction->client->name, $msg);
                    $msg = str_replace("::var_order_id::", $transaction->code, $msg);
                    $msg = str_replace("::var_order_amount::", $transaction->total, $msg);
                    $msg = str_replace("::var_order_invoice_no::", $invoice_number, $msg);

                    SendSms::toSms($transaction->client->phone, $msg);
                }
            }
        } catch (\Exception $ex) {
            // throw $ex;
            Log::channel("customer-sms-errors")->error("Exception in TransactionServiceCreated: " . $ex->getMessage());
        }
    }


    /**
     * @param string $type
     * @param  $warehouse
     * @param  $code
     * @param  $userPortal
     * @param  $invoice_number
     * @return void
     */
    public static function receiveTransaction(string $type, $warehouse, $code, $userPortal, $invoice_number, $no_packages): void
    {

        try {
            $clientMessage = ClientMessage::messageFor($type)->first();
            if ($clientMessage) $msg = $clientMessage->getTransMessage("ar");

            $msg = str_replace("::var_client_name::", $userPortal->name, $msg);
            $msg = str_replace("::var_order_invoice_no::", $invoice_number, $msg);
            $msg = str_replace("::var_warehouse_name::", $warehouse->warehouse->name, $msg);
            $msg = str_replace("::var_receive_order_code::", $code, $msg);
            $msg = str_replace("::var_no_packets::", $no_packages, $msg);
            $msg = str_replace("::var_warhouse_map::", "https://www.google.com/maps?q={$warehouse->warehouse->latitude},{$warehouse->warehouse->longitude}", $msg);
            SendSms::toSms($userPortal->phone, $msg);
        } catch (\Exception $ex) {
            Log::channel("customer-sms-errors")->error("Exception in TransactionCreated: " . $ex->getMessage());
        }
    }

    public static function receiveServiceTransaction(string $type, $code, $userPortal, $invoice_number): void
    {

        try {
            $clientMessage = ClientMessage::messageFor($type)->first();
            if ($clientMessage) $msg = $clientMessage->getTransMessage("ar");

            $msg = str_replace("::var_client_name::", $userPortal->name, $msg);
            $msg = str_replace("::var_order_invoice_no::", $invoice_number, $msg);
            $msg = str_replace("::var_receive_order_code::", $code, $msg);
            SendSms::toSms($userPortal->phone, $msg);
        } catch (\Exception $ex) {
            Log::channel("customer-sms-errors")->error("Exception in receiveServiceTransaction: " . $ex->getMessage());
        }
    }

    /**
     * @param string $type
     * @param  $userPortal
     * @param  $invoice_number
     * @return void
     */
    public static function completedTransaction(string $type, $userPortal, $invoice_number, $transaction_id): void
    {
        try {
            $clientMessage = ClientMessage::messageFor($type)->first();
            if ($clientMessage) $msg = $clientMessage->getTransMessage("ar");
            $msg = str_replace("::var_client_name::", $userPortal->name, $msg);
            $msg = str_replace("::var_order_invoice_no::", $invoice_number, $msg);
            $msg = str_replace("::var_link_order::", strip_tags(env("BaseUrlRate") . $transaction_id, '<a>'), $msg);
            SendSms::toSms($userPortal->phone, $msg);
        } catch (\Exception $ex) {
            Log::channel("customer-sms-errors")->error("Exception in TransactionCreated: " . $ex->getMessage());
        }
    }

    public static function completedServiceTransaction(string $type, $userPortal, $invoice_number, $transaction_id): void
    {
        try {
            $clientMessage = ClientMessage::messageFor($type)->first();
            if ($clientMessage) $msg = $clientMessage->getTransMessage("ar");
            $msg = str_replace("::var_client_name::", $userPortal->name, $msg);
            $msg = str_replace("::var_order_invoice_no::", $invoice_number, $msg);
            $msg = str_replace("::var_link_order::", strip_tags(env("BaseUrlRate") . $transaction_id, '<a>'), $msg);
            SendSms::toSms($userPortal->phone, $msg);
        } catch (\Exception $ex) {
            Log::channel("customer-sms-errors")->error("Exception in completedServiceTransaction: " . $ex->getMessage());
        }
    }

    /**
     * @param string $type
     * @param  $userPortal
     * @param  $invoice_number
     * @return void
     */
    public static function OnDeliveryTransaction(string $type, $userPortal, $invoice_number): void
    {
        try {
            $clientMessage = ClientMessage::messageFor($type)->first();
            if ($clientMessage) $msg = $clientMessage->getTransMessage("ar");

            $msg = str_replace("::var_client_name::", $userPortal->name, $msg);
            $msg = str_replace("::var_order_invoice_no::", $invoice_number, $msg);

            SendSms::toSms($userPortal->phone, $msg);
        } catch (\Exception $ex) {
            Log::channel("customer-sms-errors")->error("Exception in TransactionCreated: " . $ex->getMessage());
        }
    }

    /**
     * @param string $type
     * @param  $userPortal
     * @param  $order_id
     * @return void
     */
    public static function CanceledTransaction(string $type, $userPortal, $order_id): void
    {
        try {
            $clientMessage = ClientMessage::messageFor($type)->first();
            if ($clientMessage) $msg = $clientMessage->getTransMessage("ar");

            $msg = str_replace("::var_client_name::", $userPortal->name, $msg);
            $msg = str_replace("::var_order_id::", $order_id, $msg);

            SendSms::toSms($userPortal->phone, $msg);
        } catch (\Exception $ex) {
            Log::channel("customer-sms-errors")->error("Exception in TransactionCreated: " . $ex->getMessage());
        }
    }

    /**
     * @param string $type
     * @param  $userPortal
     * @param  $order_id
     * @return void
     */
    public static function RefundTransaction(string $type, $userPortal, $order_id): void
    {
        try {
            $clientMessage = ClientMessage::messageFor($type)->first();
            if ($clientMessage) $msg = $clientMessage->getTransMessage("ar");

            $msg = str_replace("::var_client_name::", $userPortal['name'], $msg);
            $msg = str_replace("::var_order_id::", $order_id, $msg);

            SendSms::toSms($userPortal['phone'], $msg);
        } catch (\Exception $ex) {
            Log::channel("customer-sms-errors")->error("Exception in TransactionCreated: " . $ex->getMessage());
        }
    }
}
