<?php

namespace App\Exceptions;

use Exception;

class OrderAmountException extends Exception
{
    public function __construct($msg)
    {
        parent::__construct($msg);
    }
}
