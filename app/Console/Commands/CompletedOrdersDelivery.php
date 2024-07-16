<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Enums\OrderStatus;
use App\Enums\VendorWalletTransactionsStatusEnum;
use App\Models\VendorWalletTransaction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CompletedOrdersDelivery extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:delivered';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command will update delivered_at with date to all orders delivered and completed';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try{
            $vendorWalletTransactions = VendorWalletTransaction::whereOperationType('in')
            ->whereStatus(VendorWalletTransactionsStatusEnum::COMPLETED)
            ->select(['reference_id' , 'created_at'])
            ->chunk(50, function($vendorWalletTransactions){
                foreach ($vendorWalletTransactions as  $vendorWalletTransaction) {
                    Order::whereId($vendorWalletTransaction->reference_id)
                    ->whereStatus(OrderStatus::COMPLETED)
                    ->whereRefundStatus('no_found')
                    ->update([
                        'delivered_at' => $vendorWalletTransaction->created_at
                    ]);
                }
            });

        } catch (\Exception $e) {
             $this->error('Failed to retrieve vendor wallet transactions: ' . $e->getMessage());
             return command::FAILURE;
        }
        
        
        $this->info('delivered_at column Updated for Completed Orders successfully.');
        return command::SUCCESS;
    }
}
