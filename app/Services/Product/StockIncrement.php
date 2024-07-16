<?php
namespace App\Services\Product;

use App\Enums\OrderStatus;
use App\Models\Transaction;
use App\Models\TransactionWarning;

class StockIncrement {
    public static function byTransaction(
        Transaction $transaction
    ) {
        if (
            $transaction->status == OrderStatus::CANCELED &&
            !$transaction->transactionStatusLogs()->where('new_status', OrderStatus::CANCELED)->exists()
        ) {
            $errors = collect([]);
            $warehouse = $transaction?->addresses?->country?->warehouse()?->first();
            if (!$warehouse) {
                $errors->push(__("admin.stock-country-missed", [
                    'country' => $transaction?->addresses?->country?->getTranslation("name", "ar"),
                    'transaction' => $transaction->code
                ]));
            }

            $transaction
            ->orders
            ->each(function ($order) use ($warehouse, &$errors) {
                $order
                ->orderProducts
                ->each(function ($orderProduct) use ($warehouse, &$errors) {
                    if ($warehouse) {
                        $productWarehouseSstock = $orderProduct->product->warehouseStock()->warehouseId($warehouse->id)->first();
                        if ($productWarehouseSstock) {
                            $productWarehouseSstock->increment("stock", $orderProduct->quantity);
                        } else $errors->push(__("admin.stock-warehouse-missed", [
                            'product' => "{$orderProduct->product->getTranslation("name", "ar")} - {$orderProduct->product->id}",
                            'warehouse' => "{$warehouse->getTranslation("name", "ar")} - {$warehouse->id}",
                        ]));
                    }
                    $orderProduct->product->update(["stock" => $orderProduct->product->warehouseStock()->sum("stock")]);
                });
            });

            if ($errors->isNotEmpty()) {
                TransactionWarning::create([
                    'title' => __("admin.stock-increment-errors"),
                    'message' => $errors->implode(","),
                    'transaction_id' => $transaction->id,
                    'reference_type' => 'StockDecrement',
                ]);
            }
        } elseif (
            $transaction->status == OrderStatus::REFUND &&
            !$transaction->transactionStatusLogs()->where('new_status', OrderStatus::REFUND)->exists()
        ) {
            $errors = collect([]);
            $warehouse = $transaction?->addresses?->country?->warehouse()?->first();
            if (!$warehouse) {
                $errors->push(__("admin.stock-country-missed", [
                    'country' => $transaction?->addresses?->country?->getTranslation("name", "ar"),
                    'transaction' => $transaction->code
                ]));
            }

            $transaction
            ->orders
            ->each(function ($order) use ($warehouse, &$errors) {
                $order
                ->orderProducts
                ->each(function ($orderProduct) use ($warehouse, &$errors) {
                    if ($warehouse) {
                        $productWarehouseSstock = $orderProduct->product->warehouseStock()->warehouseId($warehouse->id)->first();
                        if ($productWarehouseSstock) {
                            $productWarehouseSstock->increment("stock", $orderProduct->quantity);
                        } else $errors->push(__("admin.stock-warehouse-missed", [
                            'product' => "{$orderProduct->product->getTranslation("name", "ar")} - {$orderProduct->product->id}",
                            'warehouse' => "{$warehouse->getTranslation("name", "ar")} - {$warehouse->id}",
                        ]));
                    }
                    $orderProduct->product->update(["stock" => $orderProduct->product->warehouseStock()->sum("stock")]);
                });
            });

            if ($errors->isNotEmpty()) {
                TransactionWarning::create([
                    'title' => __("admin.stock-increment-errors"),
                    'message' => $errors->implode(","),
                    'transaction_id' => $transaction->id,
                    'reference_type' => 'StockDecrement',
                ]);
            }
        }
    }
}
