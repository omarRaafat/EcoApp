<?php
namespace App\Services\Wallet;

use App\Enums\WalletHistoryTypeStatus;
use App\Exceptions\Wallet\NotEnoughBalance;
use App\Models\User;
use App\Models\Wallet;
use Exception;
use Illuminate\Support\Facades\DB;

class CustomerWalletService {
    /**
     * @param User $customer
     * @param float $amount
     * @param int $transactionType
     * @throws NotEnoughBalance
     * @throws Exception
     * @return bool
     */
    public static function withdraw(User $customer, float $amount, int $transactionType) : bool {
        $amountInHalala = $amount * 100;

        try {
            DB::beginTransaction();
            $wallet = Wallet::lockForUpdate()->where("customer_id", $customer->id)->first();

            if ($wallet->amount < $amount) throw new NotEnoughBalance();

            $wallet->transactions()->create([
                "customer_id" => $wallet->customer_id,
                "type" => WalletHistoryTypeStatus::SUB,
                "amount" => $amount,// amount has setter in WalletTransactionHistory model to make it in Halala
                "is_opening_balance" => false,
                "transaction_type" => $transactionType,
                "user_id" => $customer->id
            ]);

            $wallet->decrement("amount", $amountInHalala);

            DB::commit();
            return true;
        } catch (NotEnoughBalance $e) {
            DB::rollBack();
            throw $e;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
        return false;
    }

    /**
     * @param User $customer
     * @param float $amount
     * @param int $transactionType
     * @throws Exception
     * @return bool
     */
    public static function deposit(User $customer, float $amount, int $transactionType) : bool {
        $amountInHalala = $amount * 100;

        try {
            DB::beginTransaction();

            $wallet = Wallet::where("customer_id", $customer->id)->first();

            if ($amountInHalala <= 0) return false;

            $wallet->transactions()->create([
                "customer_id" => $wallet->customer_id,
                "type" => WalletHistoryTypeStatus::ADD,
                "amount" => $amount,// amount has setter in WalletTransactionHistory model to make it in Halala
                "is_opening_balance" => false,
                "transaction_type" => $transactionType,
                "user_id" => $customer->id
            ]);

            $wallet->increment("amount", $amountInHalala);

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollback();
        }
        return false;
    }
}
