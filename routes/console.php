<?php

use App\Models\OrderShip;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('beez:check-stock', function () {
    OrderShip::whereHas('transaction', fn($q) => $q->whereIn('status', ['paid']))->each(function (OrderShip $order_ship) {
        $this->info("start: $order_ship->gateway_tracking_id");

        $contains = Str::contains(
            Http::get("https://beezdash.com/Track/index?tr=$order_ship->gateway_tracking_id")->body(),
            'Out of stock'
        );

        $order_ship->update([
            'is_out_of_stock' => $contains
        ]);

        if($contains) {
            $this->info("============================");
            $this->info("$order_ship->gateway_tracking_id is out of stock");
            $this->info("============================");
        }

        $this->info("finish: $order_ship->gateway_tracking_id");
    }, 10);
})->purpose('check beez status for out of stock');
