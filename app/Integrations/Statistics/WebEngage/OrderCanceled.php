<?php
namespace App\Integrations\Statistics\WebEngage;

use App\Models\Transaction;
use Error;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OrderCanceled {
    private Transaction $transaction;
    private string $url;
    private const EVENT_NAME = "Order_Canceled";

    public function __construct(Transaction $transaction) {
        $this->transaction = $transaction->load(['orders.products']);
        $this->url = config("webengage.base_url"). "/v1/accounts/". config("webengage.license_code") ."/events";
    }

    public function __invoke()
    {
        $data = [
            "userId" => $this->transaction->customer_id,
            "eventName" => self::EVENT_NAME,
            "eventTime" => now()->toDateTimeString(),
            "eventData" => $this->prepareData()
        ];
        Log::channel("webengage-events")->info("ORDER_CANCELED_EVENT: start", ['request-body' => $data]);

        try {
            $response = Http::withToken(config("webengage.api_key"))
            ->post($this->url, $data)
            ->json();
            Log::channel("webengage-events")->info("ORDER_CANCELED_EVENT: end", ['response-body' => $response]);
        } catch (RequestException | ConnectionException $e) {
            Log::channel("webengage-events")->info("ORDER_CANCELED_EVENT: end-provider-exception", [
                'exception-message' => $e->getMessage(),
                'exception-trace' => $e->getTrace()
            ]);
        } catch (Exception | Error $e) {
            Log::channel("webengage-events")->info("ORDER_CANCELED_EVENT: end-internal-exception", [
                'exception-message' => $e->getMessage(),
                'exception-trace' => $e->getTrace()
            ]);
        }
    }

    private function prepareData() : array {
        $data = [
            "Cancellation Reason" => $this->transaction->note ?? "",
            "Products" => [],
            "Order_Amount" => $this->transaction->total_amount,
        ];
        foreach($this->transaction->orders ?? [] as $order) {
            foreach($order->products ?? [] as $product) {
                array_push($data['Products'],[
                    "Product_Details" => strip_tags($product->getTranslation("desc", "en") ?? ""),
                ]);
            }
        }
        return $data;
    }
}
