<?php
namespace App\Exceptions\Transactions\Coupons;

use Exception;

class InactiveException extends Exception {
    public function __construct() {
        parent::__construct(__("cart.api.coupon-not-active"));
    }
}
