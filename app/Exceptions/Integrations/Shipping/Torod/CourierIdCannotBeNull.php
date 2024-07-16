<?php

namespace App\Exceptions\Integrations\Shipping\Torod;

use Exception;

class CourierIdCannotBeNull extends Exception
{
	/**
	 * @var int
	 */
	protected $code = 427;

	/**
	 * @var string
	 */
	protected $message = "Courier Id Cannot Be Null";
}
