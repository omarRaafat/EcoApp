<?php

namespace App\Console\Commands;

use App\Enums\OrderStatus;
use App\Models\Product;
use Closure;
use Illuminate\Console\Command;

class ProductSalesCalculation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:sales';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command to calculate yesterday sales for products';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Product::query()
        ->select("id", "category_id")
        ->whereHas(
            'orderProducts',
            fn($o) => $this->orderProductsConditions(
                $o, fn($transQuery) => $transQuery->createdYesterday()
            )
        )
        ->with([
            'orderProducts' => fn($o) => $this->orderProductsConditions(
                $o, fn($transQuery) => $transQuery->createdYesterday()
            ),
            'productSales'
        ])
        ->lazy(100)
        ->each(function($product) {
            $salesData = [
                "daily_product_sales" => $product->orderProducts->sum('quantity'),
                "daily_sales_day" => now()->subDay()->toDateString(),
                "category_id" => $product->category_id
            ];
            $product->productSales ? $product->productSales->update($salesData) : $product->productSales()->create($salesData);
        });

        return Command::SUCCESS;
    }

    private function orderProductsConditions($orderProductsQuery, Closure $transactionDateQuery) {
        return $orderProductsQuery->whereHas('order', function($orderQuery) use ($transactionDateQuery) {
            $orderQuery->whereHas('transaction', function ($transactionQuery) use ($transactionDateQuery) {
                $transactionQuery->where($transactionDateQuery)
                ->statuses([
                    OrderStatus::COMPLETED, OrderStatus::SHIPPING_DONE, OrderStatus::IN_DELEVERY
                ]);
            });
        });
    }
}
