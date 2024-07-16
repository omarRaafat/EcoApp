<?php
namespace App\Exceptions\Transactions\Coupons;

use Exception;

class OrderMinimumException extends Exception {
    public function __construct() {
        parent::__construct(__("cart.api.coupon-missed-order-minimum"));
    }
}
