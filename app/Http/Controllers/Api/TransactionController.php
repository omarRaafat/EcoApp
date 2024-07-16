<?php

namespace App\Http\Controllers\Api;

use App\Enums\PaymentMethods;
use Illuminate\Http\JsonResponse;
use App\Services\Api\TransactionService;
use Illuminate\Http\Request;
use App\Http\Requests\Api\CheckoutRequest;
use App\Http\Requests\Api\PayWithWalletRequest;
use App\Http\Requests\Api\TransactionRateStore;
use App\Services\Api\TransactionServiceReader;
use App\Services\Eportal\Connection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use App\Models\Transaction;
use App\Integrations\Shipping\Integrations\Aramex\Aramex;
use App\Events\Transaction as TransactionEvents;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use App\Models\TransactionProcessRate;
use App\Models\OrderProcessRate;
use App\Jobs\SendSmsJob;
use App\Repositories\Api\TransactionRepository;
use App\Repositories\Api\OrderRepository;

class TransactionController extends ApiController
{
    protected $orderRepo;

    /**
     * Cart Controller Constructor.
     *
     * @param CartService $service
     */
    public function __construct(private TransactionService $service,
            private TransactionServiceReader $readerService,
            public TransactionRepository  $transactionRepository,
            OrderRepository $orderRepo,
            Request $request
        )
    {
        $this->orderRepo = $orderRepo;
    }

    /**
     * List all user Trasactions.
     *
     * @return JsonResponse
     */
    public function userOrders(): JsonResponse
    {
        $response = $this->readerService->getUserOrders();
        return $this->setApiResponse(
                $response['success'],
                $response['status'],
                $response['data'],
                $response['message']
            );
    }

    /**
     * List user current orders.
     *
     * @return JsonResponse
     */
    public function trackUserOrders(): JsonResponse
    {
        $response = $this->readerService->trackUserCurrentOrders();
        return $this->setApiResponse(
                $response['success'],
                $response['status'],
                $response['data'],
                $response['message']
            );
    }

    /**
     * get order daitails.
     *
     * @param transaction_id
     * @return JsonResponse
     */
    public function orderDetails(int $transaction_id): JsonResponse
    {
        $response = $this->readerService->getOrderDetails($transaction_id);
        // dd($response);
        return $this->setApiResponse(
                $response['success'],
                $response['status'],
                $response['data'],
                $response['message']
            );
    }
    public function orderServicesDetails($transactionId)
    {
        $response = $this->readerService->orderServicesDetails($transactionId);
        return $this->setApiResponse(
            $response['success'],
            $response['status'],
            $response['data'],
            $response['message']
        );
    }

    public function getOrderDetailsForRate(int $transaction_id): JsonResponse
    {
        $response = $this->readerService->getOrderDetailsForRate($transaction_id);
        return $this->setApiResponse(
                $response['success'],
                $response['status'],
                $response['data'],
                $response['message']
            );
    }
    public function getOrderServiceDetailsForRate($transactionId)
    {
        $response = $this->readerService->getOrderServiceDetailsForRate($transactionId);
        return $this->setApiResponse(
                $response['success'],
                $response['status'],
                $response['data'],
                $response['message']
            );
    }

    public function saveOrderRate(int $transaction_id, TransactionRateStore $request)
    {
        $response = $this->service->saveOrderRate($transaction_id, $request);
        return $this->setApiResponse(
                $response['success'],
                $response['status'],
                $response['data'],
                $response['message']
            );
    }

    public function checkout(CheckoutRequest $request)
    {
        $response = $this->transactionRepository->checkout($request);

        return $this->setApiResponse(
            $response['success'],
            $response['status'] ?? Response::HTTP_BAD_REQUEST,
            $response['data'] ?? [],
            $response['message']
        );
    }

    public function serviceCheckout(CheckoutRequest $request)
    {
        $response = $this->transactionRepository->serviceCheckout($request->validated());
        return $this->setApiResponse(
            $response['success'],
            $response['status'] ?? Response::HTTP_BAD_REQUEST,
            $response['data'] ?? [],
            $response['message']
        );
    }


    public function pay_callback(Request $request)
    {
        return $this->transactionRepository->paymentCallback($request);
    }


    public function cancelOrder(Request $request){
		$validator = Validator::make($request->all(), [
            'transaction_id' => 'required',
            'order_id' => 'required',
            'reason' => 'required|string|min:3|max:5000',
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=> false,'message' => $validator->errors()->first()])->setStatusCode(400);
        }

        $transaction = Transaction::owClient()->whereIn('status',['registered','paid'])->find(intval($request->transaction_id));
        if(!$transaction){
            return response()->json(['status'=> false,'message' => 'الطلب لا يوجد!'])->setStatusCode(404);
        }

