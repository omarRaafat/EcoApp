<?php

namespace App\Repositories\Api;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Api\BaseRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Exceptions\Transactions\PlaceOrderBusinessException;
use App\Enums\PaymentMethods;
use App\Enums\OrderStatus;
use App\Enums\ClientMessageEnum;
use App\Enums\ServiceOrderStatus;
use App\Services\Eportal\Connection;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Vendor;
use App\Models\Order;
use App\Models\OrderVendorShipping;
use App\Models\OrderVendorShippingWarehouse;
use App\Services\Payments\Urway\UrwayServices;
use App\Services\Payments\Urway\Constants as UrwayConstants;
use App\Services\Product\StockDecrement;
use App\Services\Payments\Tabby\Tabby;
use App\Services\ClientMessageService;
use App\Events\Transaction as TransactionEvents;
use App\Models\UrwayTransaction;
use App\Models\TabbyTransaction;
use App\Jobs\SendSmsJob;
use App\Models\OnlinePayment;
use App\Models\CartProduct;
use App\Models\CartProductServiceField;
use App\Models\CartVendorMethodPay;
use App\Models\OrderProduct;
use App\Models\OrderService;
use App\Models\OrderServiceDetail;
use App\Models\OrderServiceFields;
use App\Models\ProductWarehouseStock;
use App\Models\Service;
use App\Models\WarehouseCity;

class TransactionRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return Transaction::class;
    }

    # checkout
    public function checkout($request)
    {
        $cart = Cart::with(['cartProducts','vendors'])->owClient()->where('is_active',1)->latest()->first();
        if (!$cart) return ['success'=>false,'message'=>__("cart.api.cart_is_empty")];

        #when refresh cart, disabled currect proccess paying
        $UrwayTransaction = UrwayTransaction::where('statusCallback',null)->where('status',UrwayConstants::pending)->where('cart_id',$cart->id)->update(['status' => UrwayConstants::failed, 'statusCallback'=>'refreshCart']);
        $TabbyTransaction = TabbyTransaction::where('statusCallback',null)->where('status',UrwayConstants::pending)->where('cart_id',$cart->id)->update(['status' => UrwayConstants::failed, 'statusCallback'=>'refreshCart']);

        //validateLogistic
        if (!$cart->isAddressValidForDelivery()) {
            return  ['success'=>false,'message'=> __("cart.api.address-out-of-coverage")];
        }

        $cartVendorsIds= array_unique($cart->cartProducts()->pluck('vendor_id')->toArray());

        //validation cart
        #check duplicate
        foreach ($cartVendorsIds as $key => $cartVendorId) {
            if($cart->cartVendorShippings()->where('vendor_id' ,$cartVendorId )->count() > 1){
                $firstId = $cart->cartVendorShippings()->where('vendor_id' ,$cartVendorId)->first()?->id;
                $cart->cartVendorShippings()->where('vendor_id', $cartVendorId)->where('id','!=',$firstId)->delete();
            }
        }

        #check request vendors
        $checkAllVendors = array_diff(collect(request()->vendors)->pluck('vendor_id')->toArray() ,  $cartVendorsIds);
        if(!empty($checkAllVendors)){
            return  ['success'=>false,'message'=> __("cart.api.checkout.vandor_not_cart")];
        }

        //validateProducts
        $checkAvailabeProducts= ($cart->availableCartProducts()->count() != $cart->cartProducts->count());
        if($checkAvailabeProducts)  return  ['success'=>false,'message'=> __("cart.api.cannot_checkout_product_missing")];

        #check shippinge_type
        $checkShippingTypeId = array_diff( $cart->cartVendorShippings()->where('shipping_type_id','!=',null)->pluck('vendor_id')->toArray() ,  $cartVendorsIds);
        if(!empty($checkShippingTypeId)) return  ['success'=>false,'message'=> __("cart.api.select_shipping_type")];

        #check shipping methods
        $checkShippingMethods = $cart->cartVendorShippings()->where('shipping_type_id',2)->where('shipping_method_id',null)->count();
        if($checkShippingMethods) return  ['success'=>false,'message'=> __("cart.api.select_shipping_type")];

        #check warehouses

        #check warehouses stock  (shipping_type_id = 1)
        $getShippingType1VendorsId = $cart->cartVendorShippings()->where('shipping_type_id',1)->pluck('vendor_id')->toArray();
        foreach ($cart->cartProducts()->whereIn('vendor_id',$getShippingType1VendorsId)->get() as $key => $cartProduct) {
            if(empty($cartProduct->warehouse_id)) return  ['success'=>false,'message'=> __("cart.api.select_warehouse",['product'=>$cartProduct->product->name])];

            $warehouseStock = ProductWarehouseStock::where('product_id',$cartProduct->product_id)->where('warehouse_id',$cartProduct->warehouse_id)->first();
            if (!$warehouseStock || $warehouseStock->stock <= 0)  return  ['success'=>false,'message'=> __("cart.api.no_stock_available_choose_another_warehouse",['product' => $cartProduct->product->name])];

            if($cartProduct->quantity > $warehouseStock->stock && $warehouseStock->stock > 0){
                return  ['success'=>false,'message'=> __("cart.api.quantity_available_is_less_than_required",['product' => $cartProduct->product->name])];
            }
        }

        #check warehouses stock  (shipping_type_id = 2)
        $getShippingType2VendorsId = $cart->cartVendorShippings()->where('shipping_type_id',2)->pluck('vendor_id')->toArray();
        foreach ($cart->cartProducts()->whereIn('vendor_id',$getShippingType2VendorsId)->get() as $key => $cartProduct) {
            $cartVendorShipping = $cart->cartVendorShippings()->where('vendor_id',$cartProduct->vendor_id)->first();
            $warehouseStock = ProductWarehouseStock::where('product_id',$cartProduct->product_id)->where('warehouse_id', $cartVendorShipping?->delivery_warehouse_id )->first();
            if (!$warehouseStock || $warehouseStock->stock <= 0)  return  ['success'=>false,'message'=> __("cart.api.no_stock_available_choose_another_warehouse",['product' => $cartProduct->product->name])];
            if($cartProduct->quantity > $warehouseStock->stock && $warehouseStock->stock > 0){
                return  ['success'=>false,'message'=> __("cart.api.quantity_available_is_less_than_required",['product' => $cartProduct->product->name])];
            }
        }

        #validate wallet balance
        $userWallets=  [];
        $response = Connection::userAuthWallet(request());;
        if (!$response->successful() && intval($request->payment_id) == PaymentMethods::WALLET) {
            \Log::notice($response);
            return  ['success'=>false,'message'=> $response['message'] ?? __("cart.api.wallet_payment_failed") ];
        }else{
            $userWallets = collect($response->json()['data'] ?? []);
        }

        #Check available wallet balance
        $available_balance = [];
        $wallet_amount = 0;
        $visa_amount = 0;
        foreach(request()->vendors as $vendor){
            $vendorWalletAmount = 0;
            $vendorVisaAmount = 0;

            $total_product_price = $cart->cartProducts()->where('vendor_id' ,$vendor['vendor_id'] )->sum('total_price');
            $total_shipping_fees = $cart->cartVendorShippings()->where('vendor_id' ,$vendor['vendor_id'] )->first()?->total_shipping_fees ?? 0;
            $total_price_and_shipping = $total_product_price + $total_shipping_fees;

            //payment with wallet
            if($vendor['use_wallet'] == 1){
                $wallet = collect($userWallets)->where('wallet_id' , $vendor['wallet_id'])->first() ?? [];
                if(empty($wallet)){
                    return  ['success'=>false,'message'=> __("cart.api.checkout.wallet_enough_and_select_another_payment")];
                }

                if(!array_key_exists($vendor['wallet_id'], $available_balance)) {
                    $available_balance[$vendor['wallet_id']] = $wallet['balance'] ?? 0;
                }

                if($total_price_and_shipping > $available_balance[$vendor['wallet_id']]){
                    if(intval($request->payment_id) == PaymentMethods::WALLET || $available_balance[$vendor['wallet_id']] == 0){
                        return  ['success'=>false,'message'=> __("cart.api.checkout.wallet_enough_and_select_another_payment")];
                    }
                    else{
                        $vendorWalletAmount =  $available_balance[$vendor['wallet_id']];
                        $vendorVisaAmount = ($total_price_and_shipping - $vendorWalletAmount);

                        $available_balance[$vendor['wallet_id']] -= $vendorWalletAmount;
                    }
                }else{
                    $vendorWalletAmount = $total_price_and_shipping;
                    $vendorVisaAmount = 0;

                    $available_balance[$vendor['wallet_id']] -= $vendorWalletAmount;
                }

            }
            else{ // other payment method (not wallet)
                $vendorWalletAmount = 0;
                $vendorVisaAmount = $total_price_and_shipping;

            }


            #update cartVendorShippings
            $cart->cartVendorShippings()->where('vendor_id' ,$vendor['vendor_id'] )->update([
                'wallet_id' => ($vendor['use_wallet'] == 1) ? $vendor['wallet_id'] : null,
                'total_products' => $cart->cartProducts()->where('vendor_id', $vendor['vendor_id'])->sum('total_price')
            ]);

            #update CartVendorMethodPay
            CartVendorMethodPay::updateOrCreate([
                    'cart_id' => $cart->id,
                    'vendor_id'=>$vendor['vendor_id']
                ],[
                'wallet_id' => ($vendor['use_wallet'] == 1 && $vendorWalletAmount >= 1) ? $vendor['wallet_id'] : null,
                'amount' => $vendorWalletAmount,
                'visa_amount' => $vendorVisaAmount
            ]);

            if($vendorWalletAmount < 1){
                $vendorVisaAmount += $vendorWalletAmount;
                $vendorWalletAmount = 0;
            }

            #calc all vendors
            $wallet_amount += $vendorWalletAmount;
            $visa_amount += $vendorVisaAmount;
        }

        if($wallet_amount < 1){
            $visa_amount += $wallet_amount;
            $wallet_amount = 0;
        }

        #update cart
        $cart->update([
            'wallet_amount' => $wallet_amount,
            'visa_amount' =>  round($visa_amount, 2),
        ]);

        // Refresh the cart
        $cart->refresh();

        //ordering by payment type
        if(intval($request->payment_id) == PaymentMethods::WALLET){ #WALLET
            return $this->ordering($cart, $userWallets, PaymentMethods::WALLET, $request);
        }
        elseif(intval($request->payment_id) == PaymentMethods::VISA){   #VISA
            $UrwayResponse = UrwayServices::generatePaymentUrl($cart);
            $paymentId = $UrwayResponse['payid'] ?? null;
            $status = ($UrwayResponse['result'] == "UnSuccessful" || !$paymentId) ? UrwayConstants::failed : UrwayConstants::pending;

            $cart->urwayTransaction()->create([
                "user_id" => $cart->user_id,
                "urway_payment_id" => $paymentId,
                "customer_ip" => request()->ip(),
                "response" => json_encode((array)$UrwayResponse),
                "visa_amount" => $cart->visa_amount,
                "wallet_amount" => $cart->wallet_amount,
                "status" => $status,
            ]);

            if ($status == UrwayConstants::pending && $UrwayResponse['targetUrl']) {
                return ['success' => true, 'status' => 200, 'message' => __("cart.api.payment_order_generated"), 'data' => ['link' => $UrwayResponse['targetUrl'] . '?paymentid=' . $paymentId]];
            } else {
                return ['success' => false, 'status' => 500, 'message' => __("cart.api.gateway-error"), 'data' => []];
            }

        }
        elseif(intval($request->payment_id) == PaymentMethods::TABBY){ #TABBY
            $response = (new Tabby)->checkout($cart);
            $paymentId = (isset( $response['payId'])) ?  $response['payId'] : null;
            $status = (isset($response['status'], $response['url'])  && $response['status'] != "error")  ? UrwayConstants::pending : UrwayConstants::failed;

            // TabbyTransaction
            $cart->tabbyTransaction()->create([
                "user_id" => $cart->user_id,
                "tabby_payment_id" => $paymentId,
                "customer_ip" => request()->ip(),
                "response" => json_encode((array)$response),
                "visa_amount" => $cart->visa_amount,
                "wallet_amount" => $cart->wallet_amount,
                "status" => $status,
                "payUuid" => $response['payUuid'] ?? null
            ]);
            if ($status == UrwayConstants::pending && isset($response['url'])) {
                return ['success' => true, 'status' => 200, 'message' => __("cart.api.payment_order_generated"), 'data' => ['link' => $response['url']]];
            } else {
                return ['success' => false, 'status' => 500, 'message' => __("cart.api.gateway-error"), 'data' => []];
            }

        }
    }

    public function serviceCheckout($request)
    {
        $cart = Cart::with(['cartProducts','vendors'])->where('user_id', auth('api_client')->user()?->id)->where('is_active',1)->latest()->first();
        if (!$cart) return ['success'=>false,'message'=>__("cart.api.cart_is_empty")];
        if($cart->cartProducts->count() > 0){
            foreach($cart->cartProducts as $item){
                $service = Service::with('cities')->where('id',$item->service_id)->first();
                if(!$service->cities->count() > 0)
                    return ['success'=>false,'message'=>__("cart.api.service_exist_in_cart")];
            }
        }
        #when refresh cart, disabled currect proccess paying
        $UrwayTransaction = UrwayTransaction::where('statusCallback',null)->where('status',UrwayConstants::pending)->where('cart_id',$cart->id)->update(['status' => UrwayConstants::failed, 'statusCallback'=>'refreshCart']);
        $TabbyTransaction = TabbyTransaction::where('statusCallback',null)->where('status',UrwayConstants::pending)->where('cart_id',$cart->id)->update(['status' => UrwayConstants::failed, 'statusCallback'=>'refreshCart']);
        $cartVendorsIds= array_unique($cart->cartProducts()->pluck('vendor_id')->toArray());
        #check request vendors
        $checkAllVendors = array_diff(collect(request()->vendors)->pluck('vendor_id')->toArray() ,  $cartVendorsIds);
        if(!empty($checkAllVendors)){
            return  ['success'=>false,'message'=> __("cart.api.checkout.vandor_not_cart")];
        }
        //validateProducts
        $checkAvailableServices= ($cart->availableCartServices()->count() != $cart->cartProducts->count());
        if($checkAvailableServices)  return  ['success'=>false,'message'=> __("cart.api.cannot_checkout_service_missing")];
        #validate wallet balance
        $userWallets=  [];
        $response = Connection::userAuthWallet(request());
        if (!$response->successful() && intval($request['payment_id']) == PaymentMethods::WALLET) {
            \Log::notice($response);
            return  ['success'=>false,'message'=> $response['message'] ?? __("cart.api.wallet_payment_failed") ];
        }else{
            $userWallets = collect($response->json()['data'] ?? []);
        }
        #Check available wallet balance
        $available_balance = [];
        $wallet_amount = 0;
        $visa_amount = 0;
        foreach(request()->vendors as $vendor){
            $vendorWalletAmount = 0;
            $vendorVisaAmount = 0;

            $total_service_price = $cart->cartProducts()->where('vendor_id' ,$vendor['vendor_id'] )->sum('total_price');
            // $total_shipping_fees = $cart->cartVendorShippings()->where('vendor_id' ,$vendor['vendor_id'] )->first()?->total_shipping_fees ?? 0;
            // $total_price_and_shipping = $total_product_price + $total_shipping_fees;

            //payment with wallet
            if($vendor['use_wallet'] == 1){
                $wallet = collect($userWallets)->where('wallet_id' , $vendor['wallet_id'])->first() ?? [];
                if(empty($wallet)){
                    return  ['success'=>false,'message'=> __("cart.api.checkout.wallet_enough_and_select_another_payment")];
                }

                if(!array_key_exists($vendor['wallet_id'], $available_balance)) {
                    $available_balance[$vendor['wallet_id']] = $wallet['balance'] ?? 0;
                }

                if($total_service_price > $available_balance[$vendor['wallet_id']]){
                    if(intval($request['payment_id']) == PaymentMethods::WALLET || $available_balance[$vendor['wallet_id']] == 0){
                        return  ['success'=>false,'message'=> __("cart.api.checkout.wallet_enough_and_select_another_payment")];
                    }
                    else{
                        $vendorWalletAmount =  $available_balance[$vendor['wallet_id']];
                        $vendorVisaAmount = ($total_service_price - $vendorWalletAmount);
                        $available_balance[$vendor['wallet_id']] -= $vendorWalletAmount;
                    }
                }else{
                    $vendorWalletAmount = $total_service_price;
                    $vendorVisaAmount = 0;

                    $available_balance[$vendor['wallet_id']] -= $vendorWalletAmount;
                }

            }
            else{ // other payment method (not wallet)
                $vendorWalletAmount = 0;
                $vendorVisaAmount = $total_service_price;

            }
            #update CartVendorMethodPay
            CartVendorMethodPay::updateOrCreate([
                    'cart_id' => $cart->id,
                    'vendor_id'=>$vendor['vendor_id']
                ],[
                'wallet_id' => ($vendor['use_wallet'] == 1 && $vendorWalletAmount >= 1) ? $vendor['wallet_id'] : null,
                'amount' => $vendorWalletAmount,
                'visa_amount' => $vendorVisaAmount
            ]);

            if($vendorWalletAmount < 1){
                $vendorVisaAmount += $vendorWalletAmount;
                $vendorWalletAmount = 0;
            }

            #calc all vendors
            $wallet_amount += $vendorWalletAmount;
            $visa_amount += $vendorVisaAmount;
        }

        if($wallet_amount < 1){
            $visa_amount += $wallet_amount;
            $wallet_amount = 0;
        }

        #update cart
        $cart->update([
            'wallet_amount' => $wallet_amount,
            'visa_amount' =>  round($visa_amount, 2),
        ]);

        // Refresh the cart
        $cart->refresh();

        //ordering by payment type
        if(intval($request['payment_id']) == PaymentMethods::WALLET){ #WALLET
            return $this->serviceOrdering($cart, $userWallets, PaymentMethods::WALLET, $request);
        }
        elseif(intval($request['payment_id']) == PaymentMethods::VISA){   #VISA
            $UrwayResponse = UrwayServices::generatePaymentUrl($cart);
            $paymentId = $UrwayResponse['payid'] ?? null;
            $status = ($UrwayResponse['result'] == "UnSuccessful" || !$paymentId) ? UrwayConstants::failed : UrwayConstants::pending;

            $cart->urwayTransaction()->create([
                "user_id" => $cart->user_id,
                "urway_payment_id" => $paymentId,
                "customer_ip" => request()->ip(),
                "response" => json_encode((array)$UrwayResponse),
                "visa_amount" => $cart->visa_amount,
                "wallet_amount" => $cart->wallet_amount,
                "status" => $status,
            ]);

            if ($status == UrwayConstants::pending && $UrwayResponse['targetUrl']) {
                return ['success' => true, 'status' => 200, 'message' => __("cart.api.payment_order_generated"), 'data' => ['link' => $UrwayResponse['targetUrl'] . '?paymentid=' . $paymentId]];
            } else {
                return ['success' => false, 'status' => 500, 'message' => __("cart.api.gateway-error"), 'data' => []];
            }

        }
        elseif(intval($request['payment_id']) == PaymentMethods::TABBY){ #TABBY
            $response = (new Tabby)->checkout($cart);
            $paymentId = (isset( $response['payId'])) ?  $response['payId'] : null;
            $status = (isset($response['status'], $response['url'])  && $response['status'] != "error")  ? UrwayConstants::pending : UrwayConstants::failed;

            // TabbyTransaction
            $cart->tabbyTransaction()->create([
                "user_id" => $cart->user_id,
                "tabby_payment_id" => $paymentId,
                "customer_ip" => request()->ip(),
                "response" => json_encode((array)$response),
                "visa_amount" => $cart->visa_amount,
                "wallet_amount" => $cart->wallet_amount,
                "status" => $status,
                "payUuid" => $response['payUuid'] ?? null
            ]);


            if ($status == UrwayConstants::pending && isset($response['url'])) {
                return ['success' => true, 'status' => 200, 'message' => __("cart.api.payment_order_generated"), 'data' => ['link' => $response['url']]];
            } else {
                return ['success' => false, 'status' => 500, 'message' => __("cart.api.gateway-error"), 'data' => []];
            }

        }
    }

    #ordering main function
    public function ordering($cart, $userWallets, $payment_id, $request , $PayTransaction = null){
        DB::beginTransaction();

        try {
            #createTransaction
            $transaction = $this->createTransaction($cart, $userWallets, $payment_id);

            $cart->vendors->each(function ($vendor) use ($transaction,$userWallets,$cart) {
                #create createOrder
                $order = $this->createOrder($vendor, $transaction, $userWallets, $cart);
                #create createOrderShipping
                $orderShipping = $this->createOrderShipping($vendor->id , $order , $cart);

                //attach products order
                $cartProducts = CartProduct::with('product')->where('cart_id', $cart->id)->where('vendor_id',$vendor->id)->get();
                $num_products =0;
                foreach ($cartProducts as $key => $cartProduct) {
                    OrderProduct::updateOrCreate([
                        'order_id' => $order->id,
                        'product_id' => $cartProduct->product->id,
                        ],
                        [
                            'total' => ($cartProduct->product->price * $cartProduct->quantity),
                            'quantity' => $cartProduct->quantity,
                            'unit_price' => $cartProduct->product->price,
                            'vat_percentage' => $order->vat_percentage,
                        ]);
                    $num_products += $cartProduct->quantity;
                }

                $order->update(['num_products' => $num_products]);
            });

            #After create all orders, update transaction wallet_amount & visa_amount
            $transaction->update([
                'wallet_amount' => $transaction->orders()->sum('wallet_amount') ,
                'paidWithCard' =>  $transaction->orders()->sum('visa_amount') ,
            ]);

            #pay from eportal
            $walletsOrdersAmountToPay = $transaction->orders()->select(['wallet_id', 'wallet_amount','code'])->where('wallet_amount','>=',1)->get();
            if(count($walletsOrdersAmountToPay) > 0){
                $response = Connection::transactionPay($walletsOrdersAmountToPay, $cart->client);
                if (!$response->successful()) {
                    \Log::notice($response);
                    //try again
                    $response = Connection::transactionPay($walletsOrdersAmountToPay, $cart->client);
                    if (!$response->successful()){
                        DB::rollBack();
                        return  ['success'=>false,'message'=> __("cart.api.wallet_payment_failed") ];
                    }
                }
            }

            $OnlinePayment = in_array($payment_id,[PaymentMethods::VISA,PaymentMethods::TABBY]);
            $isTabby = ($payment_id == PaymentMethods::TABBY);
            if($OnlinePayment){
                if($PayTransaction)  $PayTransaction->update(['transaction_id'=>$transaction->id]);
                OnlinePayment::query()->create([
                    'customer_id'    => $transaction->customer_id,
                    'amount'         => ($isTabby) ?  $transaction->total : $request->amount,
                    'currency'       => 'SAR',
                    'payment_method' =>($isTabby) ? 'Tabby' : ($request->cardBrand ?? 'UrWay') ,
                    'payment_id'     => ($isTabby) ?  $request->payment_id : $request->PaymentId,
                    'transaction_id' => $transaction->id,
                ]);
            }

            #never commit without transactionPay is successful done
            DB::commit();

            #delete cart
            $cart->cartVendorShippings()->delete();
            $cart->cartProducts()->delete();
            $cart->delete();


            #products stock decrement
            StockDecrement::decrementByTransaction($transaction);

            #event Created
            event(new TransactionEvents\Created($transaction));


            #sms to client
            ClientMessageService::transactionCreatedMessage(ClientMessageEnum::CreatedTransaction , $transaction);

            #vendors sms
            foreach ($transaction->orders as $key => $order) {
                $msg = "مرحبا!
                لديك طلب جديد في منصة مزارع . رقم الطلب
                $order->code";

                dispatch(new SendSmsJob($msg, $order->vendor->user->phone))->delay(1)->onQueue("customer-sms");
            }

            #end ordering (redirect || return true)
            if($OnlinePayment){
                return redirect()->away(env('PAYMENT_SUCESS_URL')  . 'checkout/success');
            }

            return  ['success'=>true, 'status'=> 200, 'message'=>__('cart.api.checkout_succesfully')];

        } catch (\Throwable $th) {
            DB::rollback();
            \Log::error("error in cart: #".$cart->id);
            report($th);
            return  ['success'=>false,'message'=>__('cart.api.cart_wrong')];
        }
    }

    public function serviceOrdering($cart,$userWallets,$payment_id,$request,$PayTransaction = null)
    {
        DB::beginTransaction();

        try {
            #createTransaction
            $transaction = $this->createServiceTransaction($cart, $userWallets, $payment_id);
            $cart->vendors->each(function ($vendor) use ($transaction,$userWallets,$cart) {
                #create createOrder
                $order = $this->createOrderService($vendor, $transaction, $userWallets, $cart);
                #create order service fields
                foreach($cart->cartProducts as $item)
                {
                    $data = CartProductServiceField::where('cart_product_id',$item['id'])->get();
                    foreach($data as $items)
                    {
                        OrderServiceFields::create([
                            'key' => $items['key'],
                            'value' => $items['value'],
                            'type' => $items['type'],
                            'price' => $items['price'],
                            'service_id' =>$item['service_id'],
                            'transaction_id' => $transaction->id
                        ]);
                    }
                }
                #create createOrderShipping
                // $orderShipping = $this->createOrderShipping($vendor->id , $order , $cart);

                //attach products order
                $cartProducts = CartProduct::with('service')->where('cart_id', $cart->id)->where('vendor_id',$vendor->id)->get();
                // dd($cartProducts);
                $num_products =0;
                foreach ($cartProducts as $key => $cartProduct) {
                    OrderServiceDetail::updateOrCreate([
                        'order_service_id' => $order->id,
                        'service_id' => $cartProduct->service_id,
                        // 'product_id' => $cartProduct->product->id,
                        ],
                        [
                            'total' => $cartProduct->total_price,
                            'quantity' => $cartProduct->quantity,
                            'unit_price' => ($cartProduct->total_price / $cartProduct->quantity),
                            'vat_percentage' => $order->vat_percentage,
                        ]);
                    $num_products += $cartProduct->quantity;
                }

                $order->update(['num_services' => $num_products,'service_id' => $cartProduct->service_id]);
            });

            #After create all orders, update transaction wallet_amount & visa_amount
            $transaction->update([
                'wallet_amount' => $transaction->orderServices()->sum('wallet_amount') ,
                'paidWithCard' =>  $transaction->orderServices()->sum('visa_amount') ,
            ]);

            #pay from eportal
            $walletsOrdersAmountToPay = $transaction->orderServices()->select(['wallet_id', 'wallet_amount','code'])->where('wallet_amount','>=',1)->get();
            if(count($walletsOrdersAmountToPay) > 0){
                $response = Connection::transactionPay($walletsOrdersAmountToPay, $cart->client);
                if (!$response->successful()) {
                    \Log::notice($response);
                    //try again
                    $response = Connection::transactionPay($walletsOrdersAmountToPay, $cart->client);
                    if (!$response->successful()){
                        DB::rollBack();
                        return  ['success'=>false,'message'=> __("cart.api.wallet_payment_failed") ];
                    }
                }
            }

            $OnlinePayment = in_array($payment_id,[PaymentMethods::VISA,PaymentMethods::TABBY]);
            $isTabby = ($payment_id == PaymentMethods::TABBY);
            if($OnlinePayment){
                if($PayTransaction)  $PayTransaction->update(['transaction_id'=>$transaction->id]);
                OnlinePayment::query()->create([
                    'customer_id'    => $transaction->customer_id,
                    'amount'         => ($isTabby) ?  $transaction->total : $request->amount,
                    'currency'       => 'SAR',
                    'payment_method' =>($isTabby) ? 'Tabby' : ($request->cardBrand ?? 'UrWay') ,
                    'payment_id'     => ($isTabby) ?  $request->payment_id : $request->PaymentId,
                    'transaction_id' => $transaction->id,
                ]);
            }

            #never commit without transactionPay is successful done
            DB::commit();

            #delete cart
            // $cart->cartVendorShippings()->delete();
            $cart->cartProducts()->delete();
            $cart->delete();


            #products stock decrement
            StockDecrement::decrementByTransaction($transaction);

            #event Created
            event(new TransactionEvents\Created($transaction));


            #sms to client
            ClientMessageService::transactionCreatedMessage(ClientMessageEnum::CreatedTransaction , $transaction);

            #vendors sms
            foreach ($transaction->orderServices as $key => $order) {
                $msg = "مرحبا!
                لديك طلب جديد في منصة مزارع . رقم الطلب
                $order->code";

                dispatch(new SendSmsJob($msg, $order->vendor->user->phone))->delay(1)->onQueue("customer-sms");
            }

            #end ordering (redirect || return true)
            if($OnlinePayment){
                return redirect()->away(env('PAYMENT_SUCESS_URL')  . 'checkout/success');
            }

            return  ['success'=>true, 'status'=> 200, 'message'=>__('cart.api.checkout_succesfully')];

        } catch (\Throwable $th) {
            DB::rollback();
            report($th);
            return  ['success'=>false,'message'=>__('cart.api.cart_wrong')];
        }
    }

    private function createTransaction($cart, $userWallets, $payment_id){
        $total_products = $cart->cartProducts->sum(fn($item) => $item->quantity * ($item->product?->price_without_vat_in_halala ?? 0));
        $vat_percentage =  getParam('vat');
        $percentage =  ($vat_percentage / 100) + 1;
        $vatRate = round($total_products - ($total_products / $percentage),2);
        $cartTotalWithoutVat = $total_products -  $vatRate;
        $cartTotalQuantity = $cart->cartProducts->sum(fn($cartProduct) => $cartProduct->quantity);
        $total_shipping_fees = $cart->cartVendorShippings()->sum('total_shipping_fees');
        $total = $cartTotalWithoutVat + $vatRate + $total_shipping_fees;
        return Transaction::create([
            'cart_id' => $cart->id,
            'customer_id' => $cart->user_id,
            'customer_name' => $cart->client->name,
            'date' => now() ,
            'status' => OrderStatus::REGISTERD,
            'sub_total' => $cartTotalWithoutVat  ,
            'total' => $total,
            'total_vat' => $vatRate ,
            'total_tax' => 0,
            'vat_percentage' => $vat_percentage,
            'delivery_fees' => $total_shipping_fees,
            'city_id' => $cart->city_id,
            'payment_method' => $payment_id,
            'products_count' => $cartTotalQuantity,
            'code' => transactionCode(),
            'address_id' => null,
            'is_international' =>  false,
            'currency_id ' => 1,
            'discount' => 0,
            'coupon_id' => null,
            'base_delivery_fees' => $cart->cartVendorShippings()->sum('base_shipping_fees'),
            'extra_weight_fees' =>$cart->cartVendorShippings()->sum('extra_shipping_fees'),
            'cod_collect_fees' => null,
            'packaging_fees' => null,
        ]);
    }
    private function createServiceTransaction($cart, $userWallets, $payment_id){
        $total_services = $cart->cartProducts->where('service_id','!=',null)->sum(fn($item) => $item->total_price);
        $vat_percentage =  getParam('vat');
        $percentage =  ($vat_percentage / 100) + 1;
        $vatRate = round($total_services - ($total_services / $percentage));
        $cartTotalWithoutVat = $total_services -  $vatRate;
        $cartTotalQuantity = $cart->cartProducts->sum(fn($cartProduct) => $cartProduct->quantity);
        // $total_shipping_fees = $cart->cartVendorShippings()->sum('total_shipping_fees');
        $total = $cartTotalWithoutVat + $vatRate;
        return Transaction::create([
            'cart_id' => $cart->id,
            'customer_id' => $cart->user_id,
            'customer_name' => $cart->client?->name,
            'date' => now() ,
            'status' => ServiceOrderStatus::REGISTERD,
            'sub_total' => ($cartTotalWithoutVat),
            'total' => ($total),
            'total_vat' => ($vatRate) ,
            'total_tax' => 0,
            'vat_percentage' => $vat_percentage,
            'delivery_fees' => 0,
            'city_id' => $cart->city_id ?? null,
            'payment_method' => $payment_id,
            'products_count' => $cartTotalQuantity,
            'code' => transactionCode(),
            'address_id' => null,
            'is_international' =>  false,
            'currency_id ' => 1,
            'discount' => 0,
            'coupon_id' => null,
            'cod_collect_fees' => null,
            'packaging_fees' => null,
            'type' => 'order-service',
            'service_address' => $cart->service_address
        ]);
    }
    private function createOrderService(Vendor $vendor, Transaction $transaction, $userWallets, $cart){
        $orderExit = OrderService::where('transaction_id',$transaction->id)->where('vendor_id',$vendor->id)->first();
        if($orderExit) return $orderExit;
        $data = [];
        $wallet_amount = 0;
        $visa_amount = 0;
        $wallet_id = null;
        $available_balance = [];
        $total_service_price = $cart->cartProducts()->where('vendor_id' ,$vendor->id )->sum('total_price');
        #get CartVendorMethodPay wallet_id amount
        $methodPay = CartVendorMethodPay::where([
            'cart_id' => $cart->id,
            'vendor_id'=>$vendor->id
        ])->latest()->first();

        if (!$methodPay) throw new PlaceOrderBusinessException(__("cart.api.checkout.order_not_created"));

        //payment with wallet
        if($methodPay->wallet_id){
            $wallet = collect($userWallets)->where('wallet_id' , $methodPay->wallet_id)->first() ?? [];
            if(!$wallet){
                throw new PlaceOrderBusinessException(__("cart.api.checkout.wallet_not_found"));
            }

            if(!array_key_exists($methodPay->wallet_id, $available_balance)) {
                $available_balance[$methodPay->wallet_id] = $wallet['balance'] ?? 0;
            }

            if($methodPay->amount > $available_balance[$methodPay->wallet_id]){
                throw new PlaceOrderBusinessException(__("cart.api.checkout.wallet_enough_and_select_another_payment"));
            }else{
                $wallet_amount = $methodPay->amount ;
                $wallet_id = $methodPay->wallet_id;
                $visa_amount =  $methodPay->visa_amount;
                $available_balance[$methodPay->wallet_id] -= $methodPay->amount ;
            }

        }
        else{ // other payment method (not wallet)
            $wallet_amount = 0;
            $visa_amount = $total_service_price;
        }

        // $shipping = $cart->cartVendorShippings()->where('vendor_id',$vendor->id)->first();
        $vendorTotals = $cart->getVendorTotalService($vendor->id);
        $vendorCommission = $vendor->commission ?? 10;
        $companyProfit = $vendorTotals['single_service_total'] * $vendorCommission / 100;
        $orderTotal = $vendorTotals['single_service_total'] ?? 0;

        $vendorTotals['company_percentage'] = $vendorCommission;
        $vendorTotals['company_profit'] = $companyProfit;
        $vendorTotals['vendor_amount'] = $orderTotal - $companyProfit;
        $percentage = ($transaction->vat_percentage / 100) + 1;
        $orderVat = round($vendorTotals['single_service_total'] - ($vendorTotals['single_service_total'] / $percentage),2);
        if($wallet_amount < 1){
            $visa_amount += $wallet_amount;
            $wallet_amount = 0;
        }
        $order =  OrderService::create([
            'transaction_id' => $transaction->id,
            'vendor_id' => $vendor->id,
            'order_date' => Carbon::now(),
            'customer_name' => $transaction->client->name,
            'status' => ServiceOrderStatus::REGISTERD,
            'vat' => $orderVat,
            'sub_total' => $vendorTotals['single_service_total'] - $orderVat,
            'total' => $vendorTotals['single_service_total'],
            'tax' => 0,
            'vat_percentage' => $transaction->vat_percentage,
            'company_percentage' => $vendorTotals['company_percentage'],
            'company_profit' => $vendorTotals['company_profit'],
            'vendor_amount' => $vendorTotals['vendor_amount'],
            'code' => orderServiceCode(),
            'wallet_id' => $wallet_id,
            'use_wallet' => ($wallet_amount > 0) ,
            'visa_amount' => $visa_amount,
            'wallet_amount' => $wallet_amount,
            'payment_id' => $transaction->payment_method,
            'service_address' => $transaction->service_address
        ]);
        if (!$order) throw new PlaceOrderBusinessException(__("cart.api.checkout.order_not_created"));
        return $order;
    }
    private function createOrder(Vendor $vendor, Transaction $transaction, $userWallets, $cart)
    {
        $orderExit = Order::where('transaction_id',$transaction->id)->where('vendor_id',$vendor->id)->first();
        if($orderExit) return $orderExit;

        $data = [];
        $wallet_amount = 0;
        $visa_amount = 0;
        $wallet_id = null;
        $available_balance = [];
         foreach( $cart->cartVendorShippings as $cartVendorShipping){
            if($cartVendorShipping->vendor_id == $vendor->id){
                $total_product_price = $cart->cartProducts()->where('vendor_id' ,$cartVendorShipping->vendor_id )->sum('total_price');
                $total_shipping_fees = $cart->cartVendorShippings()->where('vendor_id' ,$cartVendorShipping->vendor_id )->first()?->total_shipping_fees ?? 0;
                $total_price_and_shipping = $total_product_price + $total_shipping_fees;

                #get CartVendorMethodPay wallet_id amount
                $methodPay = CartVendorMethodPay::where([
                    'cart_id' => $cart->id,
                    'vendor_id'=>$cartVendorShipping->vendor_id
                ])->latest()->first();

                if (!$methodPay) throw new PlaceOrderBusinessException(__("cart.api.checkout.order_not_created"));

                //payment with wallet
                if($methodPay->wallet_id){
                    $wallet = collect($userWallets)->where('wallet_id' , $methodPay->wallet_id)->first() ?? [];
                    if(!$wallet){
                        throw new PlaceOrderBusinessException(__("cart.api.checkout.wallet_not_found"));
                    }

                    if(!array_key_exists($methodPay->wallet_id, $available_balance)) {
                        $available_balance[$methodPay->wallet_id] = $wallet['balance'] ?? 0;
                    }

                    if($methodPay->amount > $available_balance[$methodPay->wallet_id]){
                        throw new PlaceOrderBusinessException(__("cart.api.checkout.wallet_enough_and_select_another_payment"));
                    }else{
                        $wallet_amount = $methodPay->amount ;
                        $wallet_id = $methodPay->wallet_id;
                        $visa_amount =  $methodPay->visa_amount;
                        $available_balance[$methodPay->wallet_id] -= $methodPay->amount ;
                    }

                }
                else{ // other payment method (not wallet)
                    $wallet_amount = 0;
                    $visa_amount = $total_price_and_shipping;
                }
            }
        }

        $shipping = $cart->cartVendorShippings()->where('vendor_id',$vendor->id)->first();
        $vendorTotals = $cart->getVendorTotalsInHalala($vendor->id);

        $vendorCommission = $vendor->commission ?? 10;
        $companyProfit = $vendorTotals['products_total'] * $vendorCommission / 100;
        $orderTotal = $vendorTotals['products_total'] ?? 0;

        $vendorTotals['company_percentage'] = $vendorCommission;
        $vendorTotals['company_profit'] = $companyProfit;
        $vendorTotals['vendor_amount'] = $orderTotal - $companyProfit;
        $percentage = ($transaction->vat_percentage / 100) + 1;
        $orderVat = round($vendorTotals['products_total'] - ($vendorTotals['products_total'] / $percentage),2);


        if($wallet_amount < 1){
            $visa_amount += $wallet_amount;
            $wallet_amount = 0;
        }

        $order =  Order::create([
            'transaction_id' => $transaction->id,
            'vendor_id' => $vendor->id,
            'date' => Carbon::now(),
            'customer_name' => $transaction->client->name,
            'status' => OrderStatus::REGISTERD,
            'delivery_type' => $shipping?->shippingMethod?->name,
            'vat' => $orderVat,
            'sub_total' => $vendorTotals['products_total'] - $orderVat,
            'total' => $vendorTotals['products_total'],
            'tax' => 0,
            'vat_percentage' => $transaction->vat_percentage,
            'delivery_fees' => $vendorTotals['delivery_fees'],
            'discount' => $vendorTotals['discount'],
            'company_percentage' => $vendorTotals['company_percentage'],
            'company_profit' => $vendorTotals['company_profit'],
            'vendor_amount' => $vendorTotals['vendor_amount'],
            'total_weight' => $shipping?->total_weight,
            'code' => orderCode(),
            'wallet_id' => $wallet_id,
            'use_wallet' => ($wallet_amount > 0) ,
            'visa_amount' => $visa_amount,
            'wallet_amount' => $wallet_amount,
            'payment_id' => $transaction->payment_method,
        ]);


        if (!$order) throw new PlaceOrderBusinessException(__("cart.api.checkout.order_not_created"));

        return $order;
    }

    private function createOrderShipping(int $vendor_id , Order $order, $cart){

        $cartVendorShipping = $cart->cartVendorShippings()->where('vendor_id' , $vendor_id)->first()?->toArray();

        #check OrderVendorShipping is exit
        $OrderVendorShipping = OrderVendorShipping::where('order_id',$order->id)->where('vendor_id',$vendor_id)->first();
        if($OrderVendorShipping) return $OrderVendorShipping;

        $shipping_method_id = $cartVendorShipping['shipping_type_id'] == 1 ? null : $cartVendorShipping['shipping_method_id'];

        $orderShipping = $order->orderVendorShippings()->create([
            'city_id' =>  $cartVendorShipping['city_id'] ,
            'to_city_id'  => $cart->city_id,
            'city_name'  => $cartVendorShipping['city_name'] ,
            'to_city_name' => $cart->city?->name,
            'shipping_type_id'  => $cartVendorShipping['shipping_type_id'] ,
            'van_type' => $cartVendorShipping['van_type'] ,
            'total_shipping_fees'  => $cartVendorShipping['total_shipping_fees'] ,
            'total_weight'  => $cartVendorShipping['total_weight'] ,
            'vendor_id' => $vendor_id ,
            'no_of_products'  => $cartVendorShipping['no_of_products'] ,
            'user_id'  => $cart->user_id ,
            'transaction_id' => $order->transaction_id,
            'status' => $order->status,
            'shipping_method_id'  => $shipping_method_id,
            'base_shipping_fees'  => $cartVendorShipping['base_shipping_fees'] ,
            'extra_shipping_fees' => $cartVendorShipping['extra_shipping_fees'] ,
            'warehouse_id' => $cartVendorShipping['delivery_warehouse_id'] ,
        ]);


        #create OrderVendorShippingWarehouse for every product
        foreach ($cart->cartProducts()->where('vendor_id',$vendor_id)->get() as $key => $cartProduct) {
            $warehouse_id = $cartProduct->warehouse_id;
            if($cartVendorShipping['shipping_type_id'] == 2){
                $warehouse_id = $cartVendorShipping['delivery_warehouse_id'];
            }

            $wareHouseCity = WarehouseCity::where('warehouse_id' , $warehouse_id)->first();

            OrderVendorShippingWarehouse::create([
                'order_id' => $order->id,
                'order_ven_shipping_id' => $orderShipping->id,
                'vendor_id' =>$vendor_id,
                'product_id' =>$cartProduct->product_id,
                'warehouse_id' => $warehouse_id,
                'shipping_type_id' =>$cartVendorShipping['shipping_type_id'],
                'shipping_method_id' => $shipping_method_id,
                'warehouse_city_id' =>  $wareHouseCity->city_id ?? null,
                'transaction_id' => $order->transaction_id
            ]);
        }

        return $orderShipping;

    }

    #Payment callback urway and tabby
    public function paymentCallback(Request $request)
    {
        //VISA urway
        if ($request->has('TrackId')) {
            $cart = Cart::find($request->TrackId);
            if(!$cart)   return redirect()->away(env('PAYMENT_SUCESS_URL') . '?payment=fail');
            $UrwayTransaction = UrwayTransaction::where('cart_id' , $cart->id)->where('user_id',$cart->user_id)->where('transaction_id',null)->where('status',UrwayConstants::pending)->where('urway_payment_id' , $request->PaymentId)->first();
            if(!$UrwayTransaction){
                return redirect()->away(env('PAYMENT_SUCESS_URL') . '?payment=fail');
            }

            #save callback informations
            $UrwayTransaction->update(['reqCallback' =>$request->getContent(), 'amountCallback' => $request->amount ?? 0, 'statusCallback' => $request->Result ?? 'empty']);

            #check request->Result is Successful
            if(!isset($request->Result) || $request->Result != "Successful"){
                $UrwayTransaction->update(['status' => UrwayConstants::failed]);
                return redirect()->away(env('PAYMENT_SUCESS_URL') . '?payment=fail');
            }

            #Check the amount paid
            if((double)$UrwayTransaction->visa_amount > (double)$request->amount){
                $UrwayTransaction->update(['status' => UrwayConstants::failed]);
                return redirect()->away(env('PAYMENT_SUCESS_URL') . '?payment=fail');
            }

            #update status  completed
            $UrwayTransaction->update(['status' => UrwayConstants::completed]);

            #get userWallets balance
            $userWallets=  [];
            if($UrwayTransaction->wallet_amount > 0){
                $response = Connection::userAuthWallet(request(), $cart->client);;
                if ($response->successful()) {
                    $userWallets = collect($response->json()['data'] ?? []);
                }
                else{
                    \Log::notice($response);
                }
            }
            #ordering after validations
            return $UrwayTransaction->transaction?->type == 'order' ? $this->ordering($cart, $userWallets, PaymentMethods::VISA, $request, $UrwayTransaction): $this->serviceOrdering($cart, $userWallets, PaymentMethods::VISA, $request, $UrwayTransaction);
        }
        // TABBY
        elseif($request->has('payment_id')){
            $TabbyTransaction = TabbyTransaction::where('transaction_id',null)->where('status',UrwayConstants::pending)->where('payUuid',$request->cart_id)->first();
            if(!$TabbyTransaction) return redirect()->away(env('PAYMENT_SUCESS_URL') . '?payment=fail');


            $cart = Cart::where('user_id',$TabbyTransaction->user_id)->find($TabbyTransaction->cart_id);
            if(!$cart)  return redirect()->away(env('PAYMENT_SUCESS_URL') . '?payment=fail&ds=CartNotFound');

            #save callback informations
            $TabbyTransaction->update(['reqCallback' =>$request->getContent(), "tabby_payment_id"=>$request->payment_id ,'amountCallback' => 0, 'statusCallback' => $request->status ?? 'empty']);

            #check request->Result is Successful
            if($request->status != "success"){
                $TabbyTransaction->update(['status' => UrwayConstants::failed]);
                return redirect()->away(env('PAYMENT_SUCESS_URL') . '?payment=fail');
            }

            #update status  completed
            $TabbyTransaction->update(['status' => UrwayConstants::completed]);

            #get userWallets balance
            $userWallets=  [];
            if($TabbyTransaction->wallet_amount > 0){
                $response = Connection::userAuthWallet(request(), $cart->client);;
                if ($response->successful()) {
                    $userWallets = collect($response->json()['data'] ?? []);
                }else{
                    \Log::notice($response);
                }
            }

            #ordering after validations
            return $TabbyTransaction->transaction?->type == 'order' ? $this->ordering($cart, $userWallets, PaymentMethods::TABBY, $request, $TabbyTransaction) : $this->serviceOrdering($cart, $userWallets, PaymentMethods::TABBY, $request, $TabbyTransaction);
        }

    }


}
