<?php

namespace App\Services\Api;

use App\Enums\ClientMessageEnum;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethods;
use App\Models\Transaction;
use App\Events\Transaction as TransactionEvents;
use App\Exceptions\Transactions\Addresses\AddressIsInternational;
use App\Exceptions\Transactions\PlaceOrderBusinessException;
use App\Services\Alinma;
use App\Services\ClientMessageService;
use App\Services\Product\StockDecrement;
use Illuminate\Http\Request;
use App\Repositories\Api\CartRepository;
use App\Http\Requests\Api\TransactionRateStore;
use App\Jobs\WebEngage\PaymentFailure;
use App\Models\Address;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\OnlinePayment;
use App\Models\TabbyTransaction;
use App\Models\UrwayTransaction;
use App\Scopes\ProductCountryScope;
use App\Services\Eportal\Connection;
use App\Services\Order\CalculatorComponent;
use App\Services\Order\CartComponent;
use App\Services\Order\OrderProcess;
use App\Services\Payments\Urway\UrwayServices;
use Illuminate\Http\RedirectResponse;
use App\Services\Payments\Tabby\Constants;
use App\Services\Wallet\UpdateWalletBalanceEportal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Actions\ApiRequestAction;

class TransactionService
{
    private int $customerId;


    /**
     * @param CartRepository $cartRepository
     */
    public function __construct(public CartRepository $cartRepository)
    {
        
    }


    /**
     * @param int $transactionId
     * @param TransactionRateStore $request
     * @return array
     */
    public function saveOrderRate(int $transactionId, TransactionRateStore $request)
    {

        $transaction = Transaction::query()
            ->customer(auth('api_client')->user()->id)
            ->id($transactionId)
            ->statuses([OrderStatus::COMPLETED, OrderStatus::SHIPPING_DONE])
            ->with([
                'orders' => fn($orderQuery) => $orderQuery->with([
                    'vendor' => fn($vendorQuery) => $vendorQuery->with([
                        'userVendorRates' => fn($rateQuery) => $rateQuery->where('user_id', auth('api_client')->user()->id)->where('transaction_id', $transactionId)
                    ]),
                    'products' => function ($productsQuery) use ($transactionId) {
                        $productsQuery
                            ->withoutGlobalScope(ProductCountryScope::class)
                            ->with([
                                'reviews' => fn($reviewsQuery) => $reviewsQuery
                                    ->customer(auth('api_client')->user()->id)
                                    ->transaction($transactionId)
                            ]);
                    },
                ])
            ])
            ->first();


        if ($transaction == null) {
            return [
                'success' => false,
                'status' => 404,
                'data' => [],
                'message' => __('order.api.order_not_found')
            ];
        }

        foreach ($request->vendors as $vendorData) {
            $order = $transaction->orders->where('vendor_id', $vendorData['id'])->first();
            if (!$order) continue; // ignore non exists orders

            $vendor = $order->vendor;

            // add rate to vendor in case customer doesn't rate the vendor in this transaction
            if ($vendor->userVendorRates->isEmpty() && $vendorData['rate']) {
                $vendor->userVendorRates()->create([
                    'user_id' => auth('api_client')->user()->id,
                    'rate' => $vendorData['rate'],
                    'transaction_id' => $transactionId
                ]);
            }

            foreach ($vendorData['products'] as $productData) {
                $productOrder = $order->products->where('id', $productData['id'])->first();

                if (!$productOrder || (!$productData['rate'] && !isset($productData['review']))) continue; // ignore non exists products
                if ($productOrder->reviews->isEmpty()) {
                    $productOrder->reviews()->create([
                        'user_id' => auth('api_client')->user()->id,
                        'rate' => $productData['rate'],
                        'comment' => $productData['review'] ?? "",
                        'transaction_id' => $transactionId
                    ]);
                }
            }
        }

        return [
            'success' => true,
            'status' => 200,
            'data' => [],
            'message' => __('products.api.product_review_created')
        ];
    }


 




}
