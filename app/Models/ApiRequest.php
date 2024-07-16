<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'model_name',
        'model_id',
        'client_id',
        'url',
        'req',
        'res',
        'http_code',
        'dataUpdated',
    ];


    const NAMES = [
        'AramexPickupShipment',
        'AramexPrintLabelAfterPickup',
        'AramexCancelShipment',
        'AramexRefundShipment',
        'AramexPrintLabelAfterRefundShipment',
        'SPLCreateShipment',
        'CheckoutWebEngage',
        'DeliveredWebEngage',
        'PaymentFailureWebEngage',
        'InmaTransfer',
        'sendToNcpdOldHelpDesk',
        'sendToNcpdNewHelpDesk',
        'userAuthWallet',
        'getClientWallets',
        'checkWallet',
        'findWallet',
        'deposit_or_withdraw_center_account',
        'withdrawWallet',
        'depositWallet',
        'TabbyCheckout',
        'paymentCallbackTransactionService',
        'paymentCallbackTabbyServices',
        'paymentCallbackUrwayServices',
    ];

}
