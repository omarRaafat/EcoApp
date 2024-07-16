<?php
namespace App\Exceptions\Transactions\Coupons;

use Exception;

class NotStartedException extends Exception {
    public function __construct($startData) {
        parent::__construct(__("cart.api.coupon-not-started", ['date' => $startData]));
    }
}
