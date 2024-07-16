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
use App\Models\BestSellingService;
use App\Models\BestSellingVendors;
use App\Models\BestSellingCategory;
use App\Models\ServiceWarehouseStock;
use App\Services\ClientMessageService;
use App\Enums\ClientMessageEnum;
use App\Enums\OrderStatus;
use App\Enums\ServiceOrderStatus;
use App\Integrations\Shipping\Integrations\Aramex\Aramex;

class ServiceOrderRepository extends BaseRepository
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
                $wallet_amount = (float)$order->wallet_amount;

                $res = UpdateWalletBalanceEportal::refundWallet($order->wallet_id, $wallet_amount , $order->code, 'تم الغاء الطلب ', $order->transaction->customer_id);

                if(isset($res['code']) && $res['code'] == 422){
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

            #CANCELED
            $order->status = ServiceOrderStatus::CANCELED;
            $order->note = request()->reason ?: 'إلغاء من الإدارة';
            $order->save();

            #set warnings
            if($warnings) session()->flash('warning',$warnings);

            #commit
            DB::commit();

            ClientMessageService::CanceledTransaction(ClientMessageEnum::CanceledTransaction, $order->transaction->customer, $order->code);

            #updateSalesAndStocks
            // $this->updateSales($order);
            #vendorSms
            $this->vendorSms($order, "إلغاء");


            return  ['success'=>true];
        } catch (\Throwable $th) {
            DB::rollback();
            report($th);
            return  ['success'=>false,'message'=> $th->getMessage()];
        }


    }

    // todo all this code to events listeners
    // public function updateSales($order){
    //     foreach ($order->orderServices as $service) {
    //         $bestSellingService = BestSellingService::where('service_id', $service->id)->where('vendor_id', $service->order->vendor_id)->first();
    //         if ($bestSellingService) {
    //             $bestSellingService->update(['service_sales' => $bestSellingService->service_sales - $service->quantity]);
    //         }

    //         $vednorSales = BestSellingVendors::where('vendor_id', $service->order->vendor_id)->first();
    //         if ($vednorSales) {
    //             $vednorSales->update(['vendors_sales' => $vednorSales->vendors_sales - $service->quantity]);
    //         }


    //         $categorySales = BestSellingCategory::where('category_id', $service->service->category_id)->first();
    //         if ($categorySales) {
    //             $categorySales->update(['category_sales' => $categorySales->category_sales - $service->quantity]);
    //         }

    //     }

    // }

    //todo vendor sms
    public function vendorSms($order, $word){
        $msg = "عزيزي التاجر!

        نود إعلامك بأنه تم ".$word." طلب .
        رقم الطلب $order->code

        فريق منصة مُزارع. ";

        dispatch(new SendSmsJob($msg, $order->vendor->user->phone))->delay(1)->onQueue("customer-sms");
    }




}
