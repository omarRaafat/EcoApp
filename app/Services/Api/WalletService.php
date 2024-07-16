<?php

namespace App\Services\Api;

use App\Http\Resources\Api\WalletTransactionResource; 
use App\Enums\WalletHistoryTypeStatus;
use App\Models\User;

class WalletService
{
    public function totalAmount(User $customer) {
        $wallet = $customer->ownWallet()->active()->first();
        if($wallet) {
            return  [
                'success' => true,
                'status' => 200,
                'data' => ['amount' => $wallet->amount_with_sar ?? 0],
                'message' => __('wallet.api.retrieved')
            ];
        }
        return $this->_returnWalletNotFound();
    }

    public function getTotalWithdraw(User $customer) {
        $wallet = $customer->ownWallet()->active()->first();
        if($wallet) {
            $totalWithdraw = $wallet->transactions()->where('type',WalletHistoryTypeStatus::SUB)->sum('amount') / 100;
            return  [
                'success' => true,
                'status' => 200,
                'data' => ['total' => $totalWithdraw] ,
                'message' => __('wallet.api.retrieved')
            ];
        }
        return $this->_returnWalletNotFound();
    }

    public function getAllTransactions(User $customer) {
        $wallet = $customer->ownWallet()->active()->first();
        if($wallet) {
            $transactions = $wallet->transactions()->orderBy('id', 'desc')->get();
            return  [
                'success' => true,
                'status' => 200 ,
                'data' => WalletTransactionResource::collection($transactions),
                'message' => __('wallet.api.retrieved')
            ];
        }
        return $this->_returnWalletNotFound();
    }

    public function getWalletData(User $customer) {
        $wallet = $customer->ownWallet()->active()->first();
        if($wallet) {
            $totalWithdraw = $wallet->transactions()->where('type', WalletHistoryTypeStatus::SUB)->sum('amount') / 100;
            return  [
                'success' => true,
                'status' => 200,
                'data' => [
                    'total' => number_format($wallet->amount_with_sar ,2),  
                    'withdraw' => number_format($totalWithdraw ,2) ,
                    'transactions' => WalletTransactionResource::collection($wallet->transactions()->orderBy('id', 'desc')->get())
                ],
                'message' => __('wallet.api.retrieved')
            ];
        }
        return $this->_returnWalletNotFound();
    }

    private function _returnWalletNotFound(){
        return [
            'success' => true,
            'status' => 200,
            'data' => ['total' => 0, 'withdraw' => 0, 'transactions' => []],
            'message' => __('wallet.api.not_found')
        ];
    }
}
