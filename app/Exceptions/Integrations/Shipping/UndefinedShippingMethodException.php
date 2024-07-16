<?php

namespace App\Exceptions\Integrations\Shipping;

use Exception;

class UndefinedShippingMethodException extends Exception
{
	/**
	 * @var int
	 */
	protected $code = 409;

	/**
	 * @var string
	 */
	protected $message = "Undefined Shipping Method";
}
