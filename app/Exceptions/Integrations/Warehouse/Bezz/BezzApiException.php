<?php

namespace App\Exceptions\Integrations\Warehouse\Bezz;

use Exception;

class BezzApiException extends Exception
{
	/**
	 * @var int
	 */
	protected $code = 459;

	/**
	 * @var string
	 */
	protected $message = "Bezz Api Response Exception";
}