        $order = Order::where('transaction_id',$transaction->id)->whereIn('status',['registered','paid'])->find(intval($request->order_id));
        if(!$order){
            return response()->json(['status'=> false,'message' => 'لايمكن إلغاء الطلب'])->setStatusCode(404);
        }

        if($order->orderShip){
            return response()->json(['status'=> false,'message' => 'لايمكن إلغاء الطلب'])->setStatusCode(404);
        }


        #cancel repository
        $isCanceled = $this->orderRepo->cancel($order);
        if($isCanceled['success'] == false){
            return response()->json(['status'=> false,'message' => $isCanceled['message'] ]);
        }

        #change transaction status
        if(!$order->transaction->orders()->where('status','!=','canceled')->exists()){
            $order->transaction->update(['status' => 'canceled']);
            event(new TransactionEvents\Cancelled($order->transaction));
        }

        return response()->json(['status'=> true,'message' =>  __('translation.canceled')]);
    }

    public function successOrderFeedback(Request $request){
        $validator = Validator::make($request->all(), [
            'EaseSpeed' => 'required|numeric|min:1|max:5',
            'FreshnessInformation' => 'required|numeric|min:1|max:5',
            'EaseUse' => 'required|numeric|min:1|max:5',
            'ContactSupport' => 'required|numeric|min:1|max:5',
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=> false,'message' => $validator->errors()->first()])->setStatusCode(400);
        }

        $transaction = Transaction::where('customer_id',auth('api_client')->user()->id)->latest()->first();
        if(!$transaction){
            return response()->json(['status'=> false,'message' => 'طلب غير موجود!'])->setStatusCode(404);
        }
        if(!empty($transaction->processRate)){
            return response()->json(['status'=> false,'message' => 'تم تقييم الطلب مسبقا!'])->setStatusCode(403);
        }

        TransactionProcessRate::create([
            'transaction_id' => $transaction->id,
            'EaseSpeed' => $request->EaseSpeed,
            'FreshnessInformation' => $request->FreshnessInformation,
            'EaseUse' => $request->EaseUse,
            'ContactSupport' => $request->ContactSupport,
        ]);

        return response()->json(['status'=> true,'message' => 'تمت التقييم بنجاح']);
    }

    public function OrderVendorFeedback(Request $request){
        $validator = Validator::make($request->all(), [
            'transaction_id' => 'required',
            'order_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=> false,'message' => $validator->errors()->first()])->setStatusCode(400);
        }

        $transaction = Transaction::where('customer_id',auth('api_client')->user()->id)->find(intval($request->transaction_id));
        if(!$transaction){
            return response()->json(['status'=> false,'message' => 'طلب غير موجود!'])->setStatusCode(404);
        }
        $order = Order::where('transaction_id',$transaction->id)->find($request->order_id);
        if(!$order){
            return response()->json(['status'=> false,'message' => 'طلب غير موجود!'])->setStatusCode(404);
        }

        if($order->orderShipping->shipping_type_id == 2){ //توصيل
            $validator = Validator::make($request->all(), [
                'orderArrivalSpeed' => 'required|numeric|min:1|max:5',
                'deliveryRepInteraction' => 'required|numeric|min:1|max:5',
                'productSafetyAfterDelivery' => 'required|numeric|min:1|max:5',
                'repResponseTime' => 'required|numeric|min:1|max:5',
            ]);

            if ($validator->fails()) {
                return response()->json(['status'=> false,'message' => $validator->errors()->first()])->setStatusCode(400);
            }
        }
        else{ //إستلام بنفسي
            $validator = Validator::make($request->all(), [
                'merchantInteraction' => 'required|numeric|min:1|max:5',
                'storeOrganization' => 'required|numeric|min:1|max:5',
                'productAvailability' => 'required|numeric|min:1|max:5',
            ]);

            if ($validator->fails()) {
                return response()->json(['status'=> false,'message' => $validator->errors()->first()])->setStatusCode(400);
            }
        }

        if(!empty($order->processRate)){
            return response()->json(['status'=> false,'message' => 'تم تقييم الطلب مسبقا!'])->setStatusCode(403);
        }

        OrderProcessRate::create([
            'transaction_id' => $transaction->id,
            'order_id' => $order->id,
            'shipping_type_id' => $order->orderShipping->shipping_type_id,
            'merchantInteraction' => intval($request->merchantInteraction),
            'storeOrganization' => intval($request->storeOrganization),
            'productAvailability' => intval($request->productAvailability),
            'orderArrivalSpeed' => intval($request->orderArrivalSpeed),
            'deliveryRepInteraction' => intval($request->deliveryRepInteraction),
            'productSafetyAfterDelivery' => intval($request->productSafetyAfterDelivery),
            'repResponseTime' => intval($request->repResponseTime),
        ]);

        return response()->json(['status'=> true,'message' => 'تمت التقييم بنجاح']);
    }

}
