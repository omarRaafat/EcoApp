<?php

namespace App\Repositories\Api;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Repositories\Api\BaseRepository;
use Illuminate\Support\Facades\DB;
use App\Services\Wallet\UpdateWalletBalanceEportal;
use App\Enums\PaymentMethods;
use App\Enums\ShippingMethods;
use App\Services\Payments\Urway\UrwayServices;
use App\Jobs\SendSmsJob;
use App\Models\BestSellingProduct;
use App\Models\BestSellingVendors;
use App\Models\BestSellingCategory;
use App\Models\ProductWarehouseStock;
use App\Services\ClientMessageService;
use App\Enums\ClientMessageEnum;
use App\Enums\OrderStatus;
use App\Integrations\Shipping\Integrations\Aramex\Aramex;

class OrderRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return Order::class;
    }

    public function cancel($order){
        DB::beginTransaction();

        try {
            $warnings = "";

            #refund wallet_amount
            if ($order->wallet_amount > 0) {
                $wallet_amout = (float)$order->wallet_amount;
                if($order->cancelType?->type == "withoutShipping"){
                    $wallet_amout -=  (float)$order->delivery_fees;
                }

                $res = UpdateWalletBalanceEportal::refundWallet($order->wallet_id, $wallet_amout , $order->code, 'تم الغاء الطلب ', $order->transaction->customer_id);
                if($res['code'] == 422){
                    DB::commit();
                    return  ['success'=>false,'message'=> $res['message']];
                }
            } 
            
            #refund visa_amount
            if($order->visa_amount > 0 && $order->refund_status != 'completed'){
                $order->refund_status = 'pending';

                if($order->transaction->payment_method == PaymentMethods::VISA){

                    $UrwayResponse = UrwayServices::transactionRefund($order);
                    if($UrwayResponse){
                        $order->refund_status = 'completed';
                    }else{
                        $warnings .=   'تم إلغاء الطلب بنجاح، ولكن لم يُرَجَّع المبلغ للمزرع (يور واي)';
                    }
        
                }
            }

            #cancel Shipment
            if($order->orderShipping){
                $order->orderShipping->update(['status' => OrderStatus::CANCELED]);
                if($order->orderShipping->shipping_type_id == 2){ // توصيل
                    if($order->orderShipping->shipping_method_id == 1){  // ARAMEX
                        $aramex_response= app(Aramex::class)->cancelShipment($order);
                        if(!isset($aramex_response['status']) || !$aramex_response['status']  ){
                            $warnings .=  'تم الغاء الطب بنجاح ولكن لم يتم الغائها من قبل اراميكس ' . $aramex_response['message'] ?? '';
                        }
                    }
                }
            }

            #CANCELED
            $order->status = OrderStatus::CANCELED;
            $order->note = request()->reason ?: 'إلغاء من الإدارة';            
            $order->save();

            #set warnings
            if($warnings) session()->flash('warning',$warnings);

            #commit
            DB::commit();

            ClientMessageService::CanceledTransaction(ClientMessageEnum::CanceledTransaction, $order->transaction->customer, $order->code);

            #updateSalesAndStocks
            $this->updateSalesAndStocks($order);
            #vendorSms
            $this->vendorSms($order, "إلغاء");

            
            return  ['success'=>true];
        } catch (\Throwable $th) {
            DB::rollback();
            report($th);
            return  ['success'=>false,'message'=> $th->getMessage()];
        }   

        
    }

    public function refund($order){
        DB::beginTransaction();

        try {
            $warnings = "";

            #refund wallet_amount
            if ($order->wallet_amount > 0) {
                $wallet_amout = (float)$order->wallet_amount;
                if($order->cancelType?->type == "withoutShipping"){
                    $wallet_amout -=  (float)$order->delivery_fees;
                }

                $res = UpdateWalletBalanceEportal::refundWallet($order->wallet_id, $wallet_amout , $order->code, 'تم الغاء الطلب ', $order->transaction->customer_id);
                if($res['code'] == 422){
                    DB::commit();
                    return  ['success'=>false,'message'=> $res['message']];
                }
            } 
            
            #refund visa_amount
            if($order->visa_amount > 0 && $order->refund_status != 'completed'){
                $order->refund_status = 'pending';

                if($order->transaction->payment_method == PaymentMethods::VISA){

                    $UrwayResponse = UrwayServices::transactionRefund($order);
                    if($UrwayResponse){
                        $order->refund_status = 'completed';
                    }else{
                        $warnings .=   'تم إرجاع الطلب بنجاح، ولكن لم يُرَجَّع المبلغ للمزارع (يور واي)';
                    }
        
                }
            }

            #cancel Shipment
            if($order->orderShipping){
                $order->orderShipping->update(['status' => OrderStatus::REFUND]);
                if($order->orderShipping->shipping_type_id == 2){ // توصيل
                    if($order->orderShipping->shipping_method_id == 1){  // ARAMEX
                        if(request()->withAramex == 'yes'){
                                $aramex_response= app(Aramex::class)->RefundShipment($order, $order->orderShipping, ShippingMethods::ARAMEX);
                                if(!isset($aramex_response['status']) || !$aramex_response['status']  ){
                                    $warnings .=  'تم إرجاع الطب بنجاح ولكن لم يتم الإرجاع من قبل اراميكس ' . $aramex_response['message'] ?? '';
                                }
                            }
                        
                    }
                }
            }

            #CANCELED
            $order->status = OrderStatus::REFUND;
            $order->note = request()->reason ?: 'مرجع من الإدارة';            
            $order->refund_reason = request()->refund_reason;
            $order->save();

            if (count($order->vendorWalletTransactions) > 0) {
                $order->vendorWalletTransactions()->get()->each->delete();
            }

            #set warnings
            if($warnings) session()->flash('warning',$warnings);

            #commit
            DB::commit();

            ClientMessageService::RefundTransaction(ClientMessageEnum::RefundTransaction, $order->transaction->customer, $order->code);

            #updateSalesAndStocks
            $this->updateSalesAndStocks($order);
            #vendorSms
            $this->vendorSms($order, "إرجاع");

            return  ['success'=>true];
        } catch (\Throwable $th) {
            DB::rollback();
            report($th);
            return  ['success'=>false,'message'=> $th->getMessage()];
        }   

        
    }


    // todo all this code to events listeners
    public function updateSalesAndStocks($order){  
        foreach ($order->orderProducts as $product) {
            if ($order->orderShipping->shipping_type_id == 1) {
                $product->product->update(['no_receive_from_vendor' => $product->quantity + $product->product->no_receive_from_vendor]);
            }
            $product->product->update(['no_sells' => $product->product->no_sells - $product->quantity]);
            $bestSellingProduct = BestSellingProduct::where('product_id', $product->id)->where('vendor_id', $product->order->vendor_id)->first();
            if ($bestSellingProduct) {
                $bestSellingProduct->update(['product_sales' => $bestSellingProduct->product_sales - $product->quantity]);
            }

            $vednorSales = BestSellingVendors::where('vendor_id', $product->order->vendor_id)->first();
            if ($vednorSales) {
                $vednorSales->update(['vendors_sales' => $vednorSales->vendors_sales - $product->quantity]);
            }


            $categorySales = BestSellingCategory::where('category_id', $product->product->category_id)->first();
            if ($categorySales) {
                $categorySales->update(['category_sales' => $categorySales->category_sales - $product->quantity]);
            }

        }
        foreach ($order->orderVendorShippingWarehouses as $orderVendorShipping) {
            $quantity = $order->orderProducts()->where('product_id', $orderVendorShipping->product_id)->first()->quantity;
            $warehouseStock = ProductWarehouseStock::where('product_id', $orderVendorShipping->product_id)->where('warehouse_id', $orderVendorShipping->warehouse_id)->first();
            if($warehouseStock){
                $warehouseStock->update(['stock' => $warehouseStock->stock + $quantity]);
            }
            $product = $orderVendorShipping->product;
            if($product){
                $product->update(['stock' => $product->stock + $quantity]);
            }
        }

    }

    //todo vendor sms
    public function vendorSms($order, $word){
        $msg = "عزيزي التاجر!

        نود إعلامك بأنه تم ".$word." طلب .
        رقم الطلب $order->code

        فريق منصة مُزارع. ";

        dispatch(new SendSmsJob($msg, $order->vendor->user->phone))->delay(1)->onQueue("customer-sms");
    }




}
