<?php

namespace App\Exceptions\Integrations\Shipping\Torod;

use Exception;

class TransactionTotalWeightCannotBeNull extends Exception
{
	/**
	 * @var int
	 */
	protected $code = 421;

	/**
	 * @var
	 */
	protected $message = "Transaction Total Weight Cannot Be Null"; 
}
