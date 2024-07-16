<?php
namespace App\Exceptions\Transactions\Coupons;

use Exception;

class DeliveryFeesMinimumException extends Exception {
    public function __construct() {
        parent::__construct(__("cart.api.coupon-missed-delivery-minimum"));
    }
}
