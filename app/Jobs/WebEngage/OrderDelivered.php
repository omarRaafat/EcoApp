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

class OrderDelivered implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Transaction $transaction;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction->load(['orders.products']);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        (new WebEngage)->orderDelivered($this->transaction);
    }
}
