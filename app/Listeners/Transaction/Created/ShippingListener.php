<?php

namespace App\Listeners\Transaction\Created;

use App\Enums\ShippingMethodKeys;
use Exception;
use App\Events\Transaction;
use App\Integrations\Shipping\Shipment;
use App\Models\TransactionWarning;
use Error;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ShippingListener
{
    /**
     * Handle the event.
     *
     * @param Transaction\Created $event
     * @return void
     */
    public function handle(Transaction\Created $event)
    {
        $transaction = $event->getTransaction();
        try{
            if (!$transaction->shippingMethod)
                throw new Exception(__("admin.transaction-missed-shipping-method", ['transaction' => $transaction->code]));
            $shippingMethodId = ShippingMethodKeys::convertKeyToId($transaction->shippingMethod->integration_key);
            Shipment::make($shippingMethodId)->createShipment($transaction);
        } catch (Exception $e) {
            report($e);
            TransactionWarning::create([
                'message' => $e->getMessage(),
                'reference_type' => 'ShipmentListener',
                'transaction_id' => $transaction->id,
            ]);
        } catch (Error $e) {
            report($e);
            TransactionWarning::create([
                'message' => "internal system error: {$e->getMessage()}",
                'reference_type' => 'ShipmentListener',
                'transaction_id' => $transaction->id,
            ]);
        }
    }
}
