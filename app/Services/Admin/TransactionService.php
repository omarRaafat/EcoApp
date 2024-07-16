<?php

namespace App\Services\Admin;

use App\Enums\VendorWallet as VendorWalletEnum;
use App\Models\Order;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\OrderProduct;
use App\Services\LogService;
use App\Models\TransactionLog;
use App\Services\Api\Calculation;
use App\Enums\WalletTransactionTypes;
use App\Models\VendorWalletTransaction;

class TransactionService
{
    private $_vat;

    /**
     * @param LogService $logger
     */
    public function __construct(private LogService $logger) {
        $this->_vat = Setting::where('key','vat')->first()->value ?? 0;
    }

    /**
     * Get Transaction using ID.
     *
     * @param integer $id
     * @return Transaction
     */
    public function getTransactionUsingID(int $id) : Transaction|null
    {
        return Transaction::findOrFail($id);
    }

    public function update(Transaction $transaction)
    {
        // disabled according to Mohamed Abdallah hint (when doing refund it will be reactivated)
        return;
        $vatPercentage = $transaction->vat_percentage ?? $this->_vat;

        $transaction_request = [];
        $transaction_request['status'] = request('status');
        $transaction_request['note'] = request('note');

        if(request('deletedOrders')) {
            Order::whereIn('id',(array)request('deletedOrders'))->delete();
        }
        
        if(request('deletedProducts')) {
            OrderProduct::whereIn('id',(array)request('deletedProducts'))->delete();
        }
        
        if(request('quantity')) {
            $total_orders = [];

            foreach (request('quantity') AS $id => $quantity) {
                $orderProduct = OrderProduct::findOrfail($id);
                $orderProduct->quantity = $quantity;
                $orderProduct->total = ($quantity * $orderProduct->unit_price);
                $orderProduct->vat_percentage = $vatPercentage;
                $orderProduct->save();
                
                if (isset($total_orders[$orderProduct->order_id])) {
                    $total_orders[$orderProduct->order_id]->push($orderProduct->total);
                } else {
                    $total_orders[$orderProduct->order_id] = collect([$orderProduct->total]);
                }
            }

            $transactionTotal = 0;

            foreach ($total_orders AS $order_id => $orderTotals) {
                $orderTotal = $orderTotals->sum();
                $transactionTotal += $orderTotal;

                // TODO: must be refactored the way of calculation to make sure all system use single calculation method
                $orderCalculations = Calculation::calculate($orderTotal, $vatPercentage)->asArray();
                
                $order = Order::findOrFail($order_id);
                $companyProfit = $order->company_percentage * ($orderCalculations['sub_total'] ?? 0) * 0.01;
                $vendorAmount = $orderCalculations['sub_total'] - $companyProfit;

                $order->update([
                    'vat'                => $orderCalculations['vat_rate'],
                    'sub_total'          => $orderCalculations['sub_total'],
                    'tax'                => 0,
                    'total'              => $orderCalculations['total'],
                    'vat_percentage'     => $orderCalculations['vat_percentage'],
                    'delivery_fees'      => $orderCalculations['delivery_fees'],
                    'discount'           => $orderCalculations['discount'],
                    'company_profit'     => $companyProfit,
                    'vendor_amount'      => $vendorAmount,
                    'status'             => $transaction_request['status']
                ]);
            }

            // TODO: must be refactored the way of calculation to make sure all system use single calculation method
            $transactionCalculations = Calculation::calculate($transactionTotal, $vatPercentage)->asArray();

            $transaction_request['sub_total']      = $transactionCalculations['sub_total'];
            $transaction_request['total']          = $transactionCalculations['total'];
            $transaction_request['total_vat']      = $transactionCalculations['total_vat'];
            $transaction_request['total_tax']      = 0;
            $transaction_request['vat_percentage'] = $transactionCalculations['vat_percentage'];
            $transaction_request['delivery_fees']  = $transactionCalculations['delivery_fees'];
            $transaction_request['discount']       = $transactionCalculations['discount'];
        }

        $old_transaction = $transaction->replicate();
        $transaction->update($transaction_request);
        
        $this->logger->InLog([
            'user_id' => auth()->user()->id,
            'action' => "updateTransaction",
            'model_type' => "\App\Models\Transaction",
            'model_id' => $transaction->id,
            'object_before' => $old_transaction,
            'object_after' => $transaction
        ]);
        
        TransactionLog::create([
            'old_status' => $old_transaction->status,
            'new_status' => $transaction->status,
            'user_id' => auth()->user()->id,
            'transaction_id' => $transaction->id
        ]);
        
        return $transaction;
    }
}
