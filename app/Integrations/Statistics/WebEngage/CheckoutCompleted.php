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

class CheckoutCompleted {
    private Transaction $transaction;
    private string $url;
    private const EVENT_NAME = "Checkout_Completed";

    public function __construct(Transaction $transaction) {
        $this->transaction = $transaction->load([
            'coupon',
            'orders' => fn($o) => $o->with([
                'products' => fn($p) => $p->with(['finalSubCategory', 'subCategory', 'category'])
            ])
        ]);
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

        Log::channel("webengage-events")->info("CHECKOUT_COMPLETED_EVENT: start", [
            'request-url' => $this->url,
            'request-body' => $data,
            'request-api-key' => config("webengage.api_key")
        ]);

        try {
            $response = Http::withToken(config("webengage.api_key"))
            ->post($this->url, $data)
            ->json();

            resolve(ApiRequestAction::class)->handle([
                'name' => 'CheckoutWebEngage',
                'model_name' => 'Transaction',
                'model_id' => $this->transaction->id,
                'client_id' => $this->transaction->customer_id,
                'url' => $this->url,
                'req' => json_encode($data),
                'res' => $response->getBody()->getContents(),
                'http_code' => $response->status(),
            ]);


           /* Log::channel("webengage-events")->info("CHECKOUT_COMPLETED_EVENT: end", [
                'response-body' => $response
            ]);*/
        } catch (RequestException | ConnectionException $e) {
            Log::channel("webengage-events")->info("CHECKOUT_COMPLETED_EVENT: end-provider-exception", [
                'exception-message' => $e->getMessage(),
                'exception-trace' => $e->getTrace()
            ]);
        } catch (Exception | Error $e) {
            Log::channel("webengage-events")->info("CHECKOUT_COMPLETED_EVENT: end-internal-exception", [
                'exception-message' => $e->getMessage(),
                'exception-trace' => $e->getTrace()
            ]);
        }
    }

    private function prepareData() : array {
        $data = [
            "Order_Id" => $this->transaction->code,
            "Payment_Mode" => PaymentMethods::paymentEnglishName($this->transaction->payment_method),
            "Products" => [],
            "No_Of_Products" => $this->transaction->products_count,
            "Total_Amount" => $this->transaction->total_amount,
            "Discount_Amount" => $this->transaction->discount_in_sar,
            "Coupon_Code" => $this->transaction->coupon ? $this->transaction->coupon->code : "",
            "Sub_Total" => $this->transaction->sub_total_in_sar,
            "Shipping_Charges" => $this->transaction->delivery_fees_in_sar,
            "Tax_Charged" => $this->transaction->vat_rate,
        ];
        foreach($this->transaction->orders ?? [] as $order) {
            foreach($order->products ?? [] as $product) {
                if ($product->finalSubCategory) {
                    $category = $product->finalSubCategory;
                } else if ($product->subCategory) {
                    $category = $product->subCategory;
                } else {
                    $category = $product->category;
                }

                array_push($data['Products'],[
                    "Product_Name" => $product->getTranslation("name", "en", "ar"),
                    "Category_Name" => $category ? $category->getTranslation("name", "en", "ar") : "",
                    "Category_Id" => $category ? $category->id : "",
                    "Product_Details" => strip_tags($product->getTranslation("desc", "en", "ar") ?? ""),
                ]);
            }
        }
        return $data;
    }
}
