<?php
namespace App\Exceptions\Wallet;

use Exception;

class NotEnoughBalance extends Exception {
    public function __construct()
    {
        parent::__construct(__("wallet.not-enough-balance"));
    }
}