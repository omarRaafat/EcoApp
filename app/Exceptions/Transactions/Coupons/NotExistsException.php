<?php
namespace App\Exceptions\Transactions\Coupons;

use Exception;

class NotExistsException extends Exception {
    public function __construct()
    {
        parent::__construct(__("cart.api.coupon-not-exists"));
    }
}