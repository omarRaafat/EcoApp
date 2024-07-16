<?php
namespace App\Services\Payments\Urway;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use URWay\Client as UrwayClient;

class PaymentCallback extends UrwayClient {
    public function __construct(
        private Request $request
    ) {
        parent::__construct();
    }

    public function __invoke() : mixed {
        $this->setTrackId($this->request->TrackId)
            ->setAmount($this->request->amount)
            ->setCurrency(Constants::currency);

        Log::channel("urway")->info("Urway callback request", ['request_data' => $this->request->toArray()]);
        return $this->find($this->request->TranId);
    }
}
