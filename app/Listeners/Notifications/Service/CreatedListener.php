<?php

namespace App\Listeners\Notifications\Service;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\Admin\Service;
use App\Models\User;
use App\Notifications\SendPushNotification;
use Error;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class CreatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct() {}

    /**
     * Handle the event.
     * @param Service\Created $event
     * @return void
     */
    public function handle(Service\Created $event) {
        $service = $event->getService();

        $title = __('notifications.admin.service.created.title', [], "ar");
        try {
            $message = __('notifications.admin.service.created.message', [
                'vendor' => $service->vendor->getTranslation("name", "ar")
            ], "ar");
        } catch (Exception $e) {
            $message = __('notifications.admin.service.created.message', ['vendor' => "غير معلوم"], "ar");
        }
        try {
            $url = route("admin.services.show", ['service' => $service->id]);
            $users = User::adminUser()->adminGroupPermitted("services")->get();
            $notification = new SendPushNotification($title, $message, $url, $users->pluck('fcm_token')->toArray());
            Notification::send($users, $notification);
        } catch (Exception | Error $e) {
            Log::channel("notifications-events-errors")->error("Exception in WalletListener: ". $e->getMessage());
        }
    }
}
