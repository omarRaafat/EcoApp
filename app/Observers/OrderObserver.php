<?php

namespace App\Observers;

use App\Enums\ClientMessageEnum;
use App\Enums\OrderStatus;
use App\Exceptions\Transactions\PlaceOrderBusinessException;
use App\Models\BestSellingCategory;
use App\Models\BestSellingProduct;
use App\Models\BestSellingVendors;
use App\Models\MostDemandingCustomers;
use App\Models\Order;
use App\Models\ProductWarehouseStock;
use App\Models\Vendor;
use App\Models\VendorWalletTransaction;
use App\Services\Alinma;
use App\Services\ClientMessageService;
use App\Services\Eportal\Connection;
use App\Services\Wallet\UpdateWalletBalanceEportal;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\OrderStatusLog;
use Carbon\Carbon;
use App\Jobs\SendSmsJob;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     *
     * @param Order $order
     * @return Order
     */
    public function creating(Order $order) : Order
    {
        do {
            $code = rand(100000000000, 999999999999);
        } while (Order::where("invoice_number", $code)->exists());
        $order->invoice_number = $code;
        return $order;
    }

    public function created(Order $order) : Order
    {
        OrderStatusLog::create([
            'order_id' => $order->id,
            'status' => $order->status ,
            'created_by' => auth()->check() ? auth()->user()->id : null,
        ]);

        return $order;
    }

    public function updated(Order $order) : Order
    {

        if($order->status == OrderStatus::COMPLETED){
            foreach($order->orderProducts as $product ){
                if($product->product){
                    $product->product->update(['no_sells' => $product->quantity + $product->product->no_sells]);    

                    if($order->orderShipping->shipping_type_id == 1){
                        $product->product->update(['no_receive_from_vendor' => $product->quantity + $product->product->no_receive_from_vendor]);
                    }
                }
                $bestSellingProduct = BestSellingProduct::where('product_id' , $product->id)->where('vendor_id' , $product->order->vendor_id)->first();
                if($bestSellingProduct){
                    $bestSellingProduct->update(['product_sales' => $bestSellingProduct->product_sales + $product->quantity]);
                }else{
                    BestSellingProduct::create(['product_sales' => (int)$product->quantity , 'vendor_id' => $product->order->vendor_id , 'product_id' => $product->product_id]);
                }

                $vednorSales= BestSellingVendors::where('vendor_id' , $product->order->vendor_id)->first();
                if($vednorSales){
                    $vednorSales->update(['vendors_sales' => $vednorSales->vendors_sales + $product->quantity]);
                }else{
                    BestSellingVendors::create(['vendors_sales' =>  $product->quantity , 'vendor_id' => $product->order->vendor_id]);
                }

                $categorySales= BestSellingCategory::where('category_id' , $product->product->category_id)->first();
                if($categorySales){
                    $categorySales->update(['category_sales' => $categorySales->category_sales + $product->quantity]);
                }else{
                    BestSellingCategory::create(['category_sales' =>  $product->quantity , 'category_id' => $product->product->category_id]);
                }

            }
            MostDemandingCustomers::create(['customer_id' => $order->transaction->customer_id]);


            $checkWallet =VendorWalletTransaction::where('reference',Order::class)->where('reference_id' , $order->id)->first();
            // UPDATE DELIVERED_AT WHEN ORDER COMPLETED
             $order->delivered_at = now();
            if(!$checkWallet){
                VendorWalletTransaction::deposit($order , null);
            }
        }

        $checkCompleted = $order->transaction->orders()->where('status' , '!=',OrderStatus::COMPLETED)->count();
        if($checkCompleted == 0){
            $order->transaction->update(['status' =>  OrderStatus::COMPLETED]);
        }
        $checkCancelled = $order->transaction->orders()->where('status' , '!=',OrderStatus::CANCELED)->count();
        if($checkCancelled == 0){
            $order->transaction->update(['status' =>  OrderStatus::CANCELED]);
        }
        $checkCompleted = $order->transaction->orders()->whereIn('status',[OrderStatus::CANCELED,OrderStatus::COMPLETED])->count();
        if($checkCompleted == $order->transaction->orders()->count()){
            $order->transaction->update(['status' =>  OrderStatus::COMPLETED]);
        }


        if($order->isDirty('status')){
            OrderStatusLog::create([
                'order_id' => $order->id,
                'status' => $order->status,
                'created_by' => auth()->check() ? auth()->user()->id : null,
            ]);
        }

        return $order;
    }
}
