<?php

namespace App\Listeners\Notifications\Vendor;

use App\Events\Admin\Service\Reject;
use App\Models\User;
use App\Models\Vendor;
use App\Notifications\SendPushNotification;
use Error;
use Exception;
use Illuminate\Support\Facades\Log;

class ServiceReject
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
     * @param  \App\Events\Admin\Service\Reject  $event
     * @return void
     */
    public function handle(Reject $event)
    {
        try {
            $title = __('notifications.vendor.service.reject.title', [], "ar") . $event->service->name;
            $message = __('notifications.vendor.service.reject.message', [], "ar");
            $url = url('/vendor/services/show/' . $event->service->id);
            $vendor = Vendor::where('id',$event->service->vendor_id)->first();
            $user = User::where('id',$vendor->user_id)->first();
            $user->notify(new SendPushNotification($title,$message,$url,[$user->fcm_token]));
        } catch (Exception | Error $e) {
            Log::channel("notifications-events-errors")->error("Exception in WalletListener: ". $e->getMessage());
        }
    }
}
