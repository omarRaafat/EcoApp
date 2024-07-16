<?php
namespace App\Exceptions\Integrations\Shipping\Bezz;

use Exception;

class ShipmentNotFound extends Exception
{
    protected $message = "order not found to cancel";
}