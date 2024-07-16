<?php
namespace App\Exceptions\Integrations\Shipping\Bezz;

use Exception;

class ShipmentAlreadyCancelled extends Exception
{
    protected $message = "order already been cancelled";
}