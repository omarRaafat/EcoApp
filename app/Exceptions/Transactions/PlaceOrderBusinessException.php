<?php
namespace App\Exceptions\Transactions;

use App\Http\Resources\Api\CartResource;
use Exception;

class PlaceOrderBusinessException extends Exception {
    private CartResource $cartResource;
    private array $messages = [];

    private $status;

    public function __construct(string $msg , $status = 406 ) {
        parent::__construct($msg , $status);
    }

    public function setCartResource(CartResource $cartResource) : self {
        $this->cartResource = $cartResource;
        return $this;
    }

    public function getCartResource() : CartResource | null {
        return isset($this->cartResource) ? $this->cartResource : null;
    }

    public function setMessages(array $messages) : self {
        $this->messages = $messages;
        return $this;
    }

    public function setStatus(int $status) : self {
        $this->status = $status;
        return $this;
    }

    public function getMessages() : array {
        return $this->messages;
    }

    public function getStatus(): int
    {
        return (int) $this->status;
    }
}
