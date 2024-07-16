<?php

namespace App\Console\Commands\DataMigration;

use App\Enums\WarehouseIntegrationKeys;
use App\Models\Country;
use App\Models\Product;
use App\Models\ProductWarehouseStock;
use App\Models\Warehouse;
use Illuminate\Console\Command;

class SeedWarehouseIntegrationKeys extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'warehouse:seed-keys';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command (must run one time and no more after deploy feature: feature/product-stock-warehouse/#309)'.
        ' to make sure for that, in case national country in system has a warehouse will set the national key to it, '.
        'otherwise will seed national key to first warehouse';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $nationalCountry = Country::national()->first();
        if (
            $nationalCountry &&
            $nationalCountry->warehouseCountry &&
            $nationalCountry->warehouseCountry->warehouse
        ) {
            $warehouse = Warehouse::where('api_key', WarehouseIntegrationKeys::NATIONAL_WAREHOUSE)->first();
            if (!$warehouse) {
                $nationalCountry->warehouseCountry->warehouse->update(['api_key' => WarehouseIntegrationKeys::NATIONAL_WAREHOUSE]);
                $warehouse = $nationalCountry->warehouseCountry->warehouse;
            }
        } else {
            $warehouse = Warehouse::first();
            $warehouse->update(['api_key' => WarehouseIntegrationKeys::NATIONAL_WAREHOUSE]);
        }
        // now we make sure there is a warehouse has api_key == WarehouseIntegrationKeys::NATIONAL_WAREHOUSE
        Product::get()->each(function($product) use ($warehouse) {
            ProductWarehouseStock::updateOrCreate(
                ['product_id' => $product->id, 'warehouse_id' => $warehouse->id],
                ['stock' => $product->stock && $product->stock >= 0 ? $product->stock : 0]
            );
        });
        return Command::SUCCESS;
    }
}
