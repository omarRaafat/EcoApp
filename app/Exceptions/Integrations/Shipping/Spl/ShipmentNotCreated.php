<?php
namespace App\Exceptions\Integrations\Shipping\Spl;

use Exception;

class ShipmentNotCreated extends Exception {
    public function __construct(string $msg) {
        parent::__construct($msg);
    }
}
