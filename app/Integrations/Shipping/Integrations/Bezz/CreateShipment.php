<?php
namespace App\Integrations\Shipping\Integrations\Bezz;

use App\Exceptions\Integrations\Shipping\Bezz\ShipmentNotCreated;
use App\Models\OrderShip;
use App\Models\Transaction;

class CreateShipment
{
    /**
     * @param Transaction $transaction
     * @return OrderShip
     * @throws ShipmentNotCreated
     */
    public function __invoke(Transaction $transaction) : OrderShip
    {
        return $this->_createOrderShip(
            $transaction,
            (new CreateShipmentApiCall)($transaction),
        );
    }

    /**
     * @param Transaction $transaction
     * @param string $tracking_id
     * @return OrderShip
     */
    private function _createOrderShip(Transaction $transaction, string $tracking_id) : OrderShip
    {
        return OrderShip::updateOrCreate([
           'gateway_tracking_id'=>$tracking_id
        ],[
            "reference_model" => get_class($transaction),
            "reference_model_id" => $transaction->id,
            "gateway_tracking_id" => $tracking_id,
        ]);
    }
}
