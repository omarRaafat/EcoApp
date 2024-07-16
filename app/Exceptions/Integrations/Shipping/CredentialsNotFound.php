<?php

namespace App\Exceptions\Integrations\Shipping;

use Exception;

class CredentialsNotFound extends Exception
{
	/**
	 * @var int
	 */
	protected $code = 412;

	/**
	 * @var string
	 */
	protected $message = "Error In Integration Credentials";
}
