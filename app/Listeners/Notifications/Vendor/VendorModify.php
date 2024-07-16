<?php

namespace App\Listeners\Notifications\Vendor;

use App\Events\Admin\Vendor\Modify;
use App\Models\User;
use App\Notifications\SendPushNotification;
use Error;
use Exception;
use Illuminate\Support\Facades\Log;

class VendorModify
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
     * @param  \App\Events\Admin\Vednor\Modify  $event
     * @return void
     */
    public function handle(Modify $event)
    {
        try {
            $title = __('notifications.vendor.modify.title', [], "ar");
            $message = __('notifications.vendor.modify.message', [], "ar");
            $url = url('/vendor/edit-profile');
            $user = User::where('id',$event->vendor->user_id)->first();
            $user->notify(new SendPushNotification($title,$message,$url,[$user->fcm_token]));
        } catch (Exception | Error $e) {
            Log::channel("notifications-events-errors")->error("Exception in WalletListener: ". $e->getMessage());
        }
    }
}
