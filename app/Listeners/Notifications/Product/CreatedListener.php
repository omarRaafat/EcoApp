<?php

namespace App\Listeners\Notifications\Product;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\Admin\Product;
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
     * @param Product\Created $event
     * @return void
     */
    public function handle(Product\Created $event) {
        $product = $event->getProduct();

        $title = __('notifications.admin.product.created.title', [], "ar");
        try {
            $message = __('notifications.admin.product.created.message', [
                'vendor' => $product->vendor->getTranslation("name", "ar")
            ], "ar");
        } catch (Exception $e) {
            $message = __('notifications.admin.product.created.message', ['vendor' => "غير معلوم"], "ar");
        }
        try {
            $url = route("admin.products.show", ['product' => $product->id]);
            $users = User::adminUser()->adminGroupPermitted("products")->get();
            $notification = new SendPushNotification($title, $message, $url, $users->pluck('fcm_token')->toArray());
            Notification::send($users, $notification);
        } catch (Exception | Error $e) {
            Log::channel("notifications-events-errors")->error("Exception in WalletListener: ". $e->getMessage());
        }
    }
}
