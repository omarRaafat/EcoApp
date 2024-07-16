<?php
namespace App\Services\Wallet;

use App\Enums\VendorWallet as VendorWalletEnum;
use App\Models\Order;
use App\Models\Vendor;
use App\Models\VendorWallet;
use Exception;
use Illuminate\Support\Facades\DB;

class VendorWalletService {
    /**
     * @param Vendor vendor
     * @param Order $order
     * @throws Exception
     * @return bool
     */
    public static function withdrawByOrder(
        Vendor $vendor,
        Order $order
    ) : bool {
        try {
            DB::beginTransaction();
            $wallet = $vendor->wallet;
            if (!$wallet) $wallet = VendorWallet::create(['vendor_id' => $vendor->id, 'balance' => 0]);
            if (
                !$wallet->transactions
                    ->where('reference', get_class($order))
                    ->where('reference_id', $order->id)
                    ->where('operation_type', VendorWalletEnum::OUT)
                    ->first() &&
                $wallet->transactions
                    ->where('reference', get_class($order))
                    ->where('reference_id', $order->id)
                    ->where('operation_type', VendorWalletEnum::IN)
                    ->first()
            ) {
                $wallet->transactions()->create([
                    'amount' => $order->vendor_amount,
                    'operation_type' => VendorWalletEnum::OUT,
                    'reference' => get_class($order),
                    'reference_id' => $order->id,
                ]);

                $wallet->decrement("balance", $order->vendor_amount);
            }

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
        return false;
    }

    
    /**
     * @param Vendor vendor
     * @param Order $order
     * @throws Exception
     * @return bool
     */
    public static function depositByOrder(
        Vendor $vendor,
        Order $order
    ) : bool {
        try {
            DB::beginTransaction();
            $wallet = $vendor->wallet;
            if (!$wallet) $wallet = VendorWallet::create(['vendor_id' => $vendor->id, 'balance' => 0]);

            if (
                !$wallet->transactions
                    ->where('reference', get_class($order))
                    ->where('reference_id', $order->id)
                    ->where('operation_type', VendorWalletEnum::IN)
                    ->first()
            ) {
                $wallet->transactions()->create([
                    'amount' => $order->vendor_amount,
                    'operation_type' => VendorWalletEnum::IN,
                    'reference' => get_class($order),
                    'reference_id' => $order->id,
                ]);

                $wallet->increment("balance", $order->vendor_amount);
            }

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
        return false;
    }
}