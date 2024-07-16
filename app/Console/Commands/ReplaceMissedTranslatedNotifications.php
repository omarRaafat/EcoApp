<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ReplaceMissedTranslatedNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:replace-missed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::table("notifications")->where(function ($q) {
            $q->where("data->title", "like", "admin.%");
            $q->orWhere("data->message", "like", "admin.%");
        })
        ->get()
        ->each(function($notification) {
            $data = json_decode($notification->data, true);
            $data['message'] = Str::replace(
                "admin.notifications.admin.transaction.created.message",
                __("notifications.admin.transaction.created.message", [], "ar"),
                $data['message']
            );
            $data['title'] = Str::replace(
                "admin.notifications.admin.transaction.created.title",
                __("notifications.admin.transaction.created.title", [], "ar"),
                $data['title']
            );
            $notification->update(['data' => json_encode($data)]);
        });
        return Command::SUCCESS;
    }
}
