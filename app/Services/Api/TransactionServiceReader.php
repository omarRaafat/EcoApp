<?php
namespace App\Services\Api;

use App\Enums\OrderStatus;
use App\Http\Resources\Api\OrderTrackingResource;
use App\Http\Resources\Api\TransactionDeatailsResource;
use App\Http\Resources\Api\TransactionForRateResource;
use App\Http\Resources\Api\TransactionResource;
use App\Http\Resources\Api\TransactionServicesDetailsResource;
use App\Models\Transaction;
use App\Scopes\ProductCountryScope;

/**
 * This class for all read operations from Database
 */
class TransactionServiceReader {
    /**
     * @param $customerId
     * @return array
     */
    public function getUserOrders() {
        return [
            'success' => true,
            'status' => 200,
            'data' => TransactionResource::collection(Transaction::owClient()->descOrder()->get()),
            'message' => __('order.api.retrieved')
        ];
    }

    /**
     * @param $customerId
     * @return array
     */
    public function trackUserCurrentOrders() {
        $transaction = Transaction::descOrder()->where('customer_id',auth('api_client')->user()->id)
        ->notStatuses([OrderStatus::COMPLETED, OrderStatus::CANCELED, OrderStatus::SHIPPING_DONE])
        ->with([
                    'services' => fn($services) => $services->with(['service' => fn($q) => $q->Available()->Accepted()]),
                    'products' => function ($query) {
                $query->with([
                    'product' => fn($p) => $p->withTrashed()->withoutGlobalScope(ProductCountryScope::class)
                ]);
            },
        ])
        ->get();
        return [
            'success' => true,
            'status' => 200,
            'data' => OrderTrackingResource::collection($transaction),
            'message' => __('order.api.retrieved')
        ];
    }

    /**
     * @param $transactionId
     * @return array
     */
    public function getOrderDetails($transactionId) {
        $transaction = Transaction::query()->customer(auth('api_client')->user()->id)->id($transactionId)
            ->with(['orderServices' => function($q){
                return $q->with([
                    'services' => fn($services) => $services->Available()->Accepted(),
                    'transaction' => fn($t) => $t->select('id', 'status')
                ]);
            },'orders' => function ($q) {
                return $q->with([
                    'products' => fn($prodQ) => $prodQ->withoutGlobalScope(ProductCountryScope::class)->withTrashed(),
                    'transaction' => fn($t) => $t->select('id', 'status')
                ]);
            }])
            ->first();
            if($transaction)
                return [
                    'success' => true,
                    'status' => 200,
                    'data' => new TransactionDeatailsResource($transaction),
                    'message' => __('order.api.retrieved')
                ];
            return [
                'success' => false,
                'status' => 400,
                'data' => [],
                'message' => __('order.api.order_not_found')
            ];
    }
    public function orderServicesDetails($transactionId)
    {
        $transaction = Transaction::query()->customer(auth('api_client')->user()->id)->id($transactionId)
            ->with(['orderServices' => function ($q) {
                return $q->with([
                    'services' => fn($services) => $services->Available()->Accepted(),
                    'transaction' => fn($t) => $t->select('id', 'status')
                ]);
            }])
            ->first();
            return [
                'success' => true,
                'status' => 200,
                'data' => new TransactionServicesDetailsResource($transaction),
                'message' => __('order.api.retrieved')
            ];
    }

    /**
     * @param $transactionId
     * @return array
     */
    public function getOrderDetailsForRate($transactionId) {
        $customerId = auth('api_client')->user()->id;
        $transaction = Transaction::query()->customer($customerId)->id($transactionId)
            ->statuses([OrderStatus::COMPLETED ,OrderStatus::SHIPPING_DONE])
            ->with([
                'orders' => fn($orderQuery) => $orderQuery->with([
                    'vendor' => fn($vendorQuery) => $vendorQuery->with([
                        'userVendorRates' => fn($rateQuery) => $rateQuery->where('user_id', $customerId)->where('transaction_id', $transactionId)
                    ])
                    ->withTrashed(),
                    'products' => function($productsQuery) use ($transactionId, $customerId) {
                        $productsQuery
                        ->withoutGlobalScope(ProductCountryScope::class)
                        ->with([
                            'reviews' => fn($reviewsQuery) => $reviewsQuery
                                ->customer($customerId)
                                ->transaction($transactionId)
                        ])
                        ->withTrashed();
                    },
                ])
            ])
            ->first();

        if($transaction == null ){
            return [
                'success' => false,
                'status' => 404,
                'data' => [],
                'message' => __('order.api.order_not_found')
            ];
        }
        return [
            'success' => true,
            'status' => 200,
            'data' =>  new TransactionForRateResource($transaction),
            'message' => __('order.api.retrieved')
        ];
    }
    public function getOrderServiceDetailsForRate($transactionId)
    {
        $customerId = auth('api_client')->user()->id;
        $transaction = Transaction::query()->customer($customerId)->id($transactionId)
            ->statuses([OrderStatus::COMPLETED])
            ->with([
                'orderServices' => fn($orderQuery) => $orderQuery->with([
                    'vendor' => fn($vendorQuery) => $vendorQuery->with([
                        'userVendorRates' => fn($rateQuery) => $rateQuery->where('user_id', $customerId)->where('transaction_id', $transactionId)
                    ])
                    ->withTrashed(),
                    'services' => function($serviceQuery) use ($transactionId, $customerId) {
                        $serviceQuery
                        ->with([
                            'reviews' => fn($reviewsQuery) => $reviewsQuery
                                ->customer($customerId)
                                ->transaction($transactionId)
                        ])
                        ->withTrashed();
                    },
                ])
            ])
            ->first();

        if($transaction == null ){
            return [
                'success' => false,
                'status' => 404,
                'data' => [],
                'message' => __('order.api.order_not_found')
            ];
        }
        return [
            'success' => true,
            'status' => 200,
            'data' =>  new TransactionForRateResource($transaction),
            'message' => __('order.api.retrieved')
        ];
    }
}
