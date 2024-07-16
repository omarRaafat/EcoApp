<?php

namespace App\Exceptions\Integrations\Shipping;

use Exception;

class TransactionTotalAmountIsNull extends Exception
{
	/**
	 * @var int
	 */
	protected $code = 418;

	/**
	 * @var string
	 */
	protected $message = "Transaction Total Amount Cannot Be Null";
}
