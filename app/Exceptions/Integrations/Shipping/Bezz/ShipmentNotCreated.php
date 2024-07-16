<?php
namespace App\Exceptions\Integrations\Shipping\Bezz;

use Exception;

class ShipmentNotCreated extends Exception {
    public function __construct(string $msg) {
        parent::__construct($msg);
    }
}
