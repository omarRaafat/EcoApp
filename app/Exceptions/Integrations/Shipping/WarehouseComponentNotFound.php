<?php

namespace App\Exceptions\Integrations\Shipping;

use Exception;

class WarehouseComponentNotFound extends Exception
{
	/**
	 * @var int
	 */
	protected $code = 469;

	/**
	 * @var string
	 */
	protected $message = "Warehouse Component Not Found";
}
