<?php

namespace App\Observers;
use App\Enums\ServiceOrderStatus;
use App\Models\MostDemandingCustomers;
use App\Models\OrderService;
use App\Models\OrderServiceStatusLog;
use App\Models\VendorWalletTransaction;

class OrderServiceObserver
{
    public function creating(OrderService $order) : OrderService
    {
        do {
            $code = rand(100000000000, 999999999999);
        } while (OrderService::where("invoice_number", $code)->exists());
        $order->invoice_number = $code;
        return $order;
    }

    public function created(OrderService $order) : OrderService
    {
        OrderServiceStatusLog::create([
            'order_service_id' => $order->id,
            'status' => $order->status ,
            'created_by' => auth()->check() ? auth()->user()->id : null,
        ]);

        return $order;
    }
    public function updated(OrderService $order) : OrderService
    {

        if($order->status == ServiceOrderStatus::COMPLETED){
            MostDemandingCustomers::create(['customer_id' => $order->transaction?->customer_id]);


            $checkWallet =VendorWalletTransaction::where('reference',OrderService::class)->where('reference_id' , $order->id)->first();
            // UPDATE DELIVERED_AT WHEN ORDER COMPLETED
            //  $order->delivered_at = now();
            if(!$checkWallet){
                VendorWalletTransaction::depositService($order , null);
            }
        }

        $checkCompleted = $order->transaction->orderServices()->where('status' , '!=',ServiceOrderStatus::COMPLETED)->count();
        if($checkCompleted == 0){
            $order->transaction->update(['status' =>  ServiceOrderStatus::COMPLETED]);
        }
        $checkCancelled = $order->transaction->orderServices()->where('status' , '!=',ServiceOrderStatus::CANCELED)->count();
        if($checkCancelled == 0){
            $order->transaction->update(['status' =>  ServiceOrderStatus::CANCELED]);
        }
        $checkCompleted = $order->transaction->orderServices()->whereIn('status',[ServiceOrderStatus::CANCELED,ServiceOrderStatus::COMPLETED])->count();
        if($checkCompleted == $order->transaction->orderServices()->count()){
            $order->transaction->update(['status' =>  ServiceOrderStatus::COMPLETED]);
        }


        if($order->isDirty('status')){
            OrderServiceStatusLog::create([
                'order_service_id' => $order->id,
                'status' => $order->status,
                'created_by' => auth()->check() ? auth()->user()->id : null,
            ]);
        }

        return $order;
    }
}
