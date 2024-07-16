<?php
namespace App\Services\Product;

use App\Models\OrderVendorShippingWarehouse;
use App\Models\ProductWarehouseStock;
use App\Models\Transaction;
use App\Models\TransactionWarning;
use Illuminate\Support\Facades\DB;

class StockDecrement {
    public static function byTransaction(
        Transaction $transaction
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
        ->each(function ($order) use ($warehouse ,&$errors) {
            $order
            ->orderProducts
            ->each(function ($orderProduct) use ($warehouse ,&$errors) {
                if ($warehouse) {
                    $productWarehouseSstock = $orderProduct->product->warehouseStock()->warehouseId($warehouse->id)->first();
                    if ($productWarehouseSstock && $productWarehouseSstock->stock >= $orderProduct->quantity) {
                        $productWarehouseSstock->decrement("stock", $orderProduct->quantity);
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
                'title' => __("admin.stock-decrement-errors"),
                'message' => $errors->implode(","),
                'transaction_id' => $transaction->id,
                'reference_type' => 'StockDecrement',
            ]);
        }
    }


    public static function decrementByTransaction(Transaction $transaction)
    {
       foreach($transaction->orderProducts as $orderDetail)
       {
           $orderDetail->product->decrement('stock', $orderDetail->quantity);

           try{
               $warehouse = OrderVendorShippingWarehouse::where(['order_id' => $orderDetail->order_id,'product_id' => $orderDetail->product_id])->first();
               if($warehouse){
                   $productWarehouseStock = ProductWarehouseStock::where(['product_id' => $orderDetail->product_id,'warehouse_id' => $warehouse->warehouse_id])->first();
                   if($productWarehouseStock){
                       $productWarehouseStock->decrement('stock', $orderDetail->quantity);
                   }
               }
           } catch (\Throwable $th) {
               report($th);
           }
       }
    }
}
