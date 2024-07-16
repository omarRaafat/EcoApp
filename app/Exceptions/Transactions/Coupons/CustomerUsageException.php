<?php
namespace App\Exceptions\Transactions\Coupons;

use Exception;

class CustomerUsageException extends Exception {
    public function __construct() {
        parent::__construct(__("cart.api.coupon-exceed-usage"));
    }
}
