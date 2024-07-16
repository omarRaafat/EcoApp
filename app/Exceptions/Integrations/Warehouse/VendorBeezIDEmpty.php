<?php
namespace App\Exceptions\Integrations\Warehouse;

use Exception;

class VendorBeezIDEmpty extends Exception {
    public function __construct()
    {
        parent::__construct("Vendor Beez ID cannot be empty");
    }
}