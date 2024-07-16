<?php
namespace App\Integrations\Statistics;

use App\Integrations\Statistics\WebEngage\CheckoutCompleted;
use App\Integrations\Statistics\WebEngage\OrderCanceled;
use App\Integrations\Statistics\WebEngage\OrderDelivered;
use App\Integrations\Statistics\WebEngage\OrderRefund;
use App\Integrations\Statistics\WebEngage\PaymentFailure;
use App\Integrations\Statistics\WebEngage\ShippingDetailsUpdated;
use App\Models\Transaction;

class WebEngage {
    public function checkoutCompleted(Transaction $transaction) {
        $checkoutCompleted = new CheckoutCompleted($transaction);
        $checkoutCompleted();
    }

    public function paymentFailure(Transaction $transaction, string $reason) {
        $paymentFailure = new PaymentFailure($transaction, $reason);
        $paymentFailure();
    }

    public function shippingDetailsUpdated(Transaction $transaction) {
        $shippingDetailsUpdated = new ShippingDetailsUpdated($transaction);
        $shippingDetailsUpdated();
    }

    public function orderDelivered(Transaction $transaction) {
        $orderDelivered = new OrderDelivered($transaction);
        $orderDelivered();
    }

    public function orderCanceled(Transaction $transaction) {
        $orderCanceled = new OrderCanceled($transaction);
        $orderCanceled();
    }

    public function orderRefund(Transaction $transaction) {
        $orderRefund = new OrderRefund($transaction);
        $orderRefund();
    }
}
