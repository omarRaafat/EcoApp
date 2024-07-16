<?php
namespace App\Exceptions\Integrations\Warehouse;

use Exception;

class VendorWarehouseRequestEmpty extends Exception {
    public function __construct()
    {
        parent::__construct("Vendor Warehouse Request cannot be empty");
    }
}