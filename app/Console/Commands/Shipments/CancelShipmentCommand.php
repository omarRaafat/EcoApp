<?php

namespace App\Console\Commands\Shipments;

use App\Integrations\Shipping\Integrations\Bezz\Bezz;
use App\Models\Transaction;
use Illuminate\Console\Command;

class CancelShipmentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shipment:cancel {order_no}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel shipment based on order number';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        dump(
            (new Bezz)->cancelShipment(Transaction::firstWhere('code', $this->argument('order_no')))
        );
    }
}