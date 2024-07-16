<?php

namespace App\Listeners\Notifications\Vendor;

use App\Events\Admin\Product\Modify;
use App\Models\User;
use App\Models\Vendor;
use App\Notifications\SendPushNotification;
use Error;
use Exception;
use Illuminate\Support\Facades\Log;

class ProductModify
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\Admin\Product\Modify  $event
     * @return void
     */
    public function handle(Modify $event)
    {
        try {
            $title = __('notifications.vendor.product.modify.title', [], "ar") . $event->product->name;
            $message = __('notifications.vendor.product.modify.message', [], "ar");
            $url = url('/vendor/products/show/' . $event->product->id);
            $vendor = Vendor::where('id',$event->product->vendor_id)->first();
            $user = User::where('id',$vendor->user_id)->first();
            $user->notify(new SendPushNotification($title,$message,$url,[$user->fcm_token]));
        } catch (Exception | Error $e) {
            Log::channel("notifications-events-errors")->error("Exception in WalletListener: ". $e->getMessage());
        }
    }
}
