<?php
namespace App\Integrations\Statistics\WebEngage;

use App\Enums\PaymentMethods;
use App\Models\Transaction;
use Error;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Actions\ApiRequestAction;

class PaymentFailure {
    private string $url;
    private const EVENT_NAME = "Payment_Failure";

    public function __construct(
        private Transaction $transaction,
        private string $reason
    ) {
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
        Log::channel("webengage-events")->info("PAYMENT_FAILURE_EVENT: start", ['request-body' => $data]);

        try {
            $response = Http::withToken(config("webengage.api_key"))
            ->post($this->url, $data)
            ->json();

            resolve(ApiRequestAction::class)->handle([
                'name' => 'PaymentFailureWebEngage',
                'model_name' => 'Transaction',
                'model_id' => $this->transaction->id,
                'client_id' => $this->transaction->customer_id,
                'url' => $this->url,
                'req' => json_encode($data),
                'res' => $response->getBody()->getContents(),
                'http_code' => $response->status(),
            ]);

            //Log::channel("webengage-events")->info("PAYMENT_FAILURE_EVENT: end", ['response-body' => $response]);
        } catch (RequestException | ConnectionException $e) {
            Log::channel("webengage-events")->info("PAYMENT_FAILURE_EVENT: end-provider-exception", [
                'exception-message' => $e->getMessage(),
                'exception-trace' => $e->getTrace()
            ]);
        } catch (Exception | Error $e) {
            Log::channel("webengage-events")->info("PAYMENT_FAILURE_EVENT: end-internal-exception", [
                'exception-message' => $e->getMessage(),
                'exception-trace' => $e->getTrace()
            ]);
        }
    }

    private function prepareData() : array {
        return [
            "Reason" => $this->reason,
            "Payment_Mode" => PaymentMethods::paymentEnglishName($this->transaction->payment_method),
            "Total_Amount" => $this->transaction->total_amount,
        ];
    }
}
