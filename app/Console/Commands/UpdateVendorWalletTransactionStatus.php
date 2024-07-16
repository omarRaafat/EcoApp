<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\VendorWalletTransaction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\VendorWallet;

class UpdateVendorWalletTransactionStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vendorWallet:updateTransactionStatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Vendor Wallet Transactions Status After 3 days From Order Delivered From Pending Status To Completed';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::beginTransaction();


        $walletIds = [];

        try {
            $transactions = VendorWalletTransaction::where('status', 'pending')
            ->where('operation_type', 'in')
            ->where('created_at', '<', now()->subDays(3))
            ->where(function ($query) {
                $query->whereHas('order', fn($query) => $query->where('status', 'completed'))
                    ->orWhereHas('orderService', fn($query) => $query->where('status', 'completed'));
            })->get();

            foreach($transactions as $walletTransaction){
                $walletTransaction->update([
                    'status' => 'completed'
                ]);

                $walletIds[] = $walletTransaction->wallet_id;

                /*$wallet = $transacwalletTransactiontion->wallet;
                $wallet->balance += $walletTransaction->amount;
                $wallet->save();*/
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating Vendor Wallet transactions: ' . $e->getMessage());
            $this->error('Error updating Vendor Wallet transactions. Check the logs for details.');
        }

        $this->updateWalletsbalance($walletIds);

    }

    private function updateWalletsbalance($walletIds){
        foreach (array_unique($walletIds) as $key => $wallet_id) {
            $sumIn = VendorWalletTransaction::where('wallet_id',$wallet_id)->where('status','completed')->where('operation_type','in')->sum('amount');
            $sumOut = VendorWalletTransaction::where('wallet_id',$wallet_id)->where('operation_type','out')->sum('amount');

            VendorWallet::where('id',$wallet_id)->update([
                'balance' => $sumIn - $sumOut
            ]);
        }
    }
}
