<?php
namespace App\Exceptions\Integrations\Shipping\Aramex;

use Exception;

class ShipmentNotCreated extends Exception {
    public function __construct(string $msg) {
        parent::__construct($msg);
    }
}
