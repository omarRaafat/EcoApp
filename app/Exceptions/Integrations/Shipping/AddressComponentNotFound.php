<?php

namespace App\Exceptions\Integrations\Shipping;

use Exception;

class AddressComponentNotFound extends Exception
{
	/**
	 * @var int
	 */
	protected $code = 415;

    public function __construct($msg)
    {
        parent::__construct($msg);
    }
}
