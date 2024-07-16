<?php

namespace App\Observers;

use App\Models\OrderVendorShipping;
use App\Models\OrderStatusLog;

class OrderVendorShippingObserver
{
    /**
     * Handle the OrderVendorShipping "created" event.
     *
     * @param  \App\Models\OrderVendorShipping  $orderVendorShipping
     * @return void
     */
    public function created(OrderVendorShipping $orderVendorShipping)
    {
        OrderStatusLog::create([
            'order_id' => $orderVendorShipping->order_id,
            'order_vendor_shipping_id' => $orderVendorShipping->id,
            'status' => $orderVendorShipping->status == 'canceled' ? 'registered' : $orderVendorShipping->status ,
            'created_by' => auth()->check() ? auth()->user()->id : null,
        ]);
        return $orderVendorShipping;
    }

    /**
     * Handle the OrderVendorShipping "updated" event.
     *
     * @param  \App\Models\OrderVendorShipping  $orderVendorShipping
     * @return void
     */
    public function updated(OrderVendorShipping $orderVendorShipping)
    {
        if($orderVendorShipping->isDirty('status')){
            OrderStatusLog::create([
                'order_id' => $orderVendorShipping->order_id,
                'order_vendor_shipping_id' => $orderVendorShipping->id,
                'status' => $orderVendorShipping->status,
                'created_by' => auth()->check() ? auth()->user()->id : null,
            ]);
        }
    }

    /**
     * Handle the OrderVendorShipping "deleted" event.
     *
     * @param  \App\Models\OrderVendorShipping  $orderVendorShipping
     * @return void
     */
    public function deleted(OrderVendorShipping $orderVendorShipping)
    {
        //
    }

    /**
     * Handle the OrderVendorShipping "restored" event.
     *
     * @param  \App\Models\OrderVendorShipping  $orderVendorShipping
     * @return void
     */
    public function restored(OrderVendorShipping $orderVendorShipping)
    {
        //
    }

    /**
     * Handle the OrderVendorShipping "force deleted" event.
     *
     * @param  \App\Models\OrderVendorShipping  $orderVendorShipping
     * @return void
     */
    public function forceDeleted(OrderVendorShipping $orderVendorShipping)
    {
        //
    }
}
