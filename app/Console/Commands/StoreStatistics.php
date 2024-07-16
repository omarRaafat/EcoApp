<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Enums\UserTypes;
use App\Enums\OrderStatus;
use App\Models\CountryOrder;
use App\Models\StatisitcsCount;
use Illuminate\Console\Command;
use App\Models\TransactionByType;
use App\Models\BestSellingProduct;
use App\Models\BestSellingVendors;
use Illuminate\Support\Facades\DB;
use App\Models\BestSellingCategory;
use App\Models\MostDemandingCustomers;

class StoreStatistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statistics:store';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command must run every 24 houres to store the statistics.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->_bestProducts();
        $this->_bestVendors();
        $this->_bestUsers();
        $this->_bestCountries();
        $this->_bestCategories();
        $this->_transactionsByType();
        $this->_statisticsCounts();
        return Command::SUCCESS;
    }

    private function _bestProducts() :void
    {
        $products = DB::table("products")
            ->select([
                "products.id as product_id",
                "products.vendor_id as vendor_id",
                DB::raw('COUNT(transactions.id) as product_sales')
            ])
            ->join("order_products", "order_products.product_id", "=", "products.id")
            ->join("orders", "orders.id",  "=", "order_products.order_id")
            ->join("transactions", "transactions.id",  "=", "orders.transaction_id")
            ->groupBy("products.id", "vendor_id")
            ->orderByRaw("product_sales desc, product_id asc")
            ->get()
            ->map(function ($product) {
                return [
                    "product_id" => $product->product_id,
                    "vendor_id" => $product->vendor_id,
                    "product_sales" => $product->product_sales,
                    "created_at" => now(),
                    "updated_at" => now(),
                ];
            })
            ->toArray();

        BestSellingProduct::truncate();
        BestSellingProduct::insert($products);
    }

    private function _bestVendors()
    {
        $vendors = DB::table("vendors")
            ->select([
                "vendors.id as vendor_id",
                DB::raw('COUNT(transactions.id) as vendor_sales')
            ])
            ->join("orders", "orders.vendor_id",  "=", "vendors.id")
            ->join("transactions", "transactions.id",  "=", "orders.transaction_id")
            ->groupBy("vendors.id")
            ->orderByRaw("vendor_sales desc, vendor_id asc")
            ->limit(5)
            ->get()
            ->map(function ($vendor) {
                return [
                    "vendor_id" => $vendor->vendor_id,
                    "vendors_sales" => $vendor->vendor_sales,
                    "created_at" => now(),
                    "updated_at" => now(),
                ];
            })
            ->toArray();

        BestSellingVendors::truncate();
        BestSellingVendors::insert($vendors);
    }

    private function _bestUsers()
    {
        $customers = User::withCount("transactions")
            ->where("type", UserTypes::CUSTOMER)
            ->orderBy("transactions_count", "desc")
            ->limit(5)
            ->get()
            ->map(function ($customer) {
                return [
                    "customer_id" => $customer->id,
                    "created_at" => now(),
                    "updated_at" => now(),
                ];
            })
            ->toArray();

        MostDemandingCustomers::truncate();
        MostDemandingCustomers::insert($customers);
    }

    private function _bestCountries()
    {
        $countries = DB::table("orders")
            ->select([
                "vendors.id as vendor_id",
                "countries.id as country_id",
                DB::raw('COUNT(orders.id) as country_sales')
            ])
            ->join("vendors", "vendors.id", "=", "orders.vendor_id")
            ->join("transactions", "transactions.id",  "=", "orders.transaction_id")
            ->join("addresses", "transactions.address_id",  "=", "addresses.id")
            ->join("countries", "addresses.country_id", "=", "countries.id")
            ->groupBy("countries.id", "vendors.id")
            ->orderByRaw("country_sales desc, country_id asc")
            ->limit(5)
            ->get()
            ->map(function ($country) {
                return [
                    "vendor_id" => $country->vendor_id,
                    "country_id" => $country->country_id,
                    "country_sales" => $country->country_sales,
                    "created_at" => now(),
                    "updated_at" => now(),
                ];
            })
            ->toArray();

        CountryOrder::truncate();
        CountryOrder::insert($countries);
    }

    private function _bestCategories()
    {
        $categories = DB::table("categories")
            ->select([
                "categories.id as category_id",
                DB::raw('COUNT(transactions.id) as category_sales')
            ])
            ->join("products", "products.category_id", "=", "categories.id")
            ->join("order_products", "order_products.product_id", "=", "products.id")
            ->join("orders", "orders.id",  "=", "order_products.order_id")
            ->join("transactions", "transactions.id",  "=", "orders.transaction_id")
            ->groupBy("categories.id")
            ->orderByRaw("category_sales desc, category_id asc")
            ->limit(5)
            ->get()
            ->map(function ($category) {
                return [
                    "category_id" => $category->category_id,
                    "category_sales" => $category->category_sales,
                    "created_at" => now(),
                    "updated_at" => now(),
                ];
            })
            ->toArray();

        BestSellingCategory::truncate();
        BestSellingCategory::insert($categories);
    }

    private function _transactionsByType()
    {
        $transactions = DB::table("transactions")
            ->select([
                "transactions.id as transaction_id",
                "transactions.status",
                DB::raw('COUNT(transactions.status) as byStatus')
            ])
            ->groupBy("transactions.status", "transaction_id")
            ->orderByRaw("byStatus desc")
            ->get()
            ->map(function ($transaction) {
                return [
                    "transaction_id" => $transaction->transaction_id,
                    "status" => $transaction->status,
                    "count" => $transaction->byStatus,
                    "created_at" => now(),
                    "updated_at" => now(),
                ];
            })
            ->toArray();

        TransactionByType::truncate();
        TransactionByType::insert($transactions);
    }

    private function _statisticsCounts()
    {
        $counts = DB::table("orders")
            ->whereIn("status", [
                OrderStatus::COMPLETED,
                OrderStatus::IN_DELEVERY
            ])
            ->select([
                "orders.vendor_id as vendor_id",
                DB::raw('COUNT(orders.id) as orders_count'),
                DB::raw('SUM(orders.vendor_amount) as orders_vendor_amount'),
                DB::raw('SUM(orders.company_profit) as orders_company_profit')
            ])
            ->groupBy("orders.vendor_id")
            ->get()
            ->map(function ($count) {
                return [
                    "vendor_id" => $count->vendor_id,
                    "orders" => $count->orders_count,
                    "sales" => $count->orders_vendor_amount,
                    "profits" => $count->orders_company_profit,
                    "created_at" => now(),
                    "updated_at" => now(),
                ];
            })
            ->toArray();

        StatisitcsCount::truncate();
        StatisitcsCount::insert($counts);
    }
}
