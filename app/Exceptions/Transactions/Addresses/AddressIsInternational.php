<?php

namespace App\Exceptions\Transactions\Addresses;

use Exception;

class AddressIsInternational extends Exception
{
    public function __construct() {
        parent::__construct(__("cart.api.address-is-international"), 406);
    }
}
