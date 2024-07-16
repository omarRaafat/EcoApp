<?php
namespace App\Exceptions\Integrations\Warehouse;

use Exception;

class CredentialsEmpty extends Exception {
    public function __construct()
    {
        parent::__construct("Error In Integration Credentials");
    }
}