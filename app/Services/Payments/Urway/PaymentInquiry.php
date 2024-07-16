<?php
namespace App\Services\Payments\Urway;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethods;
use App\Models\Transaction;
use Exception;
use Illuminate\Support\Facades\Log;
use URWay\Client as UrwayClient;

class PaymentInquiry extends UrwayClient {
    public function __construct(
        private Transaction $transaction
    ) {
        try {
            if (!in_array($this->transaction->status, [OrderStatus::REGISTERD, OrderStatus::PAID])) throw new Exception("Transaction status is missed (must be register to do a payment inquiry)");
            if ($this->transaction->payment_method != PaymentMethods::VISA) throw new Exception("Transaction payment method is missed (must be visa to do a payment inquiry)");
            if (!$this->transaction->urwayTransaction)  throw new Exception("Urway Transaction is missed (must exists in our system to do a payment inquiry)");
        } catch (Exception $e) {
            Log::channel("urway")->info("Urway inquiry request exception at ourside: {$e->getMessage()}");
            throw $e;
        }

        parent::__construct();
    }

    /**
     * @return bool
     */
    public function __invoke() : bool {
        $this->setTrackId($this->transaction->cart_id)
            ->setAmount(1)
            ->setCurrency(Constants::currency);

        $response = $this->find($this->transaction->urwayTransaction->urway_payment_id);

        Log::channel("urway")->info(
            "Urway inquiry request from ourside",
            ['request_data' => $this->attributes, 'response_data' => (array)$response]
        );

        $result = null;
        foreach ((array)$response as $key => $item) {
            switch ($key) {
                case 'result':
                    $result = $item;
                    break;
                default:
                    if (is_array($item)) {
                        if (isset($item['result'])) {
                            $result = $item['result'];
                        }
                    }
                    break;
            }
        }

        return $result == Constants::inquirySuccess;
    }
}
