<?php

namespace App\Exceptions\Transactions\Addresses;

use Exception;

class AddressOutOfZone extends Exception
{
	/**
	 * @var int
	 */
	protected $code = 400;

	/**
	 * @var string
	 */
	protected $message = "Address out Of Zone";
}
