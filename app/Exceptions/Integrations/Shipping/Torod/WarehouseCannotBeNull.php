<?php

namespace App\Exceptions\Integrations\Shipping\Torod;

use Exception;

class WarehouseCannotBeNull extends Exception
{
	/**
	 * @var int
	 */
	protected $code = 424;

	/**
	 * @var string
	 */
	protected $message = "Warehouse Cannot Be Null";
}
