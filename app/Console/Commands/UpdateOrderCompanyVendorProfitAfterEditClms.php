<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\VendorWalletTransaction;
use App\Models\VendorWallet;
use App\Enums\OrderStatus;

class UpdateOrderCompanyVendorProfitAfterEditClms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    # 2024/02/29
    protected $signature = 'command:UpdateOrderCompanyVendorProfitAfterEditClms';

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
        $walletIds = [];
        Order::whereIn('status',[OrderStatus::COMPLETED,OrderStatus::PAID,OrderStatus::REGISTERD,OrderStatus::PICKEDUP,OrderStatus::PROCESSING,OrderStatus::IN_SHIPPING])
            ->chunk(50, function($orders) use (&$walletIds){
            foreach ($orders as $key => $order) {
                $vendorCommission = $order->company_percentage ?? 10;
                $companyProfit = $order->total * $vendorCommission / 100;
            
                Order::withoutEvents(function () use ($order, $companyProfit) {
                    $order->update([
                        'company_profit'     => $companyProfit,
                        'vendor_amount'      => $order->total - $companyProfit,
                    ]);
                });

                $transaction = VendorWalletTransaction::where('reference_id',$order->id)->first(); 
                if($transaction){
                    $transaction->update([
                        'amount' => $order->total - $companyProfit,
                    ]);

                    $walletIds[] = $transaction->wallet_id;                
                }
                
            }
        });

        
        foreach (array_unique($walletIds) as $key => $wallet_id) {
            $sumIn = VendorWalletTransaction::where('wallet_id',$wallet_id)->where('operation_type','in')->sum('amount'); 
            $sumOut = VendorWalletTransaction::where('wallet_id',$wallet_id)->where('operation_type','out')->sum('amount'); 

            VendorWallet::where('id',$wallet_id)->update([
                'balance' => $sumIn - $sumOut
            ]);
        }
       

    }
}
