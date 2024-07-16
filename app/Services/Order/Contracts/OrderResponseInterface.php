<?php
namespace App\Services\Order\Contracts;

use App\Models\Transaction;
use Closure;

interface OrderResponseInterface {
    public function __construct(Transaction $transaction);
    public function getIsSuccess() : bool;
    public function getData() : array;
    public function getStatusCode() : int;
    public function getMessage() : string;
    public function toArray() : array;
    public function successCallback(Closure $callback) : self;
    public function failureCallback(Closure $callback) : self;
    public function getTransaction() : Transaction;
}
