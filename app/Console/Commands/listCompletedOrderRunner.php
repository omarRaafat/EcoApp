<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Enums\OrderStatus;
use App\Models\OrderNote;
use Illuminate\Console\Command;

class listCompletedOrderRunner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:completed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'list orders completed';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        OrderNote::query()->whereStatus('waiting')->update([
            'status' => 'commited'
        ]);
        return Command::SUCCESS;
    }
}
