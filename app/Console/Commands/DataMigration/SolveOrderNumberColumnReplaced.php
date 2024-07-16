<?php

namespace App\Console\Commands\DataMigration;

use App\Models\Order;
use Illuminate\Console\Command;

class SolveOrderNumberColumnReplaced extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:solve-column-replaced';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command to solve the column replaced values (vat has the sub_total and the sub_total has the vat) values';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Order::query()->whereRaw("vat > sub_total")->lazy()->each(function($order) {
            echo "Working on order: {$order->id}, vat: {$order->vat}({$order->vat_percentage}%), sub_total: {$order->sub_total}, profit: {$order->company_profit}". PHP_EOL;
            $order->update([
                'vat' => $order->sub_total,
                'sub_total' => $order->vat,
                'total' => $order->vat
            ]);
        });
        return Command::SUCCESS;
    }
}
