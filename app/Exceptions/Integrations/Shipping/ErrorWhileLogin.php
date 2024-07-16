<?php
namespace App\Exceptions\Integrations\Shipping;

use Exception;

class ErrorWhileLogin extends Exception {
    public function __construct(string $msg) {
        parent::__construct($msg);
    }
}
