<?php

namespace App\Jobs\WebEngage;

use App\Integrations\Statistics\WebEngage;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OrderCreated implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Transaction $transaction;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Transaction $transaction) {
        $this->transaction = $transaction->load([
            "addresses" => fn($a) => $a->with("country", "area", "city"),
            'coupon',
            'orders' => fn($o) => $o->with([
                'products' => fn($p) => $p->with(['finalSubCategory', 'subCategory', 'category'])
            ])
        ]);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        (new WebEngage)->shippingDetailsUpdated($this->transaction);
        (new WebEngage)->checkoutCompleted($this->transaction);
    }
}
