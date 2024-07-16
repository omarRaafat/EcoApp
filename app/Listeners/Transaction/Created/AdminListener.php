<?php

namespace App\Listeners\Transaction\Created;

use App\Events\Transaction;
use App\Models\User;
use App\Notifications\SendPushNotification;
use Error;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class AdminListener
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
     * @param  Transaction\Created  $event
     * @return void
     */
    public function handle(Transaction\Created $event)
    {
        try {
            $transaction = $event->getTransaction();
            $admins = User::with('roles.permissions')->whereIn('type',['sub-admin','admin'])->get();
            $title = __('notifications.admin.transaction.created.title', [], "ar");
            $message = __('notifications.admin.transaction.created.message', [], "ar") . ' ' . $transaction->code;
            $url = route('admin.transactions.show',$transaction->id);
            foreach ($admins As $admin)
            {
                $transaction_routes = collect([
                    'admin.transactions.index',
                    'admin.transactions.show',
                    'admin.transactions.manage',
                    'admin.transactions.update'
                ]);
                if($admin->permittedRoutes()->diff($transaction_routes)->isEmpty() || $admin->type == 'admin')
                {
                    $admin->notify(new SendPushNotification($title,$message,$url,[$admin->fcm_token]));
                }
            }
        } catch (Exception | Error $e) {
            Log::channel("transaction-events-errors")->error("Exception in AdminListener: ". $e->getMessage());
        }
    }
}
