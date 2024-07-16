<?php
namespace App\Integrations\Statistics\WebEngage;

use App\Models\Transaction;
use Error;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ShippingDetailsUpdated {
    private Transaction $transaction;
    private string $url;
    private const EVENT_NAME = "ShippingDetailsUpdated";

    public function __construct(Transaction $transaction) {
        $this->transaction = $transaction->load(["addresses" => fn($a) => $a->with("country", "area", "city")]);
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
        Log::channel("webengage-events")->info("SHIPPING_DETAILS_UPDATED_EVENT: start", ['request-body' => $data]);

        try {
            $response = Http::withToken(config("webengage.api_key"))
            ->post($this->url, $data)
            ->json();
            Log::channel("webengage-events")->info("SHIPPING_DETAILS_UPDATED_EVENT: end", ['response-body' => $response]);
        } catch (RequestException | ConnectionException $e) {
            Log::channel("webengage-events")->info("SHIPPING_DETAILS_UPDATED_EVENT: end-provider-exception", [
                'exception-message' => $e->getMessage(),
                'exception-trace' => $e->getTrace()
            ]);
        } catch (Exception | Error $e) {
            Log::channel("webengage-events")->info("SHIPPING_DETAILS_UPDATED_EVENT: end-internal-exception", [
                'exception-message' => $e->getMessage(),
                'exception-trace' => $e->getTrace()
            ]);
        }
    }

    private function prepareData() : array {
        return [
            "Shipping_Address" => $this->transaction->addresses ? $this->transaction->addresses->description : "",
            "City" => $this->transaction?->addresses?->city ? $this->transaction?->addresses?->city?->getTranslation("name", "ar") : "",
            "State" => $this->transaction?->addresses?->area ? $this->transaction?->addresses?->area?->getTranslation("name", "ar") : "",
            "Country" => $this->transaction?->addresses?->country ? $this->transaction?->addresses?->country?->getTranslation("name", "ar") : "",
        ];
    }
}
